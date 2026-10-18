<?php

namespace App\Models\query;

use Illuminate\Support\Facades\DB;

class QueryAKSIModel
{
    /**
     * Ambil data yudisium berdasarkan NIM
     */
   public static function getYudisiumByNim(string $nim)
   {
     return DB::connection('mariadb')
       ->table('t_yudisium as y')
       ->leftJoin(
         'm_sk_rektor as sk',
         'y.nomor_sk_rektor',
         '=',
         'sk.nomor_sk_rektor'
       )
       ->select(
         'y.*',
         'sk.tanggal_sk'
       )
       ->where('y.nim', $nim)
       ->first();
   }


  public static function getDpByNimTanggalLahir(string $nim, string $tanggalLahir)
  {
    return DB::connection('mariadb')
      ->table('t_yudisium as y')
      ->leftJoin(
        'm_sk_rektor as sk',
        'y.nomor_sk_rektor',
        '=',
        'sk.nomor_sk_rektor'
      )
      ->select(
        'y.*',
        'sk.tanggal_sk'
      )
      ->where('y.nim', $nim)
      ->whereDate('y.tanggal_lahir', $tanggalLahir)
      ->first();
  }

    /**
     * Ambil 10 lulusan berdasarkan SK Rektor
     */
    public static function getDaftarLulusanBySK($nomorSkRektor,$kodeUpbjj)
    {
        return DB::connection('dbaksi')
            ->table('t_yudisium')
            ->where('nomor_sk_rektor', $nomorSkRektor)
            ->where('kode_upbjj',$kodeUpbjj)
            ->orderBy('nomor_urut_ijasah', 'desc')
            ->limit(10)
            ->get();
    }


}
