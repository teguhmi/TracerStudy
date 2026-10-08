<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class pushYudisiumSika extends Command
{
    /**
     * Nama perintah artisan.
     */
    protected $signature = 'aksi:ambil-yudisium
                            {--masa=20252 : Masa yudisium minimum yang akan diproses}';

    /**
     * Deskripsi command.
     */
    protected $description = 'Mengirim data yudisium AKSI ke SIKA mulai dari masa yang ditentukan';

    /**
     * Jalankan command.
     */
    public function handle(): int
    {
        $masa = $this->option('masa');

        $baseUrl = config('services.sika.base_url');

        /*
        |--------------------------------------------------------------------------
        | 1. LOGIN KE SIKA
        |--------------------------------------------------------------------------
        */

        $this->info('Login ke SIKA...');

        try {
            $login = Http::withoutVerifying()
                ->acceptJson()
                ->asJson()
                ->post($baseUrl . '/rest/api/auth/token', [
                    'username'     => config('services.sika.username'),
                    'password'     => config('services.sika.password'),
                    'expires_days' => 7,
                ]);
        } catch (ConnectionException $e) {
            $this->error('Tidak dapat terhubung ke SIKA.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if ($login->failed()) {
            $this->error('Login ke SIKA gagal.');
            $this->error('HTTP Status: ' . $login->status());

            $this->line(
                json_encode(
                    $login->json(),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return self::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. AMBIL ACCESS TOKEN
        |--------------------------------------------------------------------------
        */

        $token = $login->json('access_token');

        if (empty($token)) {
            $this->error('Bearer token tidak ditemukan.');

            $this->line(
                json_encode(
                    $login->json(),
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return self::FAILURE;
        }

        $this->info('Login ke SIKA berhasil.');

        /*
        |--------------------------------------------------------------------------
        | 4. INISIALISASI
        |--------------------------------------------------------------------------
        */

        $batch = 0;

        // Jumlah maksimal data yang dikirim ke SIKA dalam satu batch.
        $limit = 2000;

        $totalBerhasil = 0;
        $totalUpdated = 0;

        /*
        |--------------------------------------------------------------------------
        | INFORMASI PROSES
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('========================================');
        $this->info('SINKRONISASI YUDISIUM AKSI -> SIKA');
        $this->info('========================================');

        $this->line("Masa minimum : $masa");
        $this->line("Kriteria     : masa >= $masa");
        $this->line("Batch size   : $limit data");

        $this->newLine();

        $this->info(
            "Mengambil data yudisium AKSI dengan masa >= $masa..."
        );

        /*
        |--------------------------------------------------------------------------
        | 5. PROSES DATA PER BATCH
        |--------------------------------------------------------------------------
        */

        while (true) {

            /*
            |--------------------------------------------------------------------------
            | 6. AMBIL DATA DARI DATABASE AKSI
            |--------------------------------------------------------------------------
            |
            | Hanya mengambil:
            |
            | - masa >= masa minimum
            | - sika_synced = false
            |
            | Data diurutkan berdasarkan masa kemudian NIM.
            |
            */

            try {
                $items = DB::connection('mariadb')
                    ->table('t_yudisium')
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
                    ->where('masa', '>=', $masa)
                    ->where('sika_synced', false)
                    ->orderBy('masa')
                    ->orderBy('nim')
                    ->limit($limit)
                    ->get();
            } catch (Throwable $e) {
                $this->newLine();

                $this->error(
                    'Gagal mengambil data dari database AKSI.'
                );

                $this->error($e->getMessage());

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | 7. JIKA DATA SUDAH HABIS
            |--------------------------------------------------------------------------
            */

            if ($items->isEmpty()) {
                break;
            }

            $batch++;

            /*
            |--------------------------------------------------------------------------
            | 8. SIMPAN INFORMASI BATCH
            |--------------------------------------------------------------------------
            |
            | Informasi disimpan sebelum mapping agar NIM dan rentang masa
            | batch dapat digunakan setelah pengiriman berhasil.
            |
            */

            $nims = $items
                ->pluck('nim')
                ->filter()
                ->values()
                ->toArray();

            $masaAwal = $items->min('masa');
            $masaAkhir = $items->max('masa');

            /*
            |--------------------------------------------------------------------------
            | 9. MAPPING DATA SESUAI FORMAT SIKA
            |--------------------------------------------------------------------------
            */

            $items = $items
                ->map(function ($item) {
                    return [
                        'masa'               => $item->masa,
                        'nomor_sk_rektor'    => $item->nomor_sk_rektor,
                        'nim'                => $item->nim,
                        'nama_mahasiswa'     => $item->nama_mahasiswa,
                        'kode_program_studi' => $item->kode_program_studi,
                        'nama_singkat_ps'    => $item->nama_singkat_ps,
                        'ipk'                => $item->ipk,
                        'nama_jenjang'       => $item->nama_jenjang,
                        'nama_fakultas'      => $item->nama_fakultas,
                        'singkatan'          => $item->singkatan,
                        'kode_upbjj'         => $item->kode_upbjj,
                        'nama_upbjj'         => $item->nama_upbjj,
                    ];
                })
                ->values();

            $jumlahData = $items->count();

            /*
            |--------------------------------------------------------------------------
            | INFORMASI BATCH
            |--------------------------------------------------------------------------
            */

            $this->newLine();

            $this->info('----------------------------------------');
            $this->info("BATCH $batch");
            $this->info('----------------------------------------');

            $this->line("Jumlah data : $jumlahData");
            $this->line("Rentang masa: $masaAwal s.d. $masaAkhir");

            /*
            |--------------------------------------------------------------------------
            | 10. BENTUK PAYLOAD SIKA
            |--------------------------------------------------------------------------
            */

            $payload = [
                'items' => $items->toArray(),
            ];

            /*
            |--------------------------------------------------------------------------
            | 11. KIRIM KE SIKA
            |--------------------------------------------------------------------------
            */

            $this->newLine();

            $this->line(
                "Mengirim $jumlahData data pada batch $batch ke SIKA..."
            );

            try {
                $response = Http::withoutVerifying()
                    ->withToken($token)
                    ->acceptJson()
                    ->asJson()
                    ->timeout(120)
                    ->post(
                        $baseUrl . '/rest/api/yudisium/bulk',
                        $payload
                    );
            } catch (ConnectionException $e) {
                $this->newLine();

                $this->error(
                    "Pengiriman batch $batch gagal."
                );

                $this->error($e->getMessage());

                $this->newLine();

                $this->line(
                    'Total batch berhasil : ' . ($batch - 1)
                );

                $this->line(
                    "Total data berhasil  : $totalBerhasil"
                );

                /*
                |--------------------------------------------------------------------------
                | PENTING
                |--------------------------------------------------------------------------
                |
                | Data batch ini TIDAK diubah menjadi sika_synced = true
                | karena pengiriman ke SIKA gagal.
                |
                */

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | 12. CEK RESPONSE SIKA
            |--------------------------------------------------------------------------
            */

            if ($response->failed()) {
                $this->newLine();

                $this->error(
                    "Pengiriman gagal pada batch $batch."
                );

                $this->error(
                    'HTTP Status: ' . $response->status()
                );

                $this->line(
                    json_encode(
                        $response->json(),
                        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                    )
                );

                $this->newLine();

                $this->line(
                    'Total batch berhasil : ' . ($batch - 1)
                );

                $this->line(
                    "Total data berhasil  : $totalBerhasil"
                );

                /*
                |--------------------------------------------------------------------------
                | PENTING
                |--------------------------------------------------------------------------
                |
                | Karena response dari SIKA gagal, data pada batch ini
                | TIDAK boleh diubah menjadi sika_synced = true.
                |
                */

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | 13. UPDATE DATA AKSI SETELAH SIKA BERHASIL
            |--------------------------------------------------------------------------
            |
            | Bagian ini HANYA dijalankan jika HTTP response dari SIKA sukses.
            |
            | Kondisi masa dibuat sama dengan query pengambilan:
            |
            | masa >= $masa
            |
            */

            try {
                $updated = DB::connection('mariadb')
                    ->table('t_yudisium')
                    ->where('masa', '>=', $masa)
                    ->whereIn('nim', $nims)
                    ->where('sika_synced', false)
                    ->update([
                        'sika_synced'    => true,
                        'sika_synced_at' => now(),
                    ]);
            } catch (Throwable $e) {
                $this->newLine();

                $this->error(
                    "Batch $batch berhasil dikirim ke SIKA, tetapi gagal mengubah status sika_synced."
                );

                $this->error($e->getMessage());

                /*
                |--------------------------------------------------------------------------
                | PERHATIAN
                |--------------------------------------------------------------------------
                |
                | Pada kondisi ini data SUDAH masuk ke SIKA, tetapi status
                | sika_synced pada AKSI belum berhasil diubah menjadi true.
                |
                | Command dihentikan agar masalah dapat diperiksa terlebih dahulu.
                |
                */

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | 14. BATCH BERHASIL
            |--------------------------------------------------------------------------
            */

            $totalBerhasil += $jumlahData;
            $totalUpdated += $updated;

            $this->newLine();

            $this->info(
                "Batch $batch berhasil dikirim ke SIKA."
            );

            $this->line(
                "Data terkirim        : $jumlahData"
            );

            $this->line(
                "Status diperbarui    : $updated"
            );

            $this->line(
                "Total sudah terkirim : $totalBerhasil"
            );

            /*
            |--------------------------------------------------------------------------
            | 15. LANJUT KE BATCH BERIKUTNYA
            |--------------------------------------------------------------------------
            |
            | Tidak menggunakan OFFSET.
            |
            | Data batch yang sudah berhasil dikirim telah diubah menjadi:
            |
            | sika_synced = true
            |
            | Query berikutnya otomatis mengambil maksimal $limit data berikutnya
            | yang masih memiliki:
            |
            | sika_synced = false
            |
            */
        }

        /*
        |--------------------------------------------------------------------------
        | 16. JIKA TIDAK ADA DATA
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        if ($batch === 0) {
            $this->warn(
                "Tidak ada data yudisium dengan masa >= $masa dan sika_synced = false."
            );

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | 17. SELESAI
        |--------------------------------------------------------------------------
        */

        $this->info('========================================');
        $this->info('SINKRONISASI SELESAI');
        $this->info('========================================');

        $this->line("Masa minimum        : $masa");
        $this->line("Kriteria            : masa >= $masa");
        $this->line("Total batch         : $batch");
        $this->line("Total data terkirim : $totalBerhasil");
        $this->line("Total status update : $totalUpdated");

        $this->info('========================================');

        return self::SUCCESS;
    }
}