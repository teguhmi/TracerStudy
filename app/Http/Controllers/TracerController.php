<?php

namespace App\Http\Controllers;

use App\Models\tracer\TracerJawaban;
use App\Models\tracer\TracerJawabanDetail;
use App\Models\tracer\TracerPeriode;
use App\Models\tracer\TracerPertanyaan;
use App\Models\tracer\TracerResponden;
use App\Models\tracer\TracerSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TracerController extends Controller
{
  public function index()
  {
    $periode = TracerPeriode::where('aktif', true)->first();
    $sections = TracerPertanyaan::query()
      ->select('tracer_pertanyaans.*')
      ->join(
        'tracer_sections',
        'tracer_sections.id',
        '=',
        'tracer_pertanyaans.section_id'
      )
      ->with([
        'section',
        'opsi' => function ($query) {
          $query->where('aktif', true)
            ->orderBy('urutan');
        }
      ])
      ->where('tracer_pertanyaans.aktif', true)
      ->orderBy('tracer_pertanyaans.urutan')
      ->get();

    return view('tracer.form', compact(
      'periode',
      'sections'
    ));
  }

  public function simpan(Request $request)
  {
    DB::beginTransaction();

    try {

      $periode = TracerPeriode::where('aktif', true)->firstOrFail();

      $responden = TracerResponden::updateOrCreate(
        [
          'periode_id' => $periode->id,
          'nim' => auth()->user()->nim ?? $request->nim,
        ],
        [
          'nama' => auth()->user()->name ?? $request->nama,
          'status' => 'draft',
        ]
      );

      foreach ($request->except([
        '_token',
        'nim',
        'nama'
      ]) as $kode => $nilai) {

        if (is_array($nilai)) {

          $jawaban = TracerJawaban::updateOrCreate(
            [
              'responden_id' => $responden->id,
              'kode_pertanyaan' => $kode,
            ],
            [
              'jawaban' => json_encode($nilai),
            ]
          );

          TracerJawabanDetail::where(
            'jawaban_id',
            $jawaban->id
          )->delete();

          foreach ($nilai as $item) {

            TracerJawabanDetail::create([
              'jawaban_id' => $jawaban->id,
              'pilihan' => $item
            ]);
          }

        } else {

          TracerJawaban::updateOrCreate(
            [
              'responden_id' => $responden->id,
              'kode_pertanyaan' => $kode,
            ],
            [
              'jawaban' => $nilai,
            ]
          );
        }
      }

      DB::commit();

      return redirect()
        ->back()
        ->with(
          'success',
          'Draft tracer berhasil disimpan.'
        );

    } catch (\Exception $e) {

      DB::rollBack();

      return redirect()
        ->back()
        ->with(
          'error',
          $e->getMessage()
        );
    }
  }

  public function submit(Request $request)
  {
    $periode = TracerPeriode::where(
      'aktif',
      true
    )->firstOrFail();

    $responden = TracerResponden::where(
      'periode_id',
      $periode->id
    )
      ->where(
        'nim',
        auth()->user()->nim ?? $request->nim
      )
      ->firstOrFail();

    $responden->update([
      'tanggal_submit' => now(),
      'status' => 'submitted',
    ]);

    return redirect()
      ->back()
      ->with(
        'success',
        'Tracer Study berhasil dikirim.'
      );
  }

  public function riwayat()
  {
    $responden = TracerResponden::with([
      'jawabans.details'
    ])
      ->where(
        'nim',
        auth()->user()->nim
      )
      ->latest()
      ->first();

    return view(
      'tracer.riwayat',
      compact('responden')
    );
  }


}
