<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function refreshCaptcha()
  {
    return response()->json(['captcha' => captcha_img()]);

  }
}
