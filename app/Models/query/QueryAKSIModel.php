<?php

namespace App\Models\query;

use Illuminate\Support\Facades\DB;

class QueryAKSIModel
{
    /**
     * Ambil data yudisium berdasarkan NIM
     */
    public static function getYudisiumByNim($nim)
    {
        return DB::connection('mariadb')
            ->table('t_yudisium')
            ->select(
                'nim',
                'nama_mahasiswa',
                'nama_program_studi',
                'masa',
                'nomor_sk_rektor',
                'nomor_surat_pengiriman',
                'urut'
            )
            ->where('nim', $nim)
            ->first();
    }

    /**
     * Ambil 10 lulusan berdasarkan SK Rektor
     */
    public static function getDaftarLulusanBySK($nomorSkRektor)
    {
        return DB::connection('dbaksi')
            ->table('yudisium')
            ->where('nomor_sk_rektor', $nomorSkRektor)
            ->orderBy('urut')
            ->limit(10)
            ->get();
    }
}