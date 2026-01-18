<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    /** Mulai alur OAuth */
    public function redirect()
    {
        // Guard: kalau env/config belum diisi, jangan crash
        $cfg = config('services.google');
        if (empty($cfg['client_id']) || empty($cfg['client_secret']) || empty($cfg['redirect'])) {
            return back()->withErrors([
                'google' => 'Google SSO belum dikonfigurasi. Isi GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI di .env',
            ]);
        }

        return Socialite::driver('google')->redirect();
        // Jika sering kena state mismatch di local, pakai:
        // return Socialite::driver('google')->stateless()->redirect();
    }

    /** Callback dari Google */
    public function callback()
    {
        try {
            $g = Socialite::driver('google')->user();
            // Jika pakai stateless di redirect(), pakai juga di sini:
            // $g = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Gagal login dengan Google: '.$e->getMessage(),
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => strtolower($g->getEmail())],
            [
                'name'     => $g->getName() ?: ($g->getNickname() ?: 'User'),
                'password' => Hash::make(Str::random(40)), // dummy
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
