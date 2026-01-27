<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Pages (landing + dashboard)
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\OtpController;


// Auth
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\GoogleController;

// Laporan User
use App\Http\Controllers\LaporanController;

// Laporan Admin
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\AdminProfileController; // ⬅ ini yang harus ditambahkan
use App\Http\Controllers\Admin\DashboardAdminController;


// Profil
use App\Http\Controllers\ProfileController;

// Manajemen User Admin
use App\Http\Controllers\Admin\UserController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'landing'])->name('landing');
Route::redirect('/home', '/dashboard')->name('home.redirect');


/*
|--------------------------------------------------------------------------
| GUEST ONLY (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginRegisterController::class, 'showLogin'])->name('login');

       
    // Form lupa password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Kirim email reset
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Form reset password
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Simpan password baru
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');

    // Login normal EMAIL + PASSWORD
    Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.submit');

    // OTP login (optional)
    Route::post('/login/send-otp', [LoginRegisterController::class, 'sendOtp'])->name('login.sendOtp');

    // Register
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // OTP verifikasi (REGISTER)
    Route::get('/verify-otp', [OtpController::class, 'showForm'])
        ->name('otp.form');

    Route::post('/verify-otp', [OtpController::class, 'verify'])
        ->name('otp.verify');

    Route::post('/resend-otp', [OtpController::class, 'resend'])
        ->name('otp.resend');
});

// Google OAuth Routes
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


    



/*
|--------------------------------------------------------------------------
| AUTH USER ROUTES (Sudah Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ===== FIX EMAIL VERIFICATION ROUTE =====
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verifikasi-terkirim');
    })->name('verification.send');


    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Dashboard User
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // History
    Route::get('/dashboard/history', [LaporanController::class, 'index'])->name('dashboard.history');
    Route::get('/dashboard/history/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/dashboard/history/{laporan}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/dashboard/history/{laporan}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/dashboard/history/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // Form laporan
Route::get('/dashboard/form', [PageController::class, 'form'])->name('dashboard.form');
    Route::post('/dashboard/form', [LaporanController::class, 'store'])->name('laporan.store');

    // Logout
Route::post('/logout', [LoginRegisterController::class, 'logout'])
    ->name('logout');

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])
            ->name('dashboard');

        // Laporan
        Route::get('/laporan', [LaporanAdminController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{id}', [LaporanAdminController::class, 'show'])
            ->name('laporan.show');

        Route::post('/laporan/{id}/update-status',
            [LaporanAdminController::class, 'updateStatus']
        )->name('laporan.updateStatus');

        Route::get('/laporan/{id}/pdf',
            [LaporanAdminController::class, 'exportPdf']
        )->name('laporan.pdf');


        // User Management
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::post('/users/{user}/toggle-admin',
            [UserController::class, 'toggleAdmin']
        )->name('users.toggleAdmin');


      
        // PROFIL ADMIN
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [AdminProfileController::class, 'updatePassword'])
    ->name('profile.password.update');

     // Barang
    Route::get('/barang', [\App\Http\Controllers\Admin\BarangController::class, 'index'])->name('barang.index');
    Route::post('/barang', [\App\Http\Controllers\Admin\BarangController::class, 'store'])->name('barang.store');
    Route::put('/barang/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'destroy'])->name('barang.destroy');


;

    });


    


/*
|--------------------------------------------------------------------------
| FALLBACK 404
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    abort(404);
});
