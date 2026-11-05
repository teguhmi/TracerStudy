<?php

namespace App\Models\query;

use Illuminate\Support\Facades\DB;

class LaporanQueryModel
{
  public static function getTahunLulus()
  {
    return DB::table('m_sk_rektor as a')
      ->selectRaw("DISTINCT DATE_FORMAT(a.tanggal_sk,'%Y') AS tahun_lulus")
      ->whereDate('a.tanggal_sk', '>=', '2020-01-01')
      ->orderByDesc('tahun_lulus')
      ->pluck('tahun_lulus');
  }

  public static function getRekapFakultas($tahun)
  {
    return DB::table('t_yudisium as a')
      ->join('m_sk_rektor as sk', 'a.nomor_sk_rektor', '=', 'sk.nomor_sk_rektor')
      ->leftJoin('tracer_dikti_v1 as t', 'a.nim', '=', 't.nim')

      ->select(
        'a.singkatan as fakultas',
        'a.nama_singkat_ps as program_studi'
      )

      ->selectRaw('COUNT(DISTINCT a.nim) AS jumlah_lulusan')
      ->selectRaw('COUNT(DISTINCT t.nim) AS sudah_isi_tracer')
      ->selectRaw('COUNT(DISTINCT a.nim) - COUNT(DISTINCT t.nim) AS belum_isi_tracer')
      ->selectRaw('ROUND((COUNT(DISTINCT t.nim) * 100.0 / COUNT(DISTINCT a.nim)),1) AS persentase')

      ->whereYear('sk.tanggal_sk', $tahun)

      ->groupBy(
        'a.singkatan',
        'a.nama_singkat_ps'
      )

      ->orderBy('a.singkatan')
      ->orderBy('a.nama_singkat_ps')

      ->get();
  }

  public static function getRekapUPBJJ($tahun)
  {
    return DB::table('t_yudisium as y')
      ->join('m_sk_rektor as sk', 'y.nomor_sk_rektor', '=', 'sk.nomor_sk_rektor')

      ->leftJoin('tracer_dikti_v1 as tr', 'y.nim', '=', 'tr.nim')

      ->selectRaw("
            y.nama_upbjj as upbjj,

            COUNT(DISTINCT y.nim) AS jumlah_lulusan,

            COUNT(
                DISTINCT CASE
                    WHEN tr.nim IS NOT NULL
                    THEN y.nim
                END
            ) AS sudah_isi_tracer,

            COUNT(
                DISTINCT y.nim
            ) -
            COUNT(
                DISTINCT CASE
                    WHEN tr.nim IS NOT NULL
                    THEN y.nim
                END
            ) AS belum_isi_tracer,

            ROUND(
                (
                    COUNT(
                        DISTINCT CASE
                            WHEN tr.nim IS NOT NULL
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

      ->whereYear('sk.tanggal_sk', $tahun)

      ->groupBy('y.nama_upbjj')

      ->orderBy('y.nama_upbjj')

      ->get();
  }

  public static function getRekapFakultasUPBJJ($tahun)
  {
    return DB::table('t_yudisium as y')
      ->join('m_sk_rektor as sk', 'y.nomor_sk_rektor', '=', 'sk.nomor_sk_rektor')

      ->leftJoin('tracer_dikti_v1 as tr', 'y.nim', '=', 'tr.nim')

      ->selectRaw("
            y.nama_upbjj,
            y.singkatan AS fakultas,

            COUNT(DISTINCT y.nim) AS jumlah_lulusan,

            COUNT(
                DISTINCT CASE
                    WHEN tr.nim IS NOT NULL
                    THEN y.nim
                END
            ) AS sudah_isi_tracer,

            COUNT(DISTINCT y.nim)
            -
            COUNT(
                DISTINCT CASE
                    WHEN tr.nim IS NOT NULL
                    THEN y.nim
                END
            ) AS belum_isi_tracer,

            ROUND(
                (
                    COUNT(
                        DISTINCT CASE
                            WHEN tr.nim IS NOT NULL
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

      ->whereYear('sk.tanggal_sk', $tahun)

      ->groupBy(
        'y.nama_upbjj',
        'y.singkatan'
      )

      ->orderBy('y.nama_upbjj')
      ->orderBy('y.singkatan')

      ->get();
  }
}
