<?php

namespace App\Http\Controllers\kelulusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KelulusanValidasiFoto extends Controller
{
    private const masa_yudisium = '20222';
    private function getAccessSession(): array
    {
        return [
            'akses' => strtoupper(trim(session('akses', ''))),
            'sessionunit' => strtoupper(trim(session('unit', ''))),
        ];
    }


    public function index()
    {
        $akses = 'UPBJJ';
        $sessionunit ='44';
//        $session = $this->getAccessSession();
//        $akses = $session['akses'];
//        $sessionunit = $session['sessionunit'];

        $akses = strtoupper(trim($akses));
        $sessionunit = strtoupper(trim($sessionunit));


        // =====================================================
        // QUERY DASAR
        // =====================================================

        $query = DB::table('t_yudisium as a');


        // =====================================================
        // FILTER BERDASARKAN AKSES
        // =====================================================
        $query->where(
            'a.masa',
            '>=',
            self::masa_yudisium
        );

        if ($akses === 'PUSAT' && $sessionunit === 'KL') {

            // PUSAT / KL
            // Tidak perlu filter kode_upbjj
            // Mengambil seluruh data

        } elseif ($akses === 'UPBJJ' && $sessionunit != 'KL') {

            // UPBJJ hanya melihat unit masing-masing
            $query->where(
                'a.kode_upbjj',
                $sessionunit
            );

        } else {

            // Jika akses tidak valid, jangan tampilkan data
            $query->whereRaw('1 = 0');
        }


        // =====================================================
        // HITUNG STATISTIK
        // =====================================================

        $statistik = $query
            ->selectRaw("
            COUNT(*) AS total_data,

            SUM(
                CASE
                    WHEN a.flag_foto = 1
                    THEN 1
                    ELSE 0
                END
            ) AS proses_validasi,

            SUM(
                CASE
                    WHEN a.flag_foto = 3
                    THEN 1
                    ELSE 0
                END
            ) AS gagal_validasi,

            SUM(
                CASE
                    WHEN a.flag_foto = 0
                         OR a.flag_foto IS NULL
                    THEN 1
                    ELSE 0
                END
            ) AS belum_unggah
        ")
            ->first();


        // =====================================================
        // RETURN VIEW
        // =====================================================

        return view(
            'content.pages.kelulusan.kelulusan-validasi-foto',
            compact('statistik')
        );
    }

    public function data(Request $request)
    {

        $akses = 'UPBJJ';
        $sessionunit ='44';
//        $session = $this->getAccessSession();
//        $akses = $session['akses'];
//        $sessionunit = $session['sessionunit'];
        $query = DB::table('t_yudisium as a')
            ->select([
                'a.nim',
                'a.nama_mahasiswa',
                'a.masa',
                'a.nomor_sk_rektor',
                'a.nama_upbjj',
                'a.flag_dp',
                'a.flag_foto',
                'a.info',
            ]);
        $akses = strtoupper(trim($akses));
        $sessionunit = strtoupper(trim($sessionunit));

        $query->where(
            'a.masa',
            '>=',
            self::masa_yudisium
        );

        if ($akses === 'PUSAT' && $sessionunit === 'KL') {

            // PUSAT / KL
            // Tidak perlu filter kode_upbjj
            // Mengambil seluruh data

        } elseif ($akses === 'UPBJJ' && $sessionunit != 'KL') {

            // UPBJJ hanya melihat unit masing-masing
            $query->where(
                'a.kode_upbjj',
                $sessionunit
            );

        } else {

            // Jika akses tidak valid, jangan tampilkan data
            $query->whereRaw('1 = 0');
        }

        if ($request->filled('flag_foto')) {
            $query->where('a.flag_foto', $request->flag_foto);
        }
        $query
            ->orderBy('a.nama_upbjj', 'ASC')
            ->orderBy('a.nomor_sk_rektor', 'ASC');
      $flagFoto = $request->input('flag_foto');

      $test = (clone $query)
        ->limit(10)
        ->get();


        return DataTables::query($query)
            ->addIndexColumn()
            ->toJson();
    }

}
