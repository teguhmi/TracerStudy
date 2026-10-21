<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\query\QueryAKSIModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Login extends Controller
{
  public function index()
  {


    // User Laravel sudah login
//    if (Auth::check()) {
//      return redirect()->route('home');
//    }
//
//    // Alumni sudah login
//    if (session('alumni_authenticated')) {
//      return redirect()->route('home');
//    }

    return view('auth.auth-login');
  }


  public function login(Request $request)
  {
    /*
    |--------------------------------------------------------------------------
    | Tentukan jenis login
    |--------------------------------------------------------------------------
    */

    $request->validate([
      'login_type' => 'required|in:alumni,user',
    ]);
    if ($request->login_type === 'alumni') {
      return $this->loginAlumni($request);
    }
    return $this->loginUser($request);
  }


  /*
  |--------------------------------------------------------------------------
  | LOGIN ALUMNI
  |--------------------------------------------------------------------------
  */

  private function loginAlumni(Request $request)
  {
    $request->validate([
      'nim' => [
        'required',
        'string',
        'max:20',
      ],

      'tanggal_lahir' => [
        'required',
        'date_format:d/m/Y',
      ],
    ],
      [
        'nim.required' =>
          'NIM wajib diisi.',

        'tanggal_lahir.required' =>
          'Tanggal lahir wajib diisi.',

        'tanggal_lahir.date_format' =>
          'Format tanggal lahir harus DD/MM/YYYY.',
      ]);


    /*
    |--------------------------------------------------------------------------
    | Konversi tanggal
    |--------------------------------------------------------------------------
    |
    | 24/01/1983
    | menjadi
    | 1983-01-24
    |
    */

//    $tanggalLahir = Carbon::createFromFormat(
//      'Y-m-d',
//      $request->tanggal_lahir
//    )->format('d-m-Y');

    $tanggalLahir = $request->tanggal_lahir;
    /*
    |--------------------------------------------------------------------------
    | Cari data alumni
    |--------------------------------------------------------------------------
    */

    $alumni = QueryAKSIModel::getDpByNimTanggalLahir($request->nim, $tanggalLahir);
    /*
    |--------------------------------------------------------------------------
    | Login gagal
    |--------------------------------------------------------------------------
    */

    if (!$alumni) {
      return back()
        ->withInput($request->only('login_type', 'alumni'))->withErrors(['login' => 'NIM atau tanggal lahir tidak sesuai.']);
    }


    /*
    |--------------------------------------------------------------------------
    | Regenerate session
    |--------------------------------------------------------------------------
    */

    $request->session()->regenerate();


    /*
    |--------------------------------------------------------------------------
    | Session Alumni
    |--------------------------------------------------------------------------
    */
    session([
      'login_type' => 'alumni',
      'alumni_authenticated' => true,
      'nim' => $alumni->nim,
      'nama_mahasiswa' => $alumni->nama_mahasiswa,
      'tanggal_lulus' => $alumni->tanggal_sk,
      'alumni' => $alumni,
    ]);


    return redirect()
      ->intended(route('tracer.index'));
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
    | Laravel Authentication
    |--------------------------------------------------------------------------
    */

    if (!Auth::attempt(
      $credentials,
      $request->boolean('remember')
    )) {

      return back()
        ->withInput(
          $request->only(
            'login_type',
            'email'
          )
        )
        ->withErrors([
          'login' =>
            'Email atau password tidak sesuai.'
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Regenerate session
    |--------------------------------------------------------------------------
    */

    $request->session()->regenerate();


    /*
    |--------------------------------------------------------------------------
    | Jenis login
    |--------------------------------------------------------------------------
    */

    $request->session()->put(
      'login_type',
      'user'
    );


    return redirect()
      ->intended(route('dashboard'));
  }


  /*
  |--------------------------------------------------------------------------
  | LOGOUT
  |--------------------------------------------------------------------------
  */

  public function logout(Request $request)
  {
    /*
    |--------------------------------------------------------------------------
    | Logout Laravel Auth jika user login
    |--------------------------------------------------------------------------
    */

    if (Auth::check()) {
      Auth::logout();
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus session
    |--------------------------------------------------------------------------
    */

    $request->session()->invalidate();

    $request->session()->regenerateToken();
    return redirect()
      ->route('home');
  }
}
