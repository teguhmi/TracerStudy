<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\query\LaporanQueryModel;
use Illuminate\Http\Request;

class LaporanTracerControllerRingkasan extends Controller
{
  public function index()
  {
    return view('laporan.laporan_tracer_ringkasan');
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
    $tahun = $request->tahun_lulus;
    $jenis = $request->jenis ?? 'fakultas';

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
