<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Barang; // ⬅️ Tambahkan ini


class PageController extends Controller
{
    // Landing page (seperti biasa)
    public function landing()
    {
        return view('Pages.landing');
    }

    // Dashboard utama → pakai tabel history yang sama
    public function dashboard()
    {
        $laporans = Laporan::with('items')
            ->where('user_id', auth()->id())  // ✅ Hanya laporan milik user login
            ->latest()
            ->paginate(10);

        // Pakai view yang sama dengan halaman history
        return view('dashboard.history', compact('laporans'));

    }

     public function form()
    {
        // Ambil semua barang yang stoknya masih tersedia
        $barang = Barang::where('stok', '>', 0)->get();

        return view('dashboard.form', compact('barang'));
    }
    public function history()
    {
        $laporans = Laporan::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10); // ⬅️ INI YANG MEMUNCULKAN OUTLINE

        return view('dashboard.history', compact('laporans'));
    }

    
}
