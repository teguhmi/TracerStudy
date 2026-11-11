<?php

namespace App\Http\Controllers;

use App\Models\MasterIKPS;
use App\Models\query\LaporanQueryModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LaporanIKPS extends Controller
{
  public function index()
  {
    $tahun = LaporanQueryModel::getTahunLulus();
    $ikps  = MasterIKPS::orderBy('nama')->get();
    $data  = collect();

    return view(
      'content.laporan.laporan_tracer_ikps',
      compact('tahun', 'ikps', 'data')
    );
  }

  public function getData(Request $request)
  {
    $validated = $request->validate([
      'tahun_lulus' => [
        'required',
        'integer',
        'digits:4',
        'between:2020,' . date('Y'),
      ],
      'jenis' => [
        'required',
        Rule::exists('master_ikps', 'kode'),
      ],
    ]);

    $tahun = $validated['tahun_lulus'];
    $jenis = $validated['jenis'];
    switch ($jenis) {

      case 'ikps30142':
        $data = LaporanQueryModel::getIKPS30142($tahun);
        break;

      case 'ikps32131':
        $data = LaporanQueryModel::getIKPS32131($tahun);
        break;

      case 'ikps35211':
        $data = LaporanQueryModel::getIKPS35211($tahun);
        break;

      case 'ikps35212':
        $data = LaporanQueryModel::getIKPS35212($tahun);
        break;

      default:
        $data = collect();
        break;
    }
    $tahunList = LaporanQueryModel::getTahunLulus();

    $ikps = MasterIKPS::orderBy('nama')->get();

    return view(
      'content.laporan.laporan_tracer_ikps',
      [
        'tahun' => $tahunList,
        'ikps'  => $ikps,
        'data'  => $data,
      ]
    );
  }
}
