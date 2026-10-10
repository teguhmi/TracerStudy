<?php

namespace App\Http\Controllers\kelulusan;

use App\Http\Controllers\Controller;
use App\Models\query\QueryAKSIModel;
use Illuminate\Http\Request;

class KelulusanIjazahMasuk extends Controller
{
    public function index()
    {
                return view('content.pages.kelulusan.kelulusan_ijazah_masuk');
    }

    public function cari(Request $request)
    {
        $request->validate([
            'nim' => 'required'
        ]);


        $dpYudisium = QueryAKSIModel::getYudisiumByNim(
            $request->nim
        );

        if (!$dpYudisium) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $daftarLulusan = QueryAKSIModel::getDaftarLulusanBySK(
            $dpYudisium->nomor_sk_rektor
        );

        return view(
            'content.pages.kelulusan.kelulusan_ijazah_masuk',
            compact(
                'dpYudisium',
                'daftarLulusan'
            )
        );
    }


//    public function store(Request $request)
//    {
//        QueryAKSIModel::create([
//            'nim'                    => $request->nim,
//            'nama_mahasiswa'         => $request->nama_mahasiswa,
//            'program_studi'          => $request->program_studi,
//            'masa_yudisium'          => $request->masa_yudisium,
//            'nomor_sk_rektor'        => $request->nomor_sk_rektor,
//            'nomor_surat_pengiriman' => $request->nomor_surat_pengiriman,
//        ]);
//
//        return redirect()
//            ->route('kelulusan.kelulusan_ijazah_masuk')
//            ->with('success', 'Data berhasil disimpan');
//    }
}
