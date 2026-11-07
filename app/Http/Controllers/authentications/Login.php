<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\query\QueryAKSIModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class Login extends Controller
{
  public function index()
  {
    // User/Admin sudah login
    if (Auth::check()) {
      return redirect()->route('home');
    }

    // Alumni sudah login
    if (
      session('login_type') === 'alumni' &&
      session('alumni_authenticated') &&
      session()->has('nim')
    ) {
      return redirect()->route('tracer.index');
    }

    return view('auth.auth-login');
  }

  public function login(Request $request)
  {
    $request->validate([
      'login_type' => 'required|in:alumni,user',
    ]);

    return $request->login_type === 'alumni'
      ? $this->loginAlumni($request)
      : $this->loginUser($request);
  }

  /*
  |--------------------------------------------------------------------------
  | LOGIN ALUMNI
  |--------------------------------------------------------------------------
  */

  private function loginAlumni(Request $request)
  {
    $request->validate(
      [
        'nim' => [
          'required',
          'digits:9',
        ],
        'tanggal_lahir' => [
          'required',
          'date_format:d/m/Y',
        ],
        'captcha' => [
          'required',
          'captcha',
        ],
      ],
      [
        'nim.required' => 'NIM wajib diisi.',
        'nim.digits'   => 'NIM harus 9 digit angka.',

        'tanggal_lahir.required'    => 'Tanggal lahir wajib diisi.',
        'tanggal_lahir.date_format' => 'Format tanggal lahir harus DD/MM/YYYY.',

        'captcha.required' => 'Kode captcha wajib diisi.',
        'captcha.captcha'  => 'Kode captcha yang Anda masukkan tidak sesuai.',
      ]
    );

    $key = 'login-alumni:' . Str::lower($request->nim) . '|' . $request->ip();
    $keyNim = 'login-alumni-nim:' . $request->nim;

    /*
    |--------------------------------------------------------------------------
    | Rate Limiter Alumni
    |--------------------------------------------------------------------------
    */
    if (
      RateLimiter::tooManyAttempts($key, 5) ||
      RateLimiter::tooManyAttempts($keyNim, 20)
    ) {
      $seconds = max(
        RateLimiter::availableIn($key),
        RateLimiter::availableIn($keyNim)
      );

      return back()
        ->withInput($request->only('login_type', 'nim'))
        ->withErrors([
          'login' => "Terlalu banyak percobaan login. Coba lagi dalam $seconds detik.",
        ]);
    }

    $alumni = QueryAKSIModel::getDpByNimTanggalLahir(
      $request->nim,
      $request->tanggal_lahir
    );

    if (!$alumni) {
      RateLimiter::hit($key, 900);
      RateLimiter::hit($keyNim, 3600);

      return back()
        ->withInput([
          'login_type' => 'alumni',
          'nim'        => $request->nim,
        ])
        ->withErrors([
          'login' => 'NIM atau tanggal lahir tidak sesuai.',
        ]);
    }

    RateLimiter::clear($key);
    RateLimiter::clear($keyNim);

    $request->session()->forget([
      'login_type',
      'alumni_authenticated',
      'nim',
      'nama_mahasiswa',
      'tanggal_lulus',
    ]);

    $request->session()->regenerate();

    session([
      'login_type'           => 'alumni',
      'alumni_authenticated' => true,
      'nim'                  => $alumni->nim,
      'nama_mahasiswa'       => $alumni->nama_mahasiswa,
      'tanggal_lulus'        => $alumni->tanggal_sk,
    ]);

    return redirect()->route('tracer.index');
  }

  /*
  |--------------------------------------------------------------------------
  | LOGIN USER / ADMIN
  |--------------------------------------------------------------------------
  */

  private function loginUser(Request $request)
  {
    $credentials = $request->validate([
      'email' => [
        'required',
        'email',
      ],
      'password' => [
        'required',
        'string',
      ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Rate Limiter User/Admin (Proteksi Brute-Force)
    |--------------------------------------------------------------------------
    */
    $key = 'login-user:' . Str::lower($request->email) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($key, 5)) {
      $seconds = RateLimiter::availableIn($key);

      return back()
        ->withInput($request->only('login_type', 'email'))
        ->withErrors([
          'login' => "Terlalu banyak percobaan login. Coba lagi dalam $seconds detik.",
        ]);
    }

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
      RateLimiter::hit($key, 300);

      return back()
        ->withInput($request->only('login_type', 'email'))
        ->withErrors([
          'login' => 'Email atau password tidak sesuai.',
        ]);
    }

    RateLimiter::clear($key);

    $request->session()->forget([
      'login_type',
      'alumni_authenticated',
      'nim',
      'nama_mahasiswa',
      'tanggal_lulus',
    ]);

    $request->session()->regenerate();

    session([
      'login_type' => 'user',
    ]);

    return redirect()->intended(route('home'));
  }

  /*
  |--------------------------------------------------------------------------
  | LOGOUT
  |--------------------------------------------------------------------------
  */

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
  }
}
