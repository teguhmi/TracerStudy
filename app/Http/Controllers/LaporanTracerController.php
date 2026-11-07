<?php

namespace App\Http\Controllers;


class LaporanTracerController extends Controller
{
  public function index()
  {
    $json = file_get_contents(
      resource_path('menu/tracer_laporan.json')
    );

    $data = json_decode($json, true);

    $menuData = $data['menu'] ?? [];

    return view('content.laporan.laporan_index', compact('menuData'));
  }
}
