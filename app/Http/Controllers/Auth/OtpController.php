<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    // TAMPILKAN FORM INPUT OTP
    public function showForm()
    {
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Session OTP sudah habis. Silakan login atau daftar ulang.');
        }

        return view('auth.verify-otp', compact('email'));
    }

    // PROSES VERIFIKASI OTP
    public function verify(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'digits:6'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.'])->withInput();
        }

        // Cek OTP & masa berlaku
        if (
            $user->email_otp !== $request->otp ||
            !$user->email_otp_expires_at ||
            now()->greaterThan($user->email_otp_expires_at)
        ) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kedaluwarsa.'])->withInput();
        }

        // OTP valid -> tandai email verified
        $user->forceFill([
            'email_verified_at' => now(),
            'email_otp'         => null,
            'email_otp_expires_at' => null,
        ])->save();

        // Login otomatis
        Auth::login($user);

        // Hapus data email OTP di session
        session()->forget('otp_email');

        return redirect()->route('dashboard')
            ->with('success', 'Email berhasil diverifikasi. Selamat datang di E-Logistik!');
    }
}
