<?php

namespace App\Http\Controllers\kelulusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelulusanValidasiBerkas extends Controller
{
    public function index()
    {
        return view('pages.kelulusan.kelulusan-validasi-berkas');
    }
}
