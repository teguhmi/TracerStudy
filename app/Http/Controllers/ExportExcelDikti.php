<?php

namespace App\Http\Controllers;

use App\Models\tracer\TracerResponden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportExcelDikti extends Controller
{
  public function index(Request $request)
  {

    $tahun = 2024;

    $nims = TracerResponden::query()
      ->whereYear('tanggal_lulus', $tahun)
      ->pluck('nim');

    $data = DB::table('v_tracer_pddikti')
      ->where('tahun_lulus', $tahun)
      ->get();
  }
}
