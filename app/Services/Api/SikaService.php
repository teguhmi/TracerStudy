<?php

namespace App\Services\Api;

use App\Models\DataPribadiAlumni;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SikaService
{
    /**
     * @throws ConnectionException
     */
    public function pushYudisium(string $masa, int $skId)
    {
        $baseUrl = 'https://api.sika.ika-ut.id';

        /*
        |--------------------------------------------------------------------------
        | 1. LOGIN SIKA
        |--------------------------------------------------------------------------
        */

        $login = Http::withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->post($baseUrl . '/rest/api/auth/token', [
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

        $token = $login->json('access_token');
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
                'masa',
                'nomor_sk_rektor',
                'nim',
                'nama_mahasiswa',
                'kode_program_studi',
                'nama_singkat_ps',
                'ipk',
                'nama_jenjang',
                'nama_fakultas',
                'singkatan',
                'kode_upbjj',
                'nama_upbjj',
            ])
            ->where('masa_yudisium', $masa)
            ->orderBy('nim')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'masa' => $item->masa_yudisium,
                    'nomor_sk_rektor' => $item->nomor_sk_rektor,
                    'nim' => $item->nim,
                    'nama_mahasiswa' => $item->nama_mahasiswa,
                    'kode_program_studi' => $item->kode_program_studi,
                    'nama_singkat_ps' => $item->nama_singkat_ps,
                    'ipk' => $item->ipk,
                    'nama_jenjang' => $item->nama_fakultas,
                    'nama_fakultas' => $item->nama_fakultas,
                    'singkatan' => $item->singkatan,
                    'kode_upbjj' => $item->ipk,
                    'nama_upbjj' => $item->kode_upbjj,
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
        dd($data);
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