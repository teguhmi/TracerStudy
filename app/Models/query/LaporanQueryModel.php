<?php

namespace App\Models\query;

use App\Models\tracer\TracerResponden;
use Illuminate\Http\JsonResponse;
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


    $pertanyaan = [
      'q1' => 'Etika',
      'q2' => 'Keahlian pada bidang ilmu (kompetensi utama)',
      'q3' => 'Kemampuan berbahasa asing',
      'q4' => 'Penggunaan teknologi informasi',
      'q5' => 'Kemampuan berkomunikasi',
      'q6' => 'Kerjasama',
      'q7' => 'Pengembangan diri',
    ];

    $unionQuery = null;

    foreach ($pertanyaan as $kolom => $label) {
      $sub = DB::table('tbl_kuesioner_pengguna')
        ->selectRaw("? AS jenis_kemampuan, {$kolom} AS nilai", [$label])
        ->whereNotNull($kolom);

      $unionQuery = $unionQuery ? $unionQuery->unionAll($sub) : $sub;
    }

    return DB::query()
      ->fromSub($unionQuery, 'x')
      ->select([
        'jenis_kemampuan',
        DB::raw("CONCAT(SUM(CASE WHEN nilai = 4 THEN 1 ELSE 0 END), ' (', ROUND(SUM(CASE WHEN nilai = 4 THEN 1 ELSE 0 END) * 100 / COUNT(nilai), 2), '%)') AS sangat_baik"),
        DB::raw("CONCAT(SUM(CASE WHEN nilai = 3 THEN 1 ELSE 0 END), ' (', ROUND(SUM(CASE WHEN nilai = 3 THEN 1 ELSE 0 END) * 100 / COUNT(nilai), 2), '%)') AS baik"),
        DB::raw("CONCAT(SUM(CASE WHEN nilai = 2 THEN 1 ELSE 0 END), ' (', ROUND(SUM(CASE WHEN nilai = 2 THEN 1 ELSE 0 END) * 100 / COUNT(nilai), 2), '%)') AS cukup"),
        DB::raw("CONCAT(SUM(CASE WHEN nilai = 1 THEN 1 ELSE 0 END), ' (', ROUND(SUM(CASE WHEN nilai = 1 THEN 1 ELSE 0 END) * 100 / COUNT(nilai), 2), '%)') AS kurang"),
        DB::raw('COUNT(nilai) AS jumlah_responden'),
      ])
      ->groupBy('jenis_kemampuan')
      ->orderByRaw('FIELD(jenis_kemampuan, ?, ?, ?, ?, ?, ?, ?)', array_values($pertanyaan))
      ->get();

  }

  public static function getIKPS32131(mixed $tahun)
  {
    return 'getIKPS32131';
  }

  public static function getIKPS35211($tahun): Collection
  {
    $awalTahun = "{$tahun}-01-01";
    $tahunBerikutnya = ((int) $tahun + 1) . "-01-01";

    $sql = "
        SELECT
            ? AS tahun,
            l.jumlah_lulusan,

            -- Tabel 1: Bekerja (kode f8 = '1')
            COALESCE(SUM(CASE
                WHEN t.status = '1'
                     AND t.masa_tunggu <= 6
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS dibawah_6,

            COALESCE(SUM(CASE
                WHEN t.status = '1'
                     AND t.masa_tunggu > 6
                     AND t.masa_tunggu <= 12
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS diatas_6,

            COALESCE(SUM(CASE
                WHEN t.status = '1'
                     AND t.masa_tunggu <= 12
                     AND t.upah < (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS dibawah_ump_12,

            -- Tabel 2: Wirausaha (kode f8 = '3')
            COALESCE(SUM(CASE
                WHEN t.status = '3'
                     AND t.masa_tunggu <= 6
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS wirausaha_dibawah_6,

            COALESCE(SUM(CASE
                WHEN t.status = '3'
                     AND t.masa_tunggu > 6
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS wirausaha_diatas_6,

            COALESCE(SUM(CASE
                WHEN t.status = '3'
                     AND t.masa_tunggu <= 6
                     AND t.upah < (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS wirausaha_dibawah_ump_6,

            COALESCE(SUM(CASE
                WHEN t.status = '3'
                     AND t.masa_tunggu > 6
                     AND t.upah < (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS wirausaha_dibawah_ump_diatas_6,

            -- Tabel 3: Freelancer (kode f8 = '6')
            COALESCE(SUM(CASE
                WHEN t.status = '6'
                     AND t.masa_tunggu <= 6
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS freelancer_dibawah_6,

            COALESCE(SUM(CASE
                WHEN t.status = '6'
                     AND t.masa_tunggu > 6
                     AND t.upah >= (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS freelancer_diatas_6,

            COALESCE(SUM(CASE
                WHEN t.status = '6'
                     AND t.masa_tunggu <= 6
                     AND t.upah < (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS freelancer_dibawah_ump_6,

            COALESCE(SUM(CASE
                WHEN t.status = '6'
                     AND t.masa_tunggu > 6
                     AND t.upah < (1.2 * d.upah)
                     AND d.upah IS NOT NULL
                THEN 1 ELSE 0
            END), 0) AS freelancer_dibawah_ump_diatas_6,

            -- Tabel 4: Melanjutkan Studi (kode f8 = '4') & Tidak Masuk Kriteria
            COALESCE(SUM(CASE
                WHEN t.status = '4'
                THEN 1 ELSE 0
            END), 0) AS melanjutkan_studi,

            COALESCE(SUM(CASE
                WHEN t.status IS NOT NULL
                     AND NOT (
                         (t.status = '1' AND t.masa_tunggu <= 12 AND t.upah IS NOT NULL AND d.upah IS NOT NULL)
                         OR (t.status IN ('3', '6') AND t.masa_tunggu IS NOT NULL AND t.upah IS NOT NULL AND d.upah IS NOT NULL)
                         OR (t.status = '4')
                     )
                THEN 1 ELSE 0
            END), 0) AS tidak_masuk_kriteria

        FROM (
            SELECT COUNT(DISTINCT y.nim) AS jumlah_lulusan
            FROM t_yudisium y
            JOIN m_sk_rektor sk
                ON sk.nomor_sk_rektor = y.nomor_sk_rektor
            WHERE sk.tanggal_sk >= ?
              AND sk.tanggal_sk < ?
        ) l

        LEFT JOIN (
            SELECT
                b.tahun_mulai,
                a.id AS responden_id,
                MAX(CASE WHEN c.kode_pertanyaan = 'f8' THEN c.jawaban END) AS status,

                CAST(
                    NULLIF(
                        MAX(CASE WHEN c.kode_pertanyaan = 'f502' THEN c.jawaban END),
                        ''
                    ) AS SIGNED
                ) AS masa_tunggu,

                CAST(
                    NULLIF(
                        MAX(CASE WHEN c.kode_pertanyaan = 'f505'
                            THEN REPLACE(c.jawaban, '.', '')
                        END),
                        ''
                    ) AS DECIMAL(15,2)
                ) AS upah,

                MAX(CASE WHEN c.kode_pertanyaan = 'f5a1' THEN c.jawaban END) AS provinsi

            FROM tracer_respondens a
            JOIN tracer_periodes b
                ON b.id = a.periode_id
            JOIN tracer_jawabans c
                ON c.responden_id = a.id

            WHERE a.tanggal_lulus >= ?
              AND a.tanggal_lulus < ?
              AND a.kategori_id = 2
              AND c.kode_pertanyaan IN ('f8', 'f502', 'f505', 'f5a1')

            GROUP BY
                b.tahun_mulai,
                a.id

            HAVING MAX(CASE WHEN c.kode_pertanyaan = 'f8' THEN c.jawaban END) IS NOT NULL
        ) t ON 1 = 1

        LEFT JOIN tracer_upah d
            ON d.kode = t.provinsi
            AND d.tahun = t.tahun_mulai

        GROUP BY l.jumlah_lulusan
    ";

    return collect(DB::select($sql, [
      $tahun,
      $awalTahun,
      $tahunBerikutnya,
      $awalTahun,
      $tahunBerikutnya,
    ]));
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
