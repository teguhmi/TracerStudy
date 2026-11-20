<?php

namespace App\Http\Controllers;

use App\Models\MasterIKPS;
use App\Models\MasterUnit;
use App\Models\query\LaporanQueryModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LaporanIKPS extends Controller
{
  public function index()
  {
    $tahun = LaporanQueryModel::getTahunLulus();
    $ikps  = MasterIKPS::orderBy('nama')->get();
    $units = MasterUnit::where('tampil', '1')
      ->orderByRaw("
        CASE
            WHEN kode_upbjj = 'X3000' THEN 0
            ELSE CAST(kode_upbjj AS UNSIGNED)
        END
    ")
      ->get();
    $data  = collect();

    return view(
      'content.laporan.ikps.laporan_tracer_ikps',
      compact('tahun', 'ikps', 'data','units')
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
      'unit_id' => [
        'nullable',
        Rule::requiredIf(function () use ($request) {
          return strtolower(trim((string) $request->input('jenis'))) === 'ikps30142';
        }),
      ],
      'jenis' => [
        'required',
        Rule::exists('master_ikps', 'kode'),
      ],
    ]);

    $tahun = (int) $validated['tahun_lulus'];
    $jenis = strtolower(trim((string) $validated['jenis']));
    $unit  = ($jenis === 'ikps30142') ? ($validated['unit_id'] ?? 0) : 0;

    $units = MasterUnit::where('tampil', '1')
      ->orderByRaw("
            CASE
                WHEN kode_upbjj = 'X3000' THEN 0
                ELSE CAST(kode_upbjj AS UNSIGNED)
            END
        ")
      ->get();

    switch ($jenis) {

      case 'ikps30142':
        $data = LaporanQueryModel::getIKPS30142($tahun, $unit);
        break;

      case 'ikps32131':
        $data = LaporanQueryModel::getIKPS32131($tahun, $unit);
        break;

      case 'ikps35211':
        $data = LaporanQueryModel::getIKPS35211($tahun, $unit);
        break;

      case 'ikps35212':
        $data = LaporanQueryModel::getIKPS35212($tahun, $unit);
        break;

      default:
        $data = collect();
        break;
    }

    $tahunList = LaporanQueryModel::getTahunLulus();

    $ikps = MasterIKPS::orderBy('nama')->get();

    return view(
      'content.laporan.ikps.laporan_tracer_ikps',
      [
        'tahun' => $tahunList,
        'ikps'  => $ikps,
        'units' => $units,
        'data'  => $data,
      ]
    );
  }
}
