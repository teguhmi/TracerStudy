<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
  public function getNegaras()
  {
    return response()->json(
      DB::table('m_negaras')
        ->where('status_aktif', 1)
        ->orderBy('nama_negara')
        ->get()
    );
  }
  public function getProvinsis($negara)
  {
    return response()->json(
      DB::table('m_provinsis')
        ->where('negara_id', $negara)
        ->where('status_aktif', 1)
        ->orderBy('nama_provinsi')
        ->get()
    );
  }
  public function getKabupatenKotas($provinsi)
  {
    return response()->json(
      DB::table('m_kabupaten_kotas')
        ->where('provinsi_id', $provinsi)
        ->where('status_aktif', 1)
        ->orderBy('nama_kabupaten_kota')
        ->get()
    );
  }
}
