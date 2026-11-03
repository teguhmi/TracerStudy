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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TracerController extends Controller
{
  public function index()
  {
    if (!session('alumni_authenticated')) {
      return redirect()->route('login-alumni');
    }

    $nim = session('nim');
    $nimAlumni = Crypt::encrypt($nim);
    $dpAlumni = QueryAKSIModel::getYudisiumByNim($nim);

    $periode = TracerPeriode::where('aktif', true)->first();
    $negaras = TracerNegara::orderBy('nama')->get();
    $provinsis = TracerProvinsi::orderBy('nama')->get();
    $kotas = TracerKota::orderBy('nama')->get();

    $jawabanLama = [];
    $valueBio05 = null;
    $valueBio06 = null;
    $valueBio07 = null;

    if ($periode) {
      $lastResponden = TracerResponden::where([
        'nim' => $nim,
        'periode_id' => $periode->id,
      ])->first();

      if ($lastResponden) {
        $valueBio05 = $lastResponden->negara_id;
        $valueBio06 = $lastResponden->provinsi_id;
        $valueBio07 = $lastResponden->kabupaten_id;

        $jawabanLama = TracerJawaban::where('responden_id', $lastResponden->id)
          ->pluck('jawaban', 'kode_pertanyaan')
          ->toArray();
      }
    }

    $sections = TracerPertanyaan::query()
      ->select('tracer_pertanyaans.*')
      ->join('tracer_sections', 'tracer_sections.id', '=', 'tracer_pertanyaans.section_id')
      ->with([
        'section',
        'opsi' => function ($query) {
          $query->where('aktif', true)->orderBy('urutan');
        }
      ])
      ->where('tracer_pertanyaans.aktif', true)
      ->orderBy('tracer_pertanyaans.urutan')
      ->get();

    return view('tracer.form', compact(
      'periode',
      'sections',
      'negaras',
      'provinsis',
      'kotas',
      'dpAlumni',
      'nimAlumni',
      'jawabanLama',
      'valueBio05',
      'valueBio06',
      'valueBio07'
    ));
  }

  public function store(Request $request)
  {
    $nim = session('nim');
    if (!$nim) {
      return redirect()
        ->route('login-alumni')
        ->with('error', 'Sesi telah berakhir. Silakan login kembali.');
    }

    $dpAlumni = QueryAKSIModel::getYudisiumByNim($nim);
    if (!$dpAlumni) {
      return redirect()
        ->route('home')
        ->with('error', 'Data alumni tidak ditemukan.');
    }

    $aksi = $request->input('aksi', 'draft');
    if (!in_array($aksi, ['draft', 'submit'])) {
      $aksi = 'draft';
    }

    DB::beginTransaction();

    try {
      $periode = TracerPeriode::where('aktif', true)->first();
      if (!$periode) {
        throw new Exception('Periode tracer aktif tidak ditemukan.');
      }

      $periodeId = $periode->id;

      $lastResponden = TracerResponden::where([
        'nim' => $nim,
        'periode_id' => $periodeId,
      ])->first();

      // Cegah pengiriman ulang jika sudah submitted
      if ($aksi === 'submit' && $lastResponden && $lastResponden->status === 'submitted') {
        DB::rollBack();
        return back()->with('error', 'Tracer Study sudah pernah dikirim.');
      }

      $valueBio01 = $lastResponden?->npwp;
      $valueBio02 = $lastResponden?->email;
      $valueBio03 = $lastResponden?->no_hp;
      $valueBio04 = $lastResponden?->alamat_lengkap;
      $valueBio05 = $lastResponden?->negara_id;
      $valueBio06 = $lastResponden?->provinsi_id;
      $valueBio07 = $lastResponden?->kabupaten_id;

      /*
      |--------------------------------------------------------------------------
      | Validasi Data Wilayah (BIO05, BIO06, BIO07)
      |--------------------------------------------------------------------------
      */
      $negaraId = $request->input('jawaban.BIO05');
      $provinsiId = $request->input('jawaban.BIO06');
      $kabupatenId = $request->input('jawaban.BIO07');

      if ($negaraId) {
        $negaraValid = TracerNegara::where('id', $negaraId)->exists();
        if (!$negaraValid) {
          throw new Exception('Negara tidak valid.');
        }
      }

      if ($provinsiId) {
        $provinsiValid = TracerProvinsi::where('id', $provinsiId)->exists();
        if (!$provinsiValid) {
          throw new Exception('Provinsi tidak valid.');
        }
      }

      if ($kabupatenId) {
        $kabupatenValid = TracerKota::where('id', $kabupatenId)
          ->where('provinsi_id', $provinsiId)
          ->exists();

        if (!$kabupatenValid) {
          throw new Exception('Kabupaten/Kota tidak sesuai dengan provinsi yang dipilih.');
        }
      }

      /*
      |--------------------------------------------------------------------------
      | Simpan / Update Responden
      |--------------------------------------------------------------------------
      */
      $responden = TracerResponden::updateOrCreate(
        [
          'nim' => $dpAlumni->nim,
          'periode_id' => $periodeId,
        ],
        [
          'nama' => $dpAlumni->nama_mahasiswa,
          'tanggal_lulus' => $dpAlumni->tanggal_sk,
          'npwp' => $request->input('jawaban.BIO01', $valueBio01),
          'email' => $request->input('jawaban.BIO02', $valueBio02),
          'no_hp' => $request->input('jawaban.BIO03', $valueBio03),
          'alamat_lengkap' => $request->input('jawaban.BIO04', $valueBio04),
          'negara_id' => $request->input('jawaban.BIO05', $valueBio05),
          'provinsi_id' => $request->input('jawaban.BIO06', $valueBio06),
          'kabupaten_id' => $request->input('jawaban.BIO07', $valueBio07),
          'tanggal_mulai' => $lastResponden?->tanggal_mulai ?? now(),
          'status' => 'draft',
        ]
      );

      if (!$responden) {
        throw new Exception('Data responden gagal dibuat.');
      }

      /*
      |--------------------------------------------------------------------------
      | Evaluasi Pertanyaan & Aturan tampil_jika
      |--------------------------------------------------------------------------
      */
      $pertanyaans = TracerPertanyaan::where('aktif', true)
        ->orderBy('urutan')
        ->get();

      foreach ($pertanyaans as $pertanyaan) {
        $nilai = $request->input('jawaban.' . $pertanyaan->kode, null);

        // Validasi pilihan radio/select
        if (
          !is_array($nilai) &&
          !empty($nilai) &&
          in_array($pertanyaan->jenis, ['radio', 'select']) &&
          !in_array($pertanyaan->kode, ['BIO05', 'BIO06', 'BIO07', 'F5A0', 'F5A1', 'F5A2'])
        ) {
          $opsiValid = $pertanyaan->opsi()
            ->where('nilai', $nilai)
            ->exists();

          if (!$opsiValid) {
            throw new Exception('[' . $pertanyaan->kode . '] Pilihan tidak valid.');
          }
        }

        // Evaluasi Rule tampil_jika
        $tampil = true;
        $rules = $pertanyaan->tampil_jika ?? [];

        if (is_string($rules)) {
          $rules = json_decode($rules, true) ?? [];
        }

        if (!empty($rules)) {
          foreach ($rules as $field => $allowed) {
            $nilaiParent = $request->input('jawaban.' . $field);

            // Wildcard * (asal terisi)
            if (count($allowed) === 1 && $allowed[0] === '*') {
              if (is_array($nilaiParent)) {
                if (count($nilaiParent) === 0) {
                  $tampil = false;
                  break;
                }
              } else {
                if ($nilaiParent === null || $nilaiParent === '') {
                  $tampil = false;
                  break;
                }
              }
              continue;
            }

            // Checkbox (Parent berupa Array)
            if (is_array($nilaiParent)) {
              $match = false;
              foreach ($nilaiParent as $item) {
                if (in_array((string)$item, array_map('strval', $allowed))) {
                  $match = true;
                  break;
                }
              }
              if (!$match) {
                $tampil = false;
                break;
              }
            } else {
              // Radio / Select / Text (Parent berupa String/Scalar)
              if (!in_array((string)$nilaiParent, array_map('strval', $allowed))) {
                $tampil = false;
                break;
              }
            }
          }
        }

        // Jika pertanyaan tidak tampil berdasarkan rule, reset jawaban ke null
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
            throw new Exception('[' . $pertanyaan->kode . '] Data terlalu banyak.');
          }

          $nilai = collect($nilai)
            ->map(fn($v) => trim(strip_tags((string)$v)))
            ->filter(fn($v) => $v !== '')
            ->values()
            ->toArray();

          if ($pertanyaan->jenis === 'checkbox') {
            $opsiValid = $pertanyaan->opsi()
              ->pluck('nilai')
              ->map(fn($x) => (string)$x)
              ->toArray();

            foreach ($nilai as $item) {
              if (!in_array((string)$item, $opsiValid)) {
                throw new Exception('[' . $pertanyaan->kode . '] Opsi checkbox tidak valid.');
              }
            }
          }
        } else {
          $nilai = is_null($nilai) ? null : trim(strip_tags((string)$nilai));

          if (!is_null($nilai) && strlen($nilai) > 5000) {
            throw new Exception('[' . $pertanyaan->kode . '] Teks terlalu panjang.');
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Wajib Saat Submit
        |--------------------------------------------------------------------------
        */
        if ($aksi === 'submit' && $pertanyaan->wajib && $tampil) {
          $kosong = $nilai === null || $nilai === '' || (is_array($nilai) && count($nilai) === 0);
          if ($kosong) {
            throw new Exception('[' . $pertanyaan->kode . '] ' . $pertanyaan->pertanyaan . ' wajib diisi.');
          }
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi Khusus F505 (Pendapatan)
        |--------------------------------------------------------------------------
        */
        if ($pertanyaan->kode === 'F505' && !empty($nilai)) {
          $angka = preg_replace('/[^0-9]/', '', (string)$nilai);

          if ($angka === '' || !ctype_digit($angka) || strlen($angka) > 12) {
            throw new Exception('[F505] Format pendapatan tidak valid.');
          }

          $nilai = $angka;
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Jawaban ke Database
        |--------------------------------------------------------------------------
        */
        TracerJawaban::updateOrCreate(
          [
            'responden_id' => $responden->id,
            'kode_pertanyaan' => $pertanyaan->kode,
          ],
          [
            'pertanyaan_id' => $pertanyaan->id,
            'jawaban' => is_array($nilai)
              ? json_encode($nilai, JSON_UNESCAPED_UNICODE)
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
        $message = 'Tracer Study berhasil dikirim.';
      } else {
        $responden->update([
          'status' => 'draft',
        ]);
        $message = 'Draft berhasil disimpan.';
      }

      DB::commit();

      return view('tracer.tracer_submit', compact('responden', 'message'));

    } catch (\Throwable $e) {
      DB::rollBack();

      Log::error('Tracer Store Error', [
        'nim' => $nim,
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
      ]);

      return back()
        ->withInput()
        ->with('error', $e->getMessage());
    }
  }

  public function getKotas($provinsiId)
  {
    if (!session('alumni_authenticated')) {
      abort(401, 'Unauthorized');
    }

    if (!is_numeric($provinsiId)) {
      abort(400, 'Bad Request');
    }

    return response()->json(
      TracerKota::select('kode', 'nama')
        ->where('provinsi_id', $provinsiId)
        ->orderBy('nama')
        ->get()
    );
  }
}
