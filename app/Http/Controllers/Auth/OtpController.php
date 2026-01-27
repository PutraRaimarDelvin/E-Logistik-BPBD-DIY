<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class OtpController extends Controller
{
    // ===============================
    // TAMPILKAN FORM INPUT OTP
    // ===============================
public function showForm()
{
    $email = session('otp_email');

    if (!$email) {
        return redirect()->route('login')
            ->with('error', 'Session OTP sudah habis. Silakan login atau daftar ulang.');
    }

    $otp = Otp::where('email', $email)->first();

    if (!$otp) {
        return redirect()->route('login')
            ->with('error', 'OTP tidak ditemukan. Silakan kirim ulang OTP.');
    }

    // kirim expiresAt untuk countdown (format ms untuk JS)
    return view('auth.verify-otp', [
        'email' => $email,
        'expiresAt' => $otp->expires_at->timestamp * 1000,
    ]);
}


    // ===============================
    // PROSES VERIFIKASI OTP
    // ===============================
    public function verify(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'digits:6'],
        ]);

        $otp = Otp::where('email', $request->email)->first();

        if (!$otp) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak ditemukan.',
            ]);
        }

        // ❌ OTP KEDALUWARSA
        if (now()->gt($otp->expires_at)) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.',
            ]);
        }

        // ❌ OTP SALAH
        if ($otp->otp !== $request->otp) {
            return back()->withErrors([
                'otp' => 'Kode OTP tidak sesuai.',
            ]);
        }

        // ===============================
        // OTP VALID
        // ===============================
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User tidak ditemukan.',
            ]);
        }

        // Tandai email terverifikasi
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        // 🔥 HAPUS OTP AGAR TIDAK BISA DIPAKAI ULANG
        $otp->delete();

        // Login otomatis
        Auth::login($user);

        // Hapus session OTP
        session()->forget('otp_email');

        return redirect()->route('dashboard')
            ->with('success', 'Email berhasil diverifikasi. Selamat datang di E-Logistik!');
    }

    // ===============================
// KIRIM ULANG OTP
// ===============================
public function resend(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    // Hapus OTP lama
    Otp::where('email', $request->email)->delete();

    // Generate OTP baru
    $otp = rand(100000, 999999);

    Otp::create([
        'email' => $request->email,
        'otp' => $otp,
        'expires_at' => now()->addMinutes(2),
    ]);

    // Kirim email OTP 🔥
    Mail::raw("Kode OTP verifikasi akun Anda: $otp", function ($m) use ($request) {
        $m->to($request->email)
          ->subject("Kode OTP Baru - Verifikasi Akun");
    });

    // Simpan ulang session
    session(['otp_email' => $request->email]);

    return redirect()->route('otp.form')
        ->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
}
}