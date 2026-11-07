<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\query\LaporanQueryModel;
use Illuminate\Http\Request;

class LaporanTracerControllerRingkasan extends Controller
{
  public function index()
  {
    return view('content.laporan.laporan_tracer_ringkasan');
  }

  public function getTahunLulus()
  {
    return response()->json(
      LaporanQueryModel::getTahunLulus()
    );
  }

//  public function getData(Request $request)
//  {
//    return response()->json(
//      LaporanQueryModel::getRekapFakultas(
//        $request->tahun_lulus
//      )
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

    switch ($jenis) {

      case 'upbjj':
        $data = LaporanQueryModel::getRekapUPBJJ($tahun);
        break;

      case 'fakultas_upbjj':
        $data = LaporanQueryModel::getRekapFakultasUPBJJ($tahun);
        break;

      default:
        $data = LaporanQueryModel::getRekapFakultas($tahun);
        break;
    }

    return response()->json($data);
  }
}
