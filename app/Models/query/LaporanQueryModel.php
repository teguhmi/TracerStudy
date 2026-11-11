<?php

namespace App\Models\query;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LaporanQueryModel
{
  public static function getTahunLulus(): Collection
  {
    return DB::table('m_sk_rektor as a')
      ->selectRaw("DISTINCT DATE_FORMAT(a.tanggal_sk,'%Y') AS tahun_lulus")
      ->whereDate('a.tanggal_sk', '>=', '2020-01-01')
      ->orderByDesc('tahun_lulus')
      ->pluck('tahun_lulus');
  }

//  public static function getRekapFakultas($tahun): Collection
//  {
//    return DB::table('t_yudisium as a')
//      ->join(
//        'm_sk_rektor as sk',
//        'a.nomor_sk_rektor',
//        '=',
//        'sk.nomor_sk_rektor'
//      )
//
//      ->leftJoin(
//        'tracer_respondens as tr',
//        'a.nim',
//        '=',
//        'tr.nim'
//      )
//
//      ->leftJoin(
//        'tracer_jawabans as tj',
//        'tr.id',
//        '=',
//        'tj.responden_id'
//      )
//
//      ->select(
//        'a.singkatan as fakultas',
//        'a.nama_singkat_ps as program_studi'
//      )
//
//      ->selectRaw('
//            COUNT(DISTINCT a.nim) AS jumlah_lulusan
//        ')
//
//      ->selectRaw("
//            COUNT(
//                DISTINCT CASE
//                    WHEN tj.jawaban IS NOT NULL
//                    THEN a.nim
//                END
//            ) AS sudah_isi_tracer
//        ")
//
//      ->selectRaw("
//            COUNT(DISTINCT a.nim)
//            -
//            COUNT(
//                DISTINCT CASE
//                    WHEN tj.jawaban IS NOT NULL
//                    THEN a.nim
//                END
//            ) AS belum_isi_tracer
//        ")
//
//      ->selectRaw("
//            ROUND(
//                (
//                    COUNT(
//                        DISTINCT CASE
//                            WHEN tj.jawaban IS NOT NULL
//                            THEN a.nim
//                        END
//                    ) * 100
//                )
//                /
//                NULLIF(
//                    COUNT(DISTINCT a.nim),
//                    0
//                ),
//                1
//            ) AS persentase
//        ")
//
//      ->whereYear(
//        'sk.tanggal_sk',
//        $tahun
//      )
//
//      ->groupBy(
//        'a.singkatan',
//        'a.nama_singkat_ps'
//      )
//
//      ->orderBy('a.singkatan')
//      ->orderBy('a.nama_singkat_ps')
//
//      ->get();
//  }

  public static function getRekapFakultas($tahun): Collection
  {
    // Subquery: Mengambil NIM alumni secara UNIK yang benar-benar punya jawaban
    $tracerSub = DB::table('tracer_respondens as tr')
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('tracer_jawabans as tj')
          ->whereColumn('tj.responden_id', 'tr.id');
      })
      ->select('tr.nim')
      ->groupBy('tr.nim');

    return DB::table('t_yudisium as a')
      ->join('m_sk_rektor as sk', 'a.nomor_sk_rektor', '=', 'sk.nomor_sk_rektor')
      ->leftJoinSub($tracerSub, 'tr', function ($join) {
        $join->on('a.nim', '=', 'tr.nim');
      })
      ->select(
        'a.singkatan as fakultas',
        'a.nama_singkat_ps as program_studi'
      )
      ->selectRaw('COUNT(a.nim) AS jumlah_lulusan')
      ->selectRaw('COUNT(tr.nim) AS sudah_isi_tracer')
      ->selectRaw('COUNT(a.nim) - COUNT(tr.nim) AS belum_isi_tracer')
      ->selectRaw('
            ROUND(
                (COUNT(tr.nim) * 100.0) / NULLIF(COUNT(a.nim), 0),
                1
            ) AS persentase
        ')
      ->whereBetween('sk.tanggal_sk', ["{$tahun}-01-01", "{$tahun}-12-31"])
      ->groupBy('a.singkatan', 'a.nama_singkat_ps')
      ->orderBy('a.singkatan')
      ->orderBy('a.nama_singkat_ps')
      ->get();
  }

  public static function getRekapUPBJJ($tahun): Collection
  {
    // Subquery: Mengambil NIM alumni secara UNIK yang benar-benar punya jawaban
    $tracerSub = DB::table('tracer_respondens as tr')
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('tracer_jawabans as tj')
          ->whereColumn('tj.responden_id', 'tr.id');
      })
      ->select('tr.nim')
      ->groupBy('tr.nim');

    return DB::table('t_yudisium as y')
      ->join('m_sk_rektor as sk', 'y.nomor_sk_rektor', '=', 'sk.nomor_sk_rektor')
      ->leftJoinSub($tracerSub, 'tr', function ($join) {
        $join->on('y.nim', '=', 'tr.nim');
      })
      ->select('y.nama_upbjj as upbjj')
      ->selectRaw('COUNT(y.nim) AS jumlah_lulusan')
      ->selectRaw('COUNT(tr.nim) AS sudah_isi_tracer')
      ->selectRaw('COUNT(y.nim) - COUNT(tr.nim) AS belum_isi_tracer')
      ->selectRaw('
            ROUND(
                (COUNT(tr.nim) * 100.0) / NULLIF(COUNT(y.nim), 0),
                1
            ) AS persentase
        ')
      ->whereBetween('sk.tanggal_sk', ["{$tahun}-01-01", "{$tahun}-12-31"])
      ->groupBy('y.nama_upbjj')
      ->orderBy('y.nama_upbjj')
      ->get();
  }
//  public static function getRekapUPBJJ($tahun): Collection
//  {
//    return DB::table('t_yudisium as y')
//      ->join(
//        'm_sk_rektor as sk',
//        'y.nomor_sk_rektor',
//        '=',
//        'sk.nomor_sk_rektor'
//      )
//
//      ->leftJoin(
//        'tracer_respondens as tr',
//        'y.nim',
//        '=',
//        'tr.nim'
//      )
//
//      ->leftJoin(
//        'tracer_jawabans as tj',
//        'tr.id',
//        '=',
//        'tj.responden_id'
//      )
//
//      ->selectRaw("
//            y.nama_upbjj as upbjj,
//
//            COUNT(DISTINCT y.nim) AS jumlah_lulusan,
//
//            COUNT(
//                DISTINCT CASE
//                    WHEN tj.responden_id IS NOT NULL
//                    THEN y.nim
//                END
//            ) AS sudah_isi_tracer,
//
//            COUNT(DISTINCT y.nim)
//            -
//            COUNT(
//                DISTINCT CASE
//                    WHEN tj.responden_id IS NOT NULL
//                    THEN y.nim
//                END
//            ) AS belum_isi_tracer,
//
//            ROUND(
//                (
//                    COUNT(
//                        DISTINCT CASE
//                            WHEN tj.responden_id IS NOT NULL
//                            THEN y.nim
//                        END
//                    ) * 100
//                )
//                /
//                NULLIF(
//                    COUNT(DISTINCT y.nim),
//                    0
//                ),
//                1
//            ) AS persentase
//        ")
//
//      ->whereYear(
//        'sk.tanggal_sk',
//        $tahun
//      )
//
//      ->groupBy('y.nama_upbjj')
//
//      ->orderBy('y.nama_upbjj')
//
//      ->get();
//  }

  public static function getRekapFakultasUPBJJ($tahun): Collection
  {
    return DB::table('t_yudisium as y')
      ->join(
        'm_sk_rektor as sk',
        'y.nomor_sk_rektor',
        '=',
        'sk.nomor_sk_rektor'
      )

      ->leftJoin(
        'tracer_respondens as tr',
        'y.nim',
        '=',
        'tr.nim'
      )

      ->leftJoin(
        'tracer_jawabans as tj',
        'tr.id',
        '=',
        'tj.responden_id'
      )

      ->selectRaw("
            y.nama_upbjj,
            y.singkatan AS fakultas,

            COUNT(DISTINCT y.nim) AS jumlah_lulusan,

            COUNT(
                DISTINCT CASE
                    WHEN tj.jawaban IS NOT NULL
                    THEN y.nim
                END
            ) AS sudah_isi_tracer,

            COUNT(DISTINCT y.nim)
            -
            COUNT(
                DISTINCT CASE
                    WHEN tj.jawaban IS NOT NULL
                    THEN y.nim
                END
            ) AS belum_isi_tracer,

            ROUND(
                (
                    COUNT(
                        DISTINCT CASE
                            WHEN tj.jawaban IS NOT NULL
                            THEN y.nim
                        END
                    ) * 100
                )
                /
                NULLIF(
                    COUNT(DISTINCT y.nim),
                    0
                ),
                1
            ) AS persentase
        ")

      ->whereYear(
        'sk.tanggal_sk',
        $tahun
      )

      ->groupBy(
        'y.nama_upbjj',
        'y.singkatan'
      )

      ->orderBy('y.nama_upbjj')
      ->orderBy('y.singkatan')

      ->get();
  }


  public static function getIKPS30142(mixed $tahun)
  {
    return 'getIKPS30142';
  }

  public static function getIKPS32131(mixed $tahun)
  {
    return 'getIKPS32131';
  }

  public static function getIKPS35211(mixed $tahun)
  {
    return 'getIKPS35211';
  }

  public static function getIKPS35212($tahun): Collection
  {
    $tracerSub = DB::table('tracer_respondens as tr')
      ->whereExists(function ($query) {
        $query->select(DB::raw(1))
          ->from('tracer_jawabans as tj')
          ->whereColumn('tj.responden_id', 'tr.id');
      })
      ->select('tr.nim')
      ->groupBy('tr.nim');

    return DB::table('t_yudisium as y')
      ->join(
        'm_sk_rektor as sk',
        'y.nomor_sk_rektor',
        '=',
        'sk.nomor_sk_rektor'
      )
      ->leftJoinSub($tracerSub, 'tr', function ($join) {
        $join->on('y.nim', '=', 'tr.nim');
      })
      ->selectRaw("
            YEAR(sk.tanggal_sk) AS tahun_lulusan
        ")
      ->selectRaw("
            y.nama_upbjj AS unit
        ")
      ->selectRaw("
            COUNT(DISTINCT tr.nim) AS jumlah_responden
        ")
      ->selectRaw("
            COUNT(DISTINCT y.nim) AS jumlah_lulusan
        ")
      ->whereYear('sk.tanggal_sk', $tahun)
      ->groupBy(
        DB::raw('YEAR(sk.tanggal_sk)'),
        'y.nama_upbjj'
      )
      ->orderBy('y.nama_upbjj')
      ->get();
  }
}
