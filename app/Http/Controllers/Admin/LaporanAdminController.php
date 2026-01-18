<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanAdminController extends Controller
{
    /* ============================================================
     | ADMIN: LIST LAPORAN
     ============================================================ */
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'items.barang'])
            ->orderByDesc('created_at');

        if ($request->filled('tanggal')) {
            $query->whereDay('created_at', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kejadian')) {
            $keyword = '%' . trim($request->kejadian) . '%';

            $query->where(function ($q) use ($keyword) {
                $q->where('jenis_bencana', 'LIKE', $keyword)
                  ->orWhere('desa', 'LIKE', $keyword)
                  ->orWhere('kelurahan', 'LIKE', $keyword)
                  ->orWhere('kecamatan', 'LIKE', $keyword)
                  ->orWhere('kabupaten', 'LIKE', $keyword)
                  ->orWhereHas('user', function ($u) use ($keyword) {
                      $u->where('name', 'LIKE', $keyword);
                  });
            });
        }

        $laporans = $query->paginate(6)->withQueryString();

        return view('admin.laporan.index', compact('laporans'));
    }

    /* ============================================================
     | ADMIN: DETAIL LAPORAN
     ============================================================ */
    public function show($id)
    {
        $laporan = Laporan::with(['user', 'items.barang'])->findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }

    /* ============================================================
     | ADMIN: UPDATE STATUS + BARANG (FINAL FIX)
     ============================================================ */
    public function updateStatus(Request $request, $id)
    {
        /* ================= VALIDASI ================= */
        $request->validate([
            'status_validasi' => 'required|in:Menunggu,Disetujui,Ditolak',
            'catatan_admin'   => 'nullable|string',
            'nomor_surat'     => 'nullable|string|max:255',

            // barang (ADMIN TIDAK BOLEH BIKIN BARANG BARU)
            'barang_id.*'   => 'required|exists:barang,id',
            'jumlah.*'      => 'required|numeric|min:1',
            'satuan.*'      => 'required|string|max:50',

            'harga.*'       => 'nullable|string',
            'total_harga.*' => 'nullable|string',

            'grand_total'   => 'nullable|string',
        ]);

        $laporan = Laporan::findOrFail($id);

        /* ================= UPDATE LAPORAN ================= */
        $laporan->update([
            'status_validasi' => $request->status_validasi,
            'catatan_admin'   => $request->catatan_admin,
            'nomor_surat'     => $request->nomor_surat,
            'grand_total'     => $request->filled('grand_total')
                ? str_replace('.', '', $request->grand_total)
                : 0,
        ]);

// ================= UPDATE ITEMS =================
$laporan->items()->delete();

// SAFETY CHECK
if ($request->filled('barang_id')) {

    foreach ($request->barang_id as $i => $barangId) {

        if (!$barangId) continue;

        $laporan->items()->create([
            'barang_id'   => $barangId,
            'nama_barang' => $request->nama_barang[$i] ?? '-',
            'satuan'      => $request->satuan[$i] ?? '-',
            'jumlah'      => $request->jumlah[$i] ?? 0,

            'harga' => isset($request->harga[$i])
                ? str_replace('.', '', $request->harga[$i])
                : 0,

            'total_harga' => isset($request->total_harga[$i])
                ? str_replace('.', '', $request->total_harga[$i])
                : 0,
        ]);
    }
}

        return back()->with('success', 'Perubahan berhasil disimpan.');
    }

    /* ============================================================
     | ADMIN: EXPORT PDF
     ============================================================ */
    public function exportPdf($id)
    {
        $laporan = Laporan::with(['items', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'laporan' => $laporan,
            'items'   => $laporan->items,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('bast.pdf');
    }
}
