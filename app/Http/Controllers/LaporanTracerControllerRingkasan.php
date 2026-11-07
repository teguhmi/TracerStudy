<?php

namespace App\Http\Controllers;

use App\Models\query\LaporanQueryModel;
use Illuminate\Http\Request;

class LaporanTracerControllerRingkasan extends Controller
{
  public function index()
  {
    return view('content.laporan.laporan_tracer_ringkasan');
  }

//  public function getTahunLulus()
//  {
//    return response()->json(
//      LaporanQueryModel::getTahunLulus()
//    );
//  }


  public function getData(Request $request)
  {
    $validated = $request->validate([
      'tahun_lulus' => [
        'required',
        'digits:4',
        'integer',
        'between:2020,' . date('Y')
      ],
      'jenis' => [
        'required',
        'in:fakultas,upbjj,fakultas_upbjj'
      ]
    ]);

    $tahun = $validated['tahun_lulus'];
    $jenis = $validated['jenis'];

    $data = match ($jenis) {
      'upbjj' => LaporanQueryModel::getRekapUPBJJ($tahun),
      'fakultas_upbjj' => LaporanQueryModel::getRekapFakultasUPBJJ($tahun),
      default => LaporanQueryModel::getRekapFakultas($tahun),
    };

    return response()->json($data);
  }
}
