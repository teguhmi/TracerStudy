<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Throwable;

class pushYudisiumSika extends Command
{
    /**
     * Nama perintah artisan.
     */
    protected $signature = 'aksi:ambil-yudisium
                            {--masa=20252 : Masa yudisium}';

    /**
     * Deskripsi command.
     */
    protected $description = 'Mengambil data yudisium dari database AKSI dan mengirimkannya ke SIKA';

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

        // Ubah menjadi 2000 jika ingin mengirim 2000 data per batch.
        $limit = 2000;

        $totalBerhasil = 0;
        $totalUpdated = 0;

        $this->newLine();

        $this->info("Mengambil data AKSI masa $masa...");

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
                    ->where('masa', $masa)
                    ->where('sika_synced', false)
                    ->orderBy('nim')
                    ->limit($limit)
                    ->get();
            } catch (Throwable $e) {
                $this->error('Gagal mengambil data dari database AKSI.');
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
            | 8. SIMPAN NIM BATCH YANG SEDANG DIPROSES
            |--------------------------------------------------------------------------
            |
            | NIM disimpan sebelum mapping agar bisa digunakan untuk update
            | sika_synced setelah pengiriman berhasil.
            |
            */

            $nims = $items
                ->pluck('nim')
                ->filter()
                ->values()
                ->toArray();

            /*
            |--------------------------------------------------------------------------
            | 9. MAPPING DATA SESUAI FORMAT SIKA
            |--------------------------------------------------------------------------
            */

            $items = $items
                ->map(function ($item) {
                    return [
                        'masa'                 => $item->masa,
                        'nomor_sk_rektor'      => $item->nomor_sk_rektor,
                        'nim'                  => $item->nim,
                        'nama_mahasiswa'       => $item->nama_mahasiswa,
                        'kode_program_studi'   => $item->kode_program_studi,
                        'nama_singkat_ps'      => $item->nama_singkat_ps,
                        'ipk'                  => $item->ipk,
                        'nama_jenjang'         => $item->nama_jenjang,
                        'nama_fakultas'        => $item->nama_fakultas,
                        'singkatan'            => $item->singkatan,
                        'kode_upbjj'           => $item->kode_upbjj,
                        'nama_upbjj'           => $item->nama_upbjj,
                    ];
                })
                ->values();

            $jumlahData = $items->count();

            $this->newLine();
            $this->info("Batch $batch");
            $this->line("Jumlah data : $jumlahData");

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

            $this->line("Mengirim batch $batch ke SIKA...");

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

                $this->error("Pengiriman batch $batch gagal.");
                $this->error($e->getMessage());

                $this->newLine();

                $this->line(
                    'Total batch berhasil : ' . ($batch - 1)
                );

                $this->line(
                    "Total data berhasil  : $totalBerhasil"
                );

                /*
                | Data batch ini TIDAK di-update sika_synced karena
                | pengiriman ke SIKA gagal.
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

                $this->error("Pengiriman gagal pada batch $batch.");

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
                | PENTING:
                | Karena response SIKA gagal, sika_synced batch ini
                | TIDAK boleh diubah menjadi true.
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
            */

            try {
                $updated = DB::connection('mariadb')
                    ->table('t_yudisium')
                    ->where('masa', $masa)
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
                | Pada kondisi ini data SUDAH masuk ke SIKA, tetapi status pada
                | AKSI belum rubber menjadi true.
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

            $this->info(
                "Batch $batch berhasil dikirim."
            );

            $this->line(
                "Status sika_synced diupdate : $updated data"
            );

            $this->line(
                "Total sementara              : $totalBerhasil data"
            );

            /*
            |--------------------------------------------------------------------------
            | 15. LANJUT KE BATCH BERIKUTNYA
            |--------------------------------------------------------------------------
            |
            | TIDAK menggunakan:
            |
            | $offset += $limit;
            |
            | Karena data batch sebelumnya sudah berubah menjadi
            | sika_synced = true.
            |
            | Query berikutnya otomatis mengambil data berikutnya yang masih
            | sika_synced = false.
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
                "Tidak ada data yudisium masa $masa yang perlu dikirim."
            );

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | 17. SELESAI
        |--------------------------------------------------------------------------
        */

        $this->info('========================================');
        $this->info('PROSES SELESAI');
        $this->info('========================================');

        $this->line("Masa            : $masa");
        $this->line("Total batch     : $batch");
        $this->line("Total terkirim  : $totalBerhasil");
        $this->line("Total ter-update: $totalUpdated");

        return self::SUCCESS;
    }
}