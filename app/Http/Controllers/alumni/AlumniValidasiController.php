<?php

namespace App\Http\Controllers\alumni;

use App\Http\Controllers\Controller;
use App\Models\DataPribadiAlumni;
use App\Services\Api\AlumniService;
use App\Services\Api\SikaService;
use Illuminate\Support\Facades\Crypt;

class AlumniValidasiController extends Controller
{
    public function __construct(
        protected AlumniService $alumniService,
        private SikaService $sikaService
    )
    {
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Data Alumni
        |--------------------------------------------------------------------------
        */

        $dpAlumni = $this->alumniService->current();


        /*
        |--------------------------------------------------------------------------
        | Data Form
        |--------------------------------------------------------------------------
        */

        $form = (object)[
            'nim' => $dpAlumni->nim,
            'nama' => $dpAlumni->nama_mahasiswa,
            'tempat_lahir' => $dpAlumni->tempat_lahir,
            'tanggal_lahir' => $dpAlumni->tanggal_lahir,
            'jenis_kelamin' => $dpAlumni->jenis_kelamin,
            'nik' => $dpAlumni->nik,
            'nomor_hp' => $dpAlumni->nomor_hp ?? '',
            'nomor_wa' => $dpAlumni->nomor_wa ?? '',
        ];


        /*
        |--------------------------------------------------------------------------
        | Status Surat Pernyataan
        |--------------------------------------------------------------------------
        */

        $flagSurat = (int)($dpAlumni->flag_surat ?? 0);


        /*
        |--------------------------------------------------------------------------
        | Encrypt NIM
        |--------------------------------------------------------------------------
        */

        $encryptedNim = Crypt::encryptString($dpAlumni->nim);


        /*
        |--------------------------------------------------------------------------
        | Data Surat Pernyataan
        |--------------------------------------------------------------------------
        */

        $surat = (object)[
            'status' => $flagSurat,

            'sudah_upload' => $flagSurat === 1,

            'view_form' => route('alumni-validasi.index', [
                'nim' => $encryptedNim,
                'jenis' => 'SuratPernyataan',
            ]),

            'view_pdf' => $flagSurat === 1
                ? route('alumni-validasi.view-pdf', [
                    'nim' => $encryptedNim,
                    'jenis' => 'ViewPDF',
                ])
                : null,
        ];


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'content.pages.alumni-dashboard.Form_ValidasiDP',
            compact(
                'dpAlumni',
                'form',
                'surat', 'encryptedNim'
            )
        );
    }

    public function data_sika()
    {
        $masa = '20261';
        $skId = 1;

        $result = $this->sikaService->pushYudisium($masa, $skId);

        return response()->json(
            $result,
            $result['status']
        );
    }
}
