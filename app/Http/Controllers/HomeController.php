<?php

namespace App\Http\Controllers;

use App\Models\BannerAlumni;
use App\Models\PortalHero;
use App\Services\Api\AlumniService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $hero = PortalHero::current();

    $setting = DB::table('portal_settings')
      ->first();

    $layanans = DB::table('portal_layanans')
      ->where('aktif', 1)
      ->orderBy('urutan')
      ->get();

    $banner = DB::table('portal_banners')
      ->where('aktif', 1)
      ->first();

    $beritas = DB::table('portal_beritas')
      ->where('publish', 1)
      ->orderByDesc('tanggal')
      ->limit(6)
      ->get();

    return view('frontpage.index', compact(
      'hero','setting',
      'layanans',
      'banner',
      'beritas'
    ));
  }


}
