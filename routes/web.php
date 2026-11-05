<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanTracerController;
use App\Http\Controllers\LaporanTracerControllerRingkasan;
use App\Http\Controllers\TracerController;
use App\Http\Middleware\AlumniAuthenticated;
use App\Models\query\LaporanQueryModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\Login;

Route::get('/reload-captcha', function () {
  return response()->json([
    'captcha' => captcha_img('flat')
  ]);
})->name('reload.captcha');


Route::middleware(AlumniAuthenticated::class)->group(function () {
  Route::get('/tracer', [TracerController::class, 'index'])->name('tracer.index');
  Route::post('/tracer', [TracerController::class, 'store'])->name('tracer.simpan');

});
Route::get('/tracer/kota/{provinsi}', [TracerController::class, 'getKotas'])->name('tracer.kotas');
Route::get('/ajax/negaras', [AjaxController::class, 'getNegaras']);
Route::get('/ajax/provinsis/{negara}', [AjaxController::class, 'getProvinsis']);
Route::get('/ajax/kabupaten-kotas/{provinsi}', [AjaxController::class, 'getKabupatenKotas']);



// authentication
Route::get('/auth/login', [Login::class, 'index'])->name('login-alumni');
Route::post('/auth/login', [Login::class, 'login'])->name('auth-login-process');
Route::POST('/auth/logout', [Login::class, 'logout'])->name('auth-logout');


Route::get('/', [HomeController::class, 'index'])
  ->name('home');

Route::group(['prefix' => 'laporan'], function () {
  Route::get('/', [LaporanTracerController::class, 'index'])->name('laporan-tracer.index');
  Route::get('/ts/ri', [LaporanTracerControllerRingkasan::class, 'index'])->name('laporan.tracerRingkasan');
  Route::get('/getTahunLulus', function () {return response()->json(LaporanQueryModel::class::getTahunLulus());})->name('laporan.getTahunLulus');
  Route::get(
    '/laporan/ts/ri/data',
    [LaporanTracerControllerRingkasan::class, 'getData']
  )->name('laporan.tracerRingkasan.data');
});






