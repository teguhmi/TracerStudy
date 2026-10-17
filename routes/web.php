<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TracerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\Login;
use App\Http\Controllers\authentications\RegisterBasic;

Route::get('/refreshCaptcha', [HomeController::class, 'refreshCaptcha'])->name('refresh.captcha');


// locale
//Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
//Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login', [Login::class, 'index'])->name('login');
Route::post('/auth/login', [Login::class, 'login'])->name('auth-login-process');
Route::post('/auth/logout', [Login::class, 'logout'])->name('auth-logout');


//Route::get('/auth/register', [RegisterBasic::class, 'index'])->name('auth-register');

//Route::view('/', 'content.pages.welcome')->name('home');
Route::get('/', [HomeController::class, 'index'])
  ->name('home');

Route::middleware(['auth'])->prefix('alumni')->group(function () {

  Route::get('/dashboard', function () {
    return view('alumni.dashboard');
  })->name('alumni.dashboard');

  Route::get('/profil', function () {
    return view('alumni.profil');
  })->name('alumni.profil');

  Route::get('/tracer-study', function () {
    return view('alumni.tracer-study');
  })->name('alumni.tracer-study');

  Route::get('/survey', function () {
    return view('alumni.survey');
  })->name('alumni.survey');

  Route::get('/dana-abadi', function () {
    return view('alumni.dana-abadi');
  })->name('alumni.dana-abadi');


});



Route::get('/tracer',[TracerController::class, 'index'])->name('tracer.index');
Route::get('/tracer/kota/{provinsi}', [TracerController::class, 'getKotas'])->name('tracer.kotas');
Route::post('/tracer',[TracerController::class, 'store'])->name('tracer.simpan');

Route::post(
  '/tracer/submit',
  [TracerController::class, 'submit']
)->name('tracer.submit');

Route::get(
  '/tracer/riwayat',
  [TracerController::class, 'riwayat']
)->name('tracer.riwayat');
