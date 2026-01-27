<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
   public function index(Request $request)
{
    // Tahun aktif (default: tahun sekarang)
    $year = $request->get('year', now()->year);

    // ===== RINGKASAN =====
    $totalLaporan   = Laporan::count();
    $totalMenunggu  = Laporan::where('status_validasi', 'Menunggu')->count();
    $totalDisetujui = Laporan::where('status_validasi', 'Disetujui')->count();
    $totalDitolak   = Laporan::where('status_validasi', 'Ditolak')->count();
    $totalUserMelapor = Laporan::distinct('user_id')->count('user_id');

    // ===== LIST TAHUN (UNTUK DROPDOWN) =====
    $years = Laporan::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // ===== BULAN =====
    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    // ===== DATA GRAFIK (CONTOH STRUKTUR, SESUAIKAN FIELD KABUPATEN) =====
    $chartData = [
        'Sleman' => array_fill(0, 12, 0),
        'Bantul' => array_fill(0, 12, 0),
        'Kulon Progo' => array_fill(0, 12, 0),
        'Gunungkidul' => array_fill(0, 12, 0),
        'Kota Yogyakarta' => array_fill(0, 12, 0),
    ];

    $laporan = Laporan::whereYear('created_at', $year)->get();

    foreach ($laporan as $item) {
        $bulan = Carbon::parse($item->created_at)->month - 1;
        $kab = $item->kabupaten; // pastikan nama kolom ini BENAR

        if (isset($chartData[$kab])) {
            $chartData[$kab][$bulan]++;
        }
    }

    return view('admin.dashboard', compact(
        'totalLaporan',
        'totalMenunggu',
        'totalDisetujui',
        'totalDitolak',
        'totalUserMelapor',
        'months',
        'chartData',
        'years',
        'year'
    ));
}
}