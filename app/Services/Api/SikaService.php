<?php

namespace App\Services\Api;

use App\Models\DataPribadiAlumni;
use Illuminate\Support\Facades\Http;

class SikaService
{
    public function pushYudisium(string $masa, int $skId)
    {
        $baseUrl = 'https://api.sika.ika-ut.id';

        /*
        |--------------------------------------------------------------------------
        | 1. LOGIN SIKA
        |--------------------------------------------------------------------------
        */

        $login = Http::withoutVerifying()
            ->acceptJson()
            ->asJson()
            ->post($baseUrl . '/rest/api/login', [
                'username' => "alumni@ecampus.ut.ac.id",
                'password' => "Ut12345!",
                'expires_days' => 7,
            ]);
        if ($login->failed()) {
            return [
                'success' => false,
                'status' => $login->status(),
                'message' => 'Login ke SIKA gagal.',
                'response' => $login->json(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 2. AMBIL BEARER TOKEN
        |--------------------------------------------------------------------------
        |
        | Sesuaikan "token" apabila response login menggunakan:
        | access_token, data.token, dan sebagainya.
        |
        */

        $token = $login->json('token');

        if (empty($token)) {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Bearer token tidak ditemukan.',
                'response' => $login->json(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 3. AMBIL DATA ALUMNI
        |--------------------------------------------------------------------------
        */

        $items = DataPribadiAlumni::query()
            ->select([
                'nim',
                'nama_mahasiswa',
                'tempat_lahir',
                'tanggal_lahir',
                'kode_program_studi',
                'nama_program_studi',
                'nama_fakultas',
                'ipk',
                'kode_upbjj',
            ])
            ->where('masa_yudisium', $masa)
            ->orderBy('nim')
            ->get()
            ->map(function ($item) {
                return [
                    'nim' => $item->nim,
                    'nama' => $item->nama_mahasiswa,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'alamat' => $item->alamat,
                    'program_studi' => $item->nama_program_studi,
                    'fakultas' => $item->nama_fakultas,
                    'ipk_yudisium' => $item->ipk,
                    'ut_daerah' => $item->kode_upbjj,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | 4. SUSUN BODY JSON
        |--------------------------------------------------------------------------
        */

        $data = [
            'sk_id' => $skId,
            'items' => $items,
        ];

        /*
        |--------------------------------------------------------------------------
        | 5. PUSH KE API SIKA
        |--------------------------------------------------------------------------
        */

        $response = Http::withToken($token)
            ->acceptJson()
            ->asJson()
            ->timeout(120)
            ->post($baseUrl . '/rest/api/yudisium/bulk', $data);

        /*
        |--------------------------------------------------------------------------
        | 6. RETURN HASIL
        |--------------------------------------------------------------------------
        */

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'message' => $response->successful()
                ? 'Data berhasil dikirim ke SIKA.'
                : 'Data gagal dikirim ke SIKA.',
            'total' => $items->count(),
            'response' => $response->json(),
        ];
    }
}