<?php

namespace App\Services\Api;

use App\Models\ApiToken;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class SrsApiService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => rtrim(config('services.api_srs.url'), '/') . '/',
            'timeout' => 15,
            'connect_timeout' => 5,
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Login ke API SRS.
     */
    public function login(): string
    {
        try {
            $response = $this->client->post('v1/auth', [
                'json' => [
                    'email' => config('services.api_srs.username'),
                    'password' => config('services.api_srs.password'),
                ],
            ]);

            $obj = json_decode(
                $response->getBody()->getContents()
            );

            if (
                empty($obj) ||
                empty($obj->status) ||
                empty($obj->token)
            ) {
                throw new RuntimeException(
                    'Login API SRS gagal atau token tidak ditemukan.'
                );
            }

            $this->updateToken($obj->token);

            return $obj->token;

        } catch (GuzzleException $e) {
            throw new RuntimeException(
                'Gagal login ke API SRS: ' . $e->getMessage(),
                0,
                $e
            );
        }
    }

    /**
     * Simpan token ke database.
     */
    private function updateToken(string $token): void
    {
        ApiToken::updateOrCreate(
            [
                'service' => 'api_srs',
            ],
            [
                'token' => $token,
            ]
        );
    }

    /**
     * Ambil token.
     * Login otomatis jika token belum tersedia.
     */
    private function token(): string
    {
        $apiToken = ApiToken::where('service', 'api_srs')->first();

        if ($apiToken && !empty($apiToken->token)) {
            return $apiToken->token;
        }

        return $this->login();
    }

    /**
     * Hapus token lama kemudian login ulang.
     */
    private function refreshToken(): string
    {
        ApiToken::where('service', 'api_srs')->delete();

        return $this->login();
    }

    /**
     * Get Data Pribadi berdasarkan NIM.
     */
    public function getDpByNim(string $nim): array|false|null
    {
        try {
            $response = $this->requestDataPribadi(
                $nim,
                $this->token()
            );

            // Token expired / invalid
            if ($response->getStatusCode() === 401) {
                $response = $this->requestDataPribadi(
                    $nim,
                    $this->refreshToken()
                );
            }

            // NIM tidak ditemukan
            if ($response->getStatusCode() === 404) {
                return false;
            }

            // Response selain 2xx
            if (
                $response->getStatusCode() < 200 || $response->getStatusCode() >= 300
            ) {
                return null;
            }

            $obj = json_decode(
                $response->getBody()->getContents()
            );
            if (
                empty($obj) ||
                empty($obj->status) ||
                empty($obj->data)
            ) {
                return null;
            }

            return $this->mapDataPribadi($obj->data);

        } catch (GuzzleException $e) {
            return null;
        }
    }

    /**
     * Request endpoint data pribadi.
     */
    private function requestDataPribadi(
        string $nim,
        string $token
    )
    {
        return $this->client->get(
            'v1/data-pribadi/' . urlencode($nim),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],

                // Agar 401/404 tidak langsung dilempar menjadi exception
                'http_errors' => false,
            ]
        );
    }

    /**
     * Mapping response API menjadi format aplikasi.
     */
    private function mapDataPribadi(object $dataObj): array
    {
        /*
         * PRODI DIKTI
         */
        $kodeProdiDikti = null;
        $prodi = null;

        if (
            !empty(
            $dataObj->info_ut
                ->program_studi
                ->prodi_dikti
                ->nama_prodi_dikti
            )
        ) {
            $kodeProdiDikti =
                $dataObj->info_ut
                    ->program_studi
                    ->prodi_dikti
                    ->kode_prodi_dikti ?? null;

            $prodi =
                $dataObj->info_ut
                    ->program_studi
                    ->prodi_dikti
                    ->nama_prodi_dikti ?? null;
        } else {
            $prodi =
                $dataObj->info_ut
                    ->program_studi
                    ->nama_singkat_ps ?? null;
        }

        /*
         * MASA SPP
         */
        $billing = $dataObj->masa_akhir_billing_spp ?? null;

        if (
            empty($billing?->masa) ||
            empty($billing?->keterangan) ||
            $billing?->masa === '-' ||
            $billing?->keterangan === '-'
        ) {
            $sppMasa =
                $dataObj->masa_reg_akhir->masa ?? null;

            $sppMasaKeterangan =
                $dataObj->masa_reg_akhir->keterangan ?? null;

            $sppMasaTahunAkademik =
                $dataObj->masa_reg_akhir->tahun_akademik ?? null;
        } else {
            $sppMasa = $billing->masa;

            $sppMasaKeterangan = $billing->keterangan;

            $sppMasaTahunAkademik =
                $billing->tahun_akademik
                ?? $billing->keterangan;
        }

        /*
         * DATA PENDUKUNG
         */
        $pos =
            $dataObj->info_kontak->pos ?? null;

        $jurusan =
            $dataObj->info_pendidikan_akhir
                ->jurusan_asal ?? null;

        $pokjar =
            $dataObj->info_pokjar
                ->pokjar
                ->nama_pokjar ?? null;

        /*
         * RESPONSE
         */
        return [
            'nim' =>
                $dataObj->nim ?? null,

            'nama_mahasiswa' =>
                $this->upper($dataObj->nama_mahasiswa ?? null),

            'tempat_lahir_mahasiswa' =>
                $dataObj->tempat_lahir_mahasiswa ?? null,

            'tanggal_lahir_mahasiswa' =>
                $dataObj->tanggal_lahir_mahasiswa ?? null,

            'jenis_kelamin' =>
                $dataObj->jenis_kelamin->keterangan ?? null,

            'nik' =>
                $this->nullable($dataObj->nik ?? null),

            'nama_ibu_kandung' =>
                $this->nullable(
                    $dataObj->nama_ibu_kandung ?? null
                ),

            'status_dp' =>
                $dataObj->status_data_pribadi
                    ->kode_status_dp ?? null,

            'keterangan_dp' =>
                $dataObj->status_data_pribadi
                    ->keterangan ?? null,

            /*
             * Fakultas
             */
            'kode_fakultas' =>
                $dataObj->info_ut
                    ->program_studi
                    ->fakultas
                    ->kode_fakultas ?? null,

            'singkatan_fakultas' =>
                $dataObj->info_ut
                    ->program_studi
                    ->fakultas
                    ->singkatan ?? null,

            'nama_fakultas' =>
                $dataObj->info_ut
                    ->program_studi
                    ->fakultas
                    ->nama_fakultas ?? null,

            /*
             * Program Studi
             */
            'program_studi' =>
                $dataObj->info_ut
                    ->program_studi
                    ->nama_program_studi ?? null,

            'kode_program_studi' =>
                $dataObj->info_ut
                    ->program_studi
                    ->kode_program_studi ?? null,

            'nama_program_studi' =>
                $dataObj->info_ut
                    ->program_studi
                    ->nama_program_studi ?? null,

            'nama_singkat_program_studi' =>
                $dataObj->info_ut
                    ->program_studi
                    ->nama_singkat_ps ?? null,

            'kode_prodi_dikti' =>
                $kodeProdiDikti,

            'nama_prodi_dikti' =>
                $prodi,

            /*
             * Jenjang
             */
            'kode_jenjang' =>
                $dataObj->info_ut
                    ->program_studi
                    ->jenjang_prodi
                    ->kode_jenjang ?? null,

            'jenjang_program_studi' =>
                $dataObj->info_ut
                    ->program_studi
                    ->jenjang_prodi
                    ->nama_jenjang ?? null,

            /*
             * Jenis Program
             */
            'kode_jenis_program' =>
                $dataObj->info_ut
                    ->program_studi
                    ->jenis_program
                    ->kode_jenis_program ?? null,

            'jenis_program' =>
                $dataObj->info_ut
                    ->program_studi
                    ->jenis_program
                    ->keterangan ?? null,

            /*
             * Akademik
             */
            'ipk' =>
                $dataObj->info_ut->ipk_dp ?? null,

            'sks' =>
                $dataObj->info_ut->sks_dp ?? null,

            /*
             * UPBJJ
             */
            'kode_upbjj' =>
                $dataObj->info_ut
                    ->upbjj
                    ->kode_upbjj ?? null,

            'nama_upbjj' =>
                $this->upper(
                    $dataObj->info_ut
                        ->upbjj
                        ->nama_upbjj ?? null
                ),

            /*
             * Masa Registrasi
             */
            'masa_awal_registrasi' =>
                $dataObj->masa_reg_awal->masa ?? null,

            'masa_awal_keterangan' =>
                $dataObj->masa_reg_awal->keterangan ?? null,

            'masa_awal_tahun_akademik' =>
                $dataObj->masa_reg_awal
                    ->tahun_akademik ?? null,

            'masa_akhir_registrasi' =>
                $dataObj->masa_reg_akhir->masa ?? null,

            'masa_akhir_keterangan' =>
                $dataObj->masa_reg_akhir
                    ->keterangan ?? null,

            'masa_akhir_tahun_akademik' =>
                $dataObj->masa_reg_akhir
                    ->tahun_akademik ?? null,

            /*
             * SPP
             */
            'spp_masa' =>
                $sppMasa,

            'spp_masa_keterangan' =>
                $sppMasaKeterangan,

            'spp_masa_tahun_akademik' =>
                $sppMasaTahunAkademik,

            /*
             * Pendidikan Sebelumnya
             */
            'kode_jurusan_asal' =>
                $jurusan->kode_jurusan_asal ?? null,

            'nama_jurusan_asal' =>
                $jurusan->nama_jurusan_asal ?? null,

            /*
             * Kontak
             */
            'nomor_hp_mahasiswa' =>
                $dataObj->info_kontak
                    ->nomor_hp_mahasiswa ?? null,

            'nomor_hp_mahasiswa2' =>
                $dataObj->info_kontak
                    ->nomor_hp_mahasiswa2 ?? null,

            'nomor_telepon_mahasiswa' =>
                $dataObj->info_kontak
                    ->nomor_telepon_mahasiswa ?? null,

            'nomor_telepon_kantor' =>
                $dataObj->info_kontak
                    ->nomor_telepon_kantor ?? null,

            'nomor_kontak_kerabat' =>
                $dataObj->info_kontak
                    ->nomor_kontak_kerabat ?? null,

            /*
             * Alamat
             */
            'alamat_mahasiswa' =>
                $dataObj->info_kontak
                    ->alamat_mahasiswa ?? null,

            'kode_pos' =>
                $pos->kode_pos ?? null,

            'nama_pos' =>
                $pos->nama_pos ?? null,

            'kode_kabko' =>
                $pos->kabupaten_kota
                    ->kode_kabko ?? null,

            'nama_kabko' =>
                $pos->kabupaten_kota
                    ->nama_kabko ?? null,

            'nama_provinsi' =>
                $pos->kabupaten_kota
                    ->provinsi
                    ->nama_provinsi ?? null,

            /*
             * Lainnya
             */
            'pokjar' =>
                $this->nullable($pokjar),

            'nama_agama' =>
                $dataObj->agama->nama_agama ?? null,

            'info_disabilitas' =>
                $dataObj->info_disabilitas ?? null,

        ];
    }

    /**
     * Ubah nilai kosong / "-" menjadi null.
     */
    private function nullable(mixed $value): mixed
    {
        return in_array(
            $value,
            [null, '', '-'],
            true
        ) ? null : $value;
    }

    /**
     * Uppercase string dengan aman.
     */
    private function upper(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        return mb_strtoupper(trim($value));
    }

}
