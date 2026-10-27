<?php

namespace App\Http\Controllers;

use App\Models\query\QueryAKSIModel;
use App\Models\tracer\TracerJawaban;
use App\Models\tracer\TracerKota;
use App\Models\tracer\TracerNegara;
use App\Models\tracer\TracerPeriode;
use App\Models\tracer\TracerPertanyaan;
use App\Models\tracer\TracerProvinsi;
use App\Models\tracer\TracerResponden;
use Exception;
//use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
//use Illuminate\Validation\Rule;
class TracerController extends Controller
{
  public function index()
  {
    if (!session('alumni_authenticated')) {
      return redirect()->route('login-alumni');
    }

    $nimAlumni = Crypt::encrypt(session('nim'));
    $dpAlumni = QueryAKSIModel::getYudisiumByNim(session('nim'));

    $periode = TracerPeriode::where('aktif', true)->first();
    $negaras = TracerNegara::orderBy('nama')->get();
    $provinsis = TracerProvinsi::orderBy('nama')->get();
    $kotas = TracerKota::orderBy('nama')->get();

    $jawabanLama = [];

    $lastResponden = TracerResponden::where([
      'nim'        => session('nim'),
      'periode_id' => $periode?->id,
    ])->first();
    $valueBio05 = $lastResponden?->negara_id;
    $valueBio06 = $lastResponden?->provinsi_id;
    $valueBio07 = $lastResponden?->kabupaten_id;

    if ($lastResponden) {

      $jawabanLama = TracerJawaban::where(
        'responden_id',
        $lastResponden->id
      )
        ->pluck(
          'jawaban',
          'kode_pertanyaan'
        )
        ->toArray();
    }
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


//    if ($dpAlumni) {
//      $nimAlumni = Crypt::encrypt(session('nim'));
//    }
    return view('tracer.form', compact(
      'periode', 'sections', 'negaras',
      'provinsis', 'kotas', 'dpAlumni', 'nimAlumni','jawabanLama',
    'valueBio05',
        'valueBio06',
        'valueBio07'));
  }


  public function store(Request $request)
  {
    // Ambil NIM dari session
    $nim = session('nim');
    if (!$nim) {
      return redirect()
        ->route('login')
        ->with('error', 'Sesi telah berakhir. Silakan login kembali.');
    }

    // Data alumni dari AKSI
    $dpAlumni = QueryAKSIModel::getYudisiumByNim($nim);

    if (!$dpAlumni) {
      return redirect()
        ->route('home')
        ->with('error', 'Data alumni tidak ditemukan.');
    }

    // Validasi aksi
    $aksi = $request->input('aksi', 'draft');

    if (!in_array($aksi, ['draft', 'submit'])) {
      $aksi = 'draft';
    }


    DB::beginTransaction();

    try {

      /*
      |--------------------------------------------------------------------------
      | Periode Aktif
      |--------------------------------------------------------------------------
      */

//      $periodeId = $periode->id;

      // Jika sudah punya tabel periode aktif gunakan:

      $periode = TracerPeriode::where('aktif', 1)->first();

      if (!$periode) {
          throw new \Exception('Periode tracer aktif tidak ditemukan.');
      }

      $periodeId = $periode->id;

      $lastResponden = TracerResponden::where([
        'nim'        => $nim,
        'periode_id' => $periodeId,
      ])->first();

//      if (
//        $aksi === 'submit' &&
//        $lastResponden &&
//        $lastResponden->status === 'submitted'
//      ) {
//        return back()->with(
//          'error',
//          'Tracer Study sudah pernah dikirim.'
//        );
//      }

      $valueBio01 = $lastResponden?->npwp;
      $valueBio02 = $lastResponden?->email;
      $valueBio03 = $lastResponden?->no_hp;
      $valueBio04 = $lastResponden?->alamat_lengkap;
      $valueBio05 = $lastResponden?->negara_id;
      $valueBio06 = $lastResponden?->provinsi_id;
      $valueBio07 = $lastResponden?->kabupaten_id;
      /*
      |--------------------------------------------------------------------------
      | Responden
      |--------------------------------------------------------------------------
      */
      $negaraId = $request->input('jawaban.BIO05');
      $provinsiId = $request->input('jawaban.BIO06');
      $kabupatenId = $request->input('jawaban.BIO07');

      if ($negaraId) {

        $negaraValid = TracerNegara::where(
          'id',
          $negaraId
        )->exists();

        if (!$negaraValid) {
          throw new Exception(
            'Negara tidak valid.'
          );
        }
      }
      if ($provinsiId) {

        $kodeNegara = TracerNegara::where(
          'id',
          $negaraId
        )->value('kode');

        if (!$kodeNegara) {
          throw new Exception(
            'Provinsi tidak sesuai dengan negara.'
          );
        }
      }

      if ($kabupatenId) {
        TracerKota::where(
          'id',
          $kabupatenId
        )
          ->where(
            'provinsi_id',
            $provinsiId
          )
          ->exists();

        if (!$kabupatenId) {
          throw new Exception(
            'Kabupaten/Kota tidak sesuai dengan provinsi.'
          );
        }
      }



      $responden = TracerResponden::updateOrCreate(
        [
          'nim'        => $dpAlumni->nim,
          'periode_id' => $periodeId,
        ],
        [
          'nama'           => $dpAlumni->nama_mahasiswa,
          'tanggal_lulus'  => $dpAlumni->tanggal_sk,

          'npwp'           => $request->input('jawaban.BIO01', $valueBio01),
          'email'          => $request->input('jawaban.BIO02', $valueBio02),
          'no_hp'          => $request->input('jawaban.BIO03', $valueBio03),
          'alamat_lengkap' => $request->input('jawaban.BIO04', $valueBio04),
          'negara_id'      => $request->input('jawaban.BIO05', $valueBio05),
          'provinsi_id'    => $request->input('jawaban.BIO06', $valueBio06),
          'kabupaten_id'   => $request->input('jawaban.BIO07', $valueBio07),
          'tanggal_mulai' => $lastResponden?->tanggal_mulai ?? now(),
          'status'         => 'draft',
        ]
      );

      if (!$responden) {
        throw new Exception('Data responden tidak ditemukan.');
      }

      /*
      |--------------------------------------------------------------------------
      | Daftar Pertanyaan Aktif
      |--------------------------------------------------------------------------
      */
      $pertanyaans = TracerPertanyaan::where('aktif', 1)
        ->orderBy('urutan')
        ->get();

      foreach ($pertanyaans as $pertanyaan) {

// Ambil jawaban dulu
        $nilai = $request->input(
          'jawaban.' . $pertanyaan->kode,
          null
        );

        // Validasi pilihan radio/select
        if (
          !is_array($nilai) &&
          !empty($nilai) &&
          in_array(
            $pertanyaan->jenis,
            ['radio', 'select']
          ) &&
          !in_array(
            $pertanyaan->kode,
            ['BIO05', 'BIO06', 'BIO07','F5A0','F5A1','F5A2']
          )

        ) {

          $opsiValid = $pertanyaan
            ->opsi()
            ->where('nilai', $nilai)
            ->exists();

          if (!$opsiValid) {
            throw new Exception(
              '[' . $pertanyaan->kode . '] pilihan tidak valid'
            );
          }
        }
        /*
        |--------------------------------------------------------------------------
        | Rule tampil_jika
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

            // wildcard *
            if (
              count($allowed) === 1
              && $allowed[0] === '*'
            ) {

              if (is_array($nilaiParent)) {

                if (count($nilaiParent) === 0) {
                  $tampil = false;
                  break;
                }
              } else {

                if (
                  $nilaiParent === null
                  || $nilaiParent === ''
                ) {
                  $tampil = false;
                  break;
                }
              }

              continue;
            }

            // checkbox
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
        | Jika Tidak Tampil
        |--------------------------------------------------------------------------
        */
        if (!$tampil) {
          $nilai = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Sanitasi Input
        |--------------------------------------------------------------------------
        */
        if (is_array($nilai)) {

          if (count($nilai) > 50) {
            throw new Exception(
              '[' . $pertanyaan->kode . '] data tidak valid'
            );
          }

          $nilai = collect($nilai)
            ->map(function ($v) {
              return trim(strip_tags((string)$v));
            })
            ->filter()
            ->values()
            ->toArray();

          if ($pertanyaan->jenis === 'checkbox') {

            $opsiValid = $pertanyaan
              ->opsi()
              ->pluck('nilai')
              ->map(fn ($x) => (string)$x)
              ->toArray();

            foreach ($nilai as $item) {

              if (!in_array((string)$item, $opsiValid)) {

                throw new Exception(
                  '[' . $pertanyaan->kode . '] pilihan tidak valid'
                );
              }
            }
          }


        } else {

          $nilai = is_null($nilai)
            ? null
            : trim(strip_tags((string)$nilai));

          if (
            !is_null($nilai)
            && strlen($nilai) > 5000
          ) {
            throw new Exception(
              '[' . $pertanyaan->kode . '] data terlalu panjang'
            );
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Wajib Saat Submit
        |--------------------------------------------------------------------------
        */
        if (
          $aksi === 'submit'
          && $pertanyaan->wajib
          && $tampil
        ) {

          $kosong =
            $nilai === null
            || $nilai === ''
            || (is_array($nilai) && count($nilai) === 0);

          if ($kosong) {

            throw new Exception(
              '[' . $pertanyaan->kode . '] '
              . $pertanyaan->pertanyaan
              . ' wajib diisi'
            );
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi F505
        |--------------------------------------------------------------------------
        */
        if ($pertanyaan->kode === 'F505' && !empty($nilai)) {

          $angka = preg_replace(
            '/[^0-9]/',
            '',
            (string)$nilai
          );

          if (
            $angka === '' ||
            !ctype_digit($angka) ||
            strlen($angka) > 12
          ) {
            throw new Exception(
              '[F505] Pendapatan tidak valid'
            );
          }

          $nilai = $angka;
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
              ? json_encode(
                $nilai,
                JSON_UNESCAPED_UNICODE
              )
              : $nilai,
          ]
        );
      }

      /*
      |--------------------------------------------------------------------------
      | Update Status
      |--------------------------------------------------------------------------
      */
      if ($aksi === 'submit') {

        $responden->update([
          'status'         => 'submitted',
          'tanggal_submit' => now(),
        ]);

        $message = 'Tracer berhasil dikirim';

      } else {

        // hanya draft
        $responden->update([
          'status' => 'draft',
        ]);

        $message = 'Draft berhasil disimpan';
      }


      DB::commit();

      return view('tracer.tracer_submit', [
        'responden' => $responden,
        'message' => $message,
      ]);
    }
    catch (\Throwable $e) {

      DB::rollBack();

      dd([
        'message' => $e->getMessage(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
      ]);
    }

//      Log::error('Tracer Error', [
//        'nim' => $nim,
//        'message' => $e->getMessage(),
//        'file' => $e->getFile(),
//        'line' => $e->getLine(),
//      ]);
//
//      return back()
//        ->withInput()
//        ->with(
//          'error',
//          'Terjadi kesalahan saat menyimpan data.'
//        );
//    }

  }


//  public function submit(Request $request)
//  {
//    $nim = session('nim');
//    $periode = TracerPeriode::where(
//      'aktif',
//      true
//    )->firstOrFail();
//
//    $responden = TracerResponden::where('periode_id', $periode->id)->where('nim', $nim)->firstOrFail();
//
//    $responden->update([
//      'tanggal_submit' => now(),
//      'status' => 'submitted',
//    ]);
//
//    return view('tracer.tracer_submit', [
//      'responden' => $responden,
//    ]);
//  }

//  public function riwayat()
//  {
//
//    $responden = TracerResponden::with([
//      'jawabans.details'
//    ])
//      ->where('nim', session('nim'))->latest()->first();
//
//    return view(
//      'tracer.riwayat',
//      compact('responden')
//    );
//  }

  public function getKotas($provinsiId)
  {
    if (!session('alumni_authenticated')) {
      abort(401);
    }

    if (!is_numeric($provinsiId)) {
      abort(400);
    }
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
