<?php

namespace App\Http\Controllers;

use App\Models\tracer\TracerJawaban;
use App\Models\tracer\TracerJawabanDetail;
use App\Models\tracer\TracerKota;
use App\Models\tracer\TracerNegara;
use App\Models\tracer\TracerPeriode;
use App\Models\tracer\TracerPertanyaan;
use App\Models\tracer\TracerProvinsi;
use App\Models\tracer\TracerResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TracerController extends Controller
{
  public function index()
  {
    $periode = TracerPeriode::where('aktif', true)->first();
    $negaras = TracerNegara::orderBy('nama')->get();
    $provinsis = TracerProvinsi::orderBy('nama')->get();
    $kotas = TracerKota::orderBy('nama')->get();

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

    return view('tracer.form', compact('periode', 'sections', 'negaras', 'provinsis', 'kotas'));
  }

//  public function simpan___(Request $request)
//  {
//    dd($request->input('jawaban'));
//    DB::beginTransaction();
//
//    try {
//
//      $periode = TracerPeriode::query()
//        ->where('aktif', 1)
//        ->first();
//
//      if (!$periode) {
//        throw new \Exception(
//          'Periode tracer aktif tidak ditemukan'
//        );
//      }
//
//      $responden = TracerResponden::updateOrCreate(
//        [
//          'periode_id' => $periode->id,
//          'nim' => auth()->user()->nim ?? $request->nim,
//        ],
//        [
//          'nama' => auth()->user()->name ?? $request->nama,
//          'status' => 'draft',
//        ]
//      );
//
//      $jawabans = $request->input('jawaban', []);
//
//      foreach ($jawabans as $kode => $nilai) {
//
//        if (
//          $nilai === null ||
//          $nilai === '' ||
//          $nilai === []
//        ) {
//          continue;
//        }
//
//        /*
//        |--------------------------------------------------------------------------
//        | Checkbox Multiple
//        |--------------------------------------------------------------------------
//        */
//        if (is_array($nilai)) {
//
//          $jawaban = TracerJawaban::updateOrCreate(
//            [
//              'responden_id' => $responden->id,
//              'kode_pertanyaan' => $kode,
//            ],
//            [
//              'jawaban' => json_encode($nilai),
//            ]
//          );
//
//          TracerJawabanDetail::where(
//            'jawaban_id',
//            $jawaban->id
//          )->delete();
//
//          foreach ($nilai as $item) {
//
//            TracerJawabanDetail::create([
//              'jawaban_id' => $jawaban->id,
//              'pilihan' => $item,
//            ]);
//          }
//        } /*
//        |--------------------------------------------------------------------------
//        | Single Value
//        |--------------------------------------------------------------------------
//        */
//        else {
//
//          $jawaban = TracerJawaban::updateOrCreate(
//            [
//              'responden_id' => $responden->id,
//              'kode_pertanyaan' => $kode,
//            ],
//            [
//              'jawaban' => $nilai,
//            ]
//          );
//
//          TracerJawabanDetail::where(
//            'jawaban_id',
//            $jawaban->id
//          )->delete();
//
//          TracerJawabanDetail::create([
//            'jawaban_id' => $jawaban->id,
//            'pilihan' => $nilai,
//          ]);
//        }
//      }
//
//      $responden->update([
//        'status' => 'selesai'
//      ]);
//
//      DB::commit();
//
//      return redirect()
//        ->back()
//        ->with(
//          'success',
//          'Tracer study berhasil disimpan.'
//        );
//
//    } catch (\Throwable $e) {
//
//      DB::rollBack();
//
//      report($e);
//
//      return redirect()
//        ->back()
//        ->with(
//          'error',
//          $e->getMessage()
//        );
//    }
//  }

  public function simpan(Request $request)
  {

    DB::beginTransaction();

    try {

      $periode = TracerPeriode::query()
        ->where('aktif', 1)
        ->first();

      if (!$periode) {
        throw new \Exception(
          'Periode tracer aktif tidak ditemukan.'
        );
      }

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

      $jawabans = $request->input('jawaban', []);

      foreach ($jawabans as $kode => $nilai) {

        /*
        |--------------------------------------------------------------------------
        | Jawaban kosong => hapus data lama
        |--------------------------------------------------------------------------
        */
        if (
          is_null($nilai) ||
          $nilai === '' ||
          $nilai === 'null' ||
          (is_array($nilai) && empty($nilai))
        ) {

          $jawabanLama = TracerJawaban::query()
            ->where('responden_id', $responden->id)
            ->where('kode_pertanyaan', $kode)
            ->first();

          if ($jawabanLama) {

            TracerJawabanDetail::query()
              ->where('jawaban_id', $jawabanLama->id)
              ->delete();

            $jawabanLama->delete();
          }

          continue;
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Header Jawaban
        |--------------------------------------------------------------------------
        */
        $jawaban = TracerJawaban::updateOrCreate(
          [
            'responden_id'    => $responden->id,
            'kode_pertanyaan' => $kode,
          ],
          [
            'jawaban' => is_array($nilai)
              ? json_encode($nilai)
              : $nilai,
          ]
        );

        /*
        |--------------------------------------------------------------------------
        | Hapus Detail Lama
        |--------------------------------------------------------------------------
        */
        TracerJawabanDetail::query()
          ->where('jawaban_id', $jawaban->id)
          ->delete();

        /*
        |--------------------------------------------------------------------------
        | Checkbox Multiple
        |--------------------------------------------------------------------------
        */
        if (is_array($nilai)) {

          foreach ($nilai as $item) {

            if (
              is_null($item) ||
              $item === '' ||
              $item === 'null'
            ) {
              continue;
            }

            TracerJawabanDetail::create([
              'jawaban_id' => $jawaban->id,
              'pilihan'    => $item,
            ]);
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Single Value
        |--------------------------------------------------------------------------
        */
        else {

          TracerJawabanDetail::create([
            'jawaban_id' => $jawaban->id,
            'pilihan'    => $nilai,
          ]);
        }
      }

      $responden->update([
        'status' => 'selesai',
        'tanggal_submit' => now(),
      ]);

      DB::commit();

      return redirect()
        ->back()
        ->with(
          'success',
          'Tracer study berhasil disimpan.'
        );

    } catch (\Throwable $e) {

      DB::rollBack();

      report($e);

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

  public function getKotas($provinsiId)
  {
    return response()->json(
      TracerKota::select(
        'kode',
        'nama'
      )->where(
        'provinsi_id',
        $provinsiId
      )
        ->orderBy('nama')
        ->get()

    );
  }
}
