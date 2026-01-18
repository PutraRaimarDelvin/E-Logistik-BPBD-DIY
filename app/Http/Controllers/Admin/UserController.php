<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // <-- Impor model User
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {
        // Ambil semua user, KECUALI admin yang sedang login
        // (Anda tidak ingin admin menurunkan jabatannya sendiri secara tidak sengaja)
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Mengubah status admin seorang user (dari admin -> user, atau user -> admin)
     */
    public function toggleAdmin(User $user)
    {
        // 'User $user' (route-model binding) akan otomatis 
        // menemukan user berdasarkan {user} (ID) di URL.

        // Logika "toggle" sederhana:
        // Jika is_admin = 1, ubah jadi 0. Jika 0, ubah jadi 1.
        $user->is_admin = !$user->is_admin;
        $user->save();

        // Siapkan pesan sukses
        $message = $user->is_admin 
            ? "Berhasil: {$user->name} sekarang adalah Admin."
            : "Berhasil: {$user->name} sekarang adalah User biasa.";

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}