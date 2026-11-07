<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class MicrosoftController extends Controller
{
  public function redirect()
  {
    $provider = Socialite::driver('microsoft');

    return $provider->stateless()->redirect();
  }



  public function callback()
  {
    try {

      /** @var AbstractProvider $provider */
      $provider = Socialite::driver('microsoft');

      $msUser = $provider
        ->stateless()
        ->user();

      $email = $msUser->getEmail();

      if (!$email) {
        return redirect('/login')
          ->with('error', 'Email Microsoft tidak ditemukan.');
      }

      $user = User::firstOrCreate(
        [
          'email' => $email,
        ],
        [
          'name' => $msUser->getName(),
          'password' => bcrypt(Str::random(32)),
          'email_verified_at' => now(),
        ]
      );

      Auth::login($user, true);

      session([
        'login_type' => 'office365',
        'email'      => $email,
        'nama'       => $msUser->getName(),
        'oid'        => $msUser->getId(),
      ]);

      return redirect()->route('home');

    } catch (\Throwable $e) {

      return redirect('home')
        ->with('error', $e->getMessage());

    }
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
  }
}
