<?php

namespace App\Http\Controllers;

use App\Models\BannerAlumni;
use App\Services\Api\AlumniService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function __construct(
    protected AlumniService $alumniService
  ) {
  }
  public function refreshCaptcha()
  {
    return response()->json(['captcha' => captcha_img()]);

  }

  public function index()
  {
   return view('frontpage.index');
  }
}
