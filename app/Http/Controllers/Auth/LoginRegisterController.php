<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class LoginRegisterController extends Controller
{
    /** Tampilkan halaman login */
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.laporan.index')
                : redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /** LOGIN EMAIL + PASSWORD */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => strtolower($request->email),
            'password' => $request->password
        ])) {
            $request->session()->regenerate();

            return Auth::user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /** OTP LOGIN (opsional — tetap disimpan jika ingin dipakai nanti) */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $email = strtolower(trim($request->email));

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        Otp::where('email', $email)->delete();

        $otp = rand(100000, 999999);

        Otp::create([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        Mail::raw("Kode OTP login Anda adalah: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Kode OTP Login E-Logistik BPBD');
        });

        session(['otp_email' => $email]);

        return redirect()->route('otp.show')
            ->with('info', 'Kode OTP sudah dikirim ke email Anda.');
    }

    public function showOtpForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6']
        ]);

        $email = session('otp_email');

        if (!$email) {
            return back()->withErrors(['otp' => 'Sesi OTP habis, silakan login ulang.']);
        }

        $otpData = Otp::where('email', $email)->orderBy('id', 'DESC')->first();

        if (!$otpData || $otpData->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if (Carbon::now()->greaterThan($otpData->expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP kadaluarsa.']);
        }

        $otpData->delete();

        $user = User::where('email', $email)->first();
        Auth::login($user);

        session()->forget('otp_email');

        return $user->is_admin
            ? redirect()->route('admin.laporan.index')
            : redirect()->route('dashboard');
    }

    /** LOGOUT */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
