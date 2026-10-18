<?php

namespace App\Http\Controllers;

use App\Models\query\QueryAKSIModel;
use App\Models\tracer\TracerJawaban;
use App\Models\tracer\TracerJawabanDetail;
use App\Models\tracer\TracerKota;
use App\Models\tracer\TracerNegara;
use App\Models\tracer\TracerPeriode;
use App\Models\tracer\TracerPertanyaan;
use App\Models\tracer\TracerProvinsi;
use App\Models\tracer\TracerResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TracerController extends Controller
{
  public function index()
  {
    if (!session('alumni_authenticated')) {
      return redirect()->route('login-alumni');
    }
    $dpAlumni = QueryAKSIModel::getYudisiumByNim(session('nim'));

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
    if ($dpAlumni) {
      $nimAlumni = Crypt::encrypt($dpAlumni->nim);
    }
    return view('tracer.form', compact('periode', 'sections', 'negaras', 'provinsis', 'kotas', 'dpAlumni', 'nimAlumni'));
  }


  public function store(Request $request)
  {
    $nim=decrypt($request->nim);
    $dpAlumni = QueryAKSIModel::getYudisiumByNim($nim);
    DB::beginTransaction();

    if (!$dpAlumni) {
      return redirect()->route('home');
    }
    try {

      $aksi = $request->input('aksi', 'draft');
      $responden = TracerResponden::firstOrCreate(
        [
          'nim' => $dpAlumni->nim,
          'periode_id' => 1,
        ],
        [
          'nama' => $dpAlumni->nama_mahasiswa,
          'tanggal_lulus' => $dpAlumni->tanggal_sk,
          'tanggal_mulai' => now(),
          'tanggal_submit' => now(),
          'status' => 'draft',
        ]
      );
      if (!$responden) {
        throw new \Exception('Data responden tidak ditemukan');
      }

      $pertanyaans = TracerPertanyaan::where('aktif', 1)
        ->orderBy('urutan')
        ->get();
      $no = 0;
      foreach ($pertanyaans as $pertanyaan) {

        $nilai = $request->input(
          'jawaban.' . $pertanyaan->kode,
          null
        );
        /*
        |--------------------------------------------------------------------------
        | Evaluasi Rule tampil_jika
        |--------------------------------------------------------------------------
        */
        $tampil = true;

        $rules = $pertanyaan->tampil_jika ?? [];

        if (is_string($rules)) {
          $rules = json_decode($rules, true) ?? [];
        }

        if (!empty($rules)) {

          foreach ($rules as $field => $allowed) {

            $nilaiParent = $request->input(
              'jawaban.' . $field
            );

            /*
            |--------------------------------------------------------------------------
            | Wildcard *
            |--------------------------------------------------------------------------
            */
            if (
              count($allowed) === 1 &&
              $allowed[0] === '*'
            ) {

              if (is_array($nilaiParent)) {

                if (count($nilaiParent) === 0) {
                  $tampil = false;
                  break;
                }

              } else {

                if (
                  $nilaiParent === null ||
                  $nilaiParent === ''
                ) {
                  $tampil = false;
                  break;
                }

              }

              continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Checkbox
            |--------------------------------------------------------------------------
            */
            if (is_array($nilaiParent)) {

              $match = false;

              foreach ($nilaiParent as $item) {

                if (
                  in_array(
                    (string)$item,
                    array_map('strval', $allowed)
                  )
                ) {
                  $match = true;
                  break;
                }
              }

              if (!$match) {
                $tampil = false;
                break;
              }

            } else {

              if (
                !in_array(
                  (string)$nilaiParent,
                  array_map('strval', $allowed)
                )
              ) {
                $tampil = false;
                break;
              }
            }
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Jika rule tidak terpenuhi
        |--------------------------------------------------------------------------
        */
        if (!$tampil) {
          $nilai = null;
        }
        /*
        |--------------------------------------------------------------------------
        | Validasi Wajib
        | Hanya saat submit final
        |--------------------------------------------------------------------------
        */
        if (
          $aksi === 'submit' &&
          $pertanyaan->wajib &&
          $tampil
        ) {

          $kosong =
            $nilai === null ||
            $nilai === '' ||
            (is_array($nilai) && count($nilai) === 0);

          if ($kosong) {

            throw new \Exception(
              '[' . $pertanyaan->kode . '] '
              . $pertanyaan->pertanyaan
              . ' wajib diisi'
            );

          }
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Jawaban
        |--------------------------------------------------------------------------
        */

        TracerJawaban::updateOrCreate(
          [
            'responden_id' => $responden->id,
            'pertanyaan_id' => $pertanyaan->id,
          ],
          [
            'kode_pertanyaan' => $pertanyaan->kode,
            'jawaban' => is_array($nilai)
              ? json_encode($nilai)
              : $nilai,
          ]
        );
      }

      /*
      |--------------------------------------------------------------------------
      | Update Status Responden
      |--------------------------------------------------------------------------
      */
      if ($aksi === 'submit') {

        $responden->update([
          'status' => 'submitted',
          'tanggal_submit' => now(),
        ]);

        $message = 'Tracer berhasil dikirim';

      } else {

        $responden->update([
          'status' => 'draft',
        ]);

        $message = 'Draft berhasil disimpan';
      }

      DB::commit();

      return view('tracer.tracer_submit');
//      return view('tracer.tracer_submit', [
//        'responden' => $responden,
//      ]);

    } catch (\Exception $e) {
      DB::rollBack();
      dd($e->getMessage());

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

    return view('tracer.tracer_submit', [
      'responden' => $responden,
    ]);
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
