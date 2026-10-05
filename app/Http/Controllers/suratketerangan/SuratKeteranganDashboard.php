<?php

namespace App\Http\Controllers\suratketerangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuratKeteranganDashboard extends Controller
{
    public function index()
    {
        return view('pages.surat-keterangan.suratketerangan-dashboard');
    }
}
