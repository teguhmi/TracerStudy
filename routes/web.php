<?php

use App\Http\Controllers\alumni\AlumniDashboard;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\kelulusan\KelulusanIjazahMasuk;
use App\Http\Controllers\kelulusan\KelulusanValidasiBerkas;
use App\Http\Controllers\kelulusan\KelulusanValidasiFoto;
use App\Http\Controllers\suratketerangan\SuratKeteranganDashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;

Route::get('/refreshCaptcha', [HomeController::class, 'refreshCaptcha'])->name('refresh.captcha');

// Main Page Route
Route::get('/h', [HomePage::class, 'index'])->name('pages-home');
//Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
//Route::get('/lang/{locale}', [LanguageController::class, 'swap']);
//Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login', [LoginBasic::class, 'index'])->name('auth-login');
Route::post('/auth/login', [LoginBasic::class, 'login'])->name('auth-login-process');
Route::post('/auth/logout', [LoginBasic::class, 'logout'])->name('auth-logout');


Route::get('/auth/register', [RegisterBasic::class, 'index'])->name('auth-register');

Route::get('/', function () {
  return view('content.pages.welcome')->name();
});

Route::group(['prefix' => 'alumni'], function () {
  Route::get('/', [AlumniDashboard::class, 'index'])->name('alumni-dashboard.index');
  Route::post('/alumni/foto-ijazah', [AlumniDashboard::class, 'uploadFotoIjazah'])->name('alumni.foto-ijazah');

  Route::get('/validasi', [\App\Http\Controllers\alumni\AlumniValidasiController::class, 'index'])->name('alumni-validasi.index');
  Route::post('/validasi', [\App\Http\Controllers\alumni\AlumniValidasiController::class, 'index'])->name('alumni-validasi.view-pdf');
//  Route::get('/validasi', [\App\Http\Controllers\alumni\AlumniValidasiController::class, 'index'])->name('alumni-validasi.index');
});


Route::group(['prefix' => 'kelulusan'], function () {
  Route::get('/foto', [KelulusanValidasiFoto::class, 'index'])->name('kelulusan.foto.index');
  Route::get('/foto/data', [KelulusanValidasiFoto::class, 'data'])->name('kelulusan.foto.data');
//    Route::get('/detail/{nim}', [KelulusanValidasiFoto::class, 'show'])->name('kelulusanfoto..show');


  Route::get('/berkas', [KelulusanValidasiBerkas::class, 'index'])->name('kelulusan.berkas.index');

    Route::get('/im', [KelulusanIjazahMasuk::class, 'index'])
        ->name('im.index');

    Route::post('/im/cari', [KelulusanIjazahMasuk::class, 'cari'])
        ->name('im.cari');

});

Route::group(['prefix' => 'suratketerangan'], function () {
  Route::get('/', [SuratKeteranganDashboard::class, 'index'])->name('suratketerangan-dashboard.index');
});




Route::get('/data-sika', [\App\Http\Controllers\alumni\AlumniValidasiController::class, 'data_sika'])->name('alumni-validasi.data-sika');
