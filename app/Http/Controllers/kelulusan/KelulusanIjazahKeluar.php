<?php

namespace App\Http\Controllers\kelulusan;

use App\Http\Controllers\Controller;
use App\Models\query\QueryAKSIModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelulusanIjazahKeluar extends Controller
{
    public function index()
    {
        return view('content.pages.kelulusan.kelulusan_ijazah_keluar');
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

        $fotoPath = "alumni/foto-ijazah/$dpYudisium->masa/$dpYudisium->nim.jpg";
        $fotoIjazah = Storage::disk('public')->exists($fotoPath)
            ? Storage::disk('public')->url($fotoPath)
            : null;
        return view(
            'content.pages.kelulusan.kelulusan_ijazah_keluar',
            compact(
                'dpYudisium','fotoIjazah'
            )
        );
    }
}
