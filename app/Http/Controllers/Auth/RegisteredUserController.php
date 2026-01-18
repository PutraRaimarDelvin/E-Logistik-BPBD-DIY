<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpMail;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru + kirim OTP
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        // Buat OTP
        $otp = rand(100000, 999999);

        // Hapus OTP lama
        Otp::where('email', $user->email)->delete();

        // Simpan OTP baru ke tabel otps
        Otp::create([
            'email'      => $user->email,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        // Simpan session email
        session(['otp_email' => $user->email]);

        // Kirim email OTP
        Mail::raw("Kode OTP verifikasi akun Anda: $otp", function ($m) use ($user) {
            $m->to($user->email)->subject("Verifikasi Email Akun");
        });

        return redirect()->route('otp.show')
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }

    /**
     * Form OTP
     */
    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('register')->with('error', 'Sesi OTP berakhir, silakan daftar ulang.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('otp_email');
        $enteredOtp = trim($request->otp);

        if (!$email) {
            return back()->withErrors(['email' => 'Sesi OTP habis, silakan daftar ulang.']);
        }

        $otpData = Otp::where('email', $email)
                      ->where('otp', $enteredOtp)
                      ->first();

        if (!$otpData) {
            return back()->withErrors(['otp' => 'Kode OTP tidak sesuai.']);
        }

        if (Carbon::now()->gt($otpData->expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP telah kedaluwarsa.']);
        }

        // Hapus OTP setelah dipakai
        $otpData->delete();

        // Tandai email verified
        $user = User::where('email', $email)->first();
        $user->update([
            'email_verified_at' => now(),
        ]);

        // Login user
        session()->forget('otp_email');
        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Kirim ulang OTP
     */
    public function resendOtp()
    {
        $email = session('otp_email');

        if (!$email) {
            return back()->withErrors(['email' => 'Sesi OTP habis, silakan ulangi.']);
        }

        $otp = rand(100000, 999999);

        Otp::where('email', $email)->delete();

        Otp::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        Mail::raw("Kode OTP terbaru Anda: $otp", function ($m) use ($email) {
            $m->to($email)->subject("Kode OTP Baru");
        });

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }
}
