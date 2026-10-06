<?php

namespace App\Services\Api;

use App\Models\DataPribadiAlumni;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class SikaService
{
    /**
     * Push data yudisium ke SIKA.
     *
     * Data dikirim maksimal 2000 per batch.
     *
     * @throws ConnectionException
     */
    public function pushYudisium(string $masa): array
    {
        $baseUrl = config('services.sika.base_url');

        /*
        |--------------------------------------------------------------------------
        | 1. LOGIN SIKA
        |--------------------------------------------------------------------------
        */

        $login = Http::withoutVerifying()
            ->acceptJson()
            ->asJson()
            ->post($baseUrl . '/rest/api/auth/token', [
                'username' => config('services.sika.username'),
                'password' => config('services.sika.password'),
                'expires_days' => 7,
            ]);

        /*
        |--------------------------------------------------------------------------
        | 2. CEK LOGIN
        |--------------------------------------------------------------------------
        */

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
        | 3. AMBIL BEARER TOKEN
        |--------------------------------------------------------------------------
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
        | 4. INISIALISASI PROSES
        |--------------------------------------------------------------------------
        */

        $batch = 0;
        $totalBerhasil = 0;

        /*
        |--------------------------------------------------------------------------
        | 5. PROSES DATA PER 2000
        |--------------------------------------------------------------------------
        */

        while (true) {

            /*
            |--------------------------------------------------------------------------
            | Ambil maksimal 2000 data yang belum dikirim
            |--------------------------------------------------------------------------
            */

            $items = DataPribadiAlumni::query()
                ->select([
                    'masa_yudisium',
                    'nomor_sk_rektor',
                    'nim',
                    'nama_mahasiswa',
                    'kode_program_studi',
                    'nama_singkat_ps',
                    'ipk',
                    'nama_jenjang',
                    'nama_fakultas',
                    'singkatan_fakultas',
                    'kode_upbjj',
                    'nama_upbjj',
                ])
                ->where('masa_yudisium', '=', $masa)
                ->where('sika_synced', false)
                ->orderBy('nim')
                ->limit(2000)
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
                        'nama_jenjang' => $item->nama_jenjang,
                        'nama_fakultas' => $item->nama_fakultas,
                        'singkatan' => $item->singkatan_fakultas,
                        'kode_upbjj' => $item->kode_upbjj,
                        'nama_upbjj' => $item->nama_upbjj,
                    ];
                })
                ->values();

            /*
            |--------------------------------------------------------------------------
            | 6. JIKA DATA SUDAH HABIS
            |--------------------------------------------------------------------------
            */

            if ($items->isEmpty()) {
                break;
            }

            $batch++;

            /*
            |--------------------------------------------------------------------------
            | 7. AMBIL NIM YANG AKAN DIKIRIM
            |--------------------------------------------------------------------------
            */

            $nims = $items
                ->pluck('nim')
                ->toArray();

            /*
            |--------------------------------------------------------------------------
            | 8. BENTUK PAYLOAD
            |--------------------------------------------------------------------------
            */

            $payload = [
                'items' => $items->toArray(),
            ];

            /*
            |--------------------------------------------------------------------------
            | 9. PUSH KE API SIKA
            |--------------------------------------------------------------------------
            */

            $response = Http::withoutVerifying()
                ->withToken($token)
                ->acceptJson()
                ->asJson()
                ->timeout(120)
                ->post(
                    $baseUrl . '/rest/api/yudisium/bulk',
                    $payload
                );

            /*
            |--------------------------------------------------------------------------
            | 10. JIKA BATCH GAGAL
            |--------------------------------------------------------------------------
            */

            if ($response->failed()) {
                return [
                    'success' => false,
                    'status' => $response->status(),
                    'message' => "Pengiriman gagal pada batch {$batch}.",
                    'masa' => $masa,
                    'batch_gagal' => $batch,
                    'total_batch_berhasil' => $batch - 1,
                    'total_berhasil' => $totalBerhasil,
                    'response' => $response->json(),
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | 11. TANDAI DATA BATCH SEBAGAI SUDAH TERKIRIM
            |--------------------------------------------------------------------------
            */

            $totalUpdated = DataPribadiAlumni::query()
                ->where('masa_yudisium', $masa)
                ->whereIn('nim', $nims)
                ->update([
                    'sika_synced' => true,
                    'sika_synced_at' => now(),
                ]);

            /*
            |--------------------------------------------------------------------------
            | 12. TAMBAHKAN TOTAL BERHASIL
            |--------------------------------------------------------------------------
            */

            $totalBerhasil += $totalUpdated;
        }

        /*
        |--------------------------------------------------------------------------
        | 13. JIKA DARI AWAL TIDAK ADA DATA
        |--------------------------------------------------------------------------
        */

        if ($batch === 0) {
            return [
                'success' => true,
                'status' => 200,
                'message' => 'Tidak ada data baru yang perlu dikirim ke SIKA.',
                'masa' => $masa,
                'total_batch' => 0,
                'total_berhasil' => 0,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | 14. SEMUA BATCH SELESAI
        |--------------------------------------------------------------------------
        */

        return [
            'success' => true,
            'status' => 200,
            'message' => 'Seluruh data berhasil dikirim ke SIKA.',
            'masa' => $masa,
            'total_batch' => $batch,
            'total_berhasil' => $totalBerhasil,
        ];
    }
}