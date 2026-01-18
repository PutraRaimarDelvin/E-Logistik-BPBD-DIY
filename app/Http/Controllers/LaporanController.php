<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /* ============================================================
     | USER: LIST HISTORY
     ============================================================ */
    public function index()
{
    $laporans = Laporan::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(6); // ✅ INI YANG PENTING

    return view('dashboard.history', compact('laporans'));
}


    /* ============================================================
     | STORE LAPORAN BARU (USER)
     ============================================================ */
    public function store(Request $request)
    {
        // ================= VALIDASI UTAMA =================
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:16',
            'instansi'      => 'nullable|string|max:255',
            'jabatan'       => 'nullable|string|max:255',
            'no_hp'         => 'required|string|max:50',
            'tujuan'        => 'required|string|max:255',
            'jenis_bencana' => 'required|string|max:100',
            'nama_posko'    => 'nullable|string|max:255',
            'tingkat_posko' => 'nullable|string|max:255',

            'rt'            => 'required|string|max:10',
            'rw'            => 'required|string|max:10',
            'desa'          => 'required|string|max:255',
            'kabupaten'     => 'required|string|max:100',
            'kecamatan'     => 'required|string|max:100',
            'kelurahan'     => 'required|string|max:100',

            'foto'          => 'required|image|max:2048',
            'surat'         => 'required|mimes:pdf,doc,docx|max:4096',
        ]);

        // ================= VALIDASI BARANG =================
        $request->validate([
            'barang_id.*' => 'required|exists:barang,id',
            'satuan.*'    => 'required|string|max:100',
            'jumlah.*'    => 'required|numeric|min:1',
        ]);

        try {
            /* ================= FILE ================= */
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');

            $suratNamaAsli = $request->file('surat')->getClientOriginalName();
            $suratPath = $request->file('surat')->store('laporan_surat', 'public');

            /* ================= SIMPAN LAPORAN ================= */
            $laporan = Laporan::create([
                'user_id'       => Auth::id(),
                'nama'          => strtoupper($validated['nama']),
                'nik'           => $validated['nik'],
                'instansi'      => strtoupper($validated['instansi'] ?? '-'),
                'jabatan'       => strtoupper($validated['jabatan'] ?? '-'),
                'no_hp'         => $validated['no_hp'],
                'tujuan'        => $validated['tujuan'],
                'jenis_bencana' => $validated['jenis_bencana'],
                'nama_posko'    => $validated['nama_posko'] ?? '-',
                'tingkat_posko' => $validated['tingkat_posko'] ?? '-',

                'rt'            => $validated['rt'],
                'rw'            => $validated['rw'],
                'desa'          => $validated['desa'],
                'kabupaten'     => $validated['kabupaten'],
                'kecamatan'     => $validated['kecamatan'],
                'kelurahan'     => $validated['kelurahan'],

                'foto_path'       => $fotoPath,
                'surat_path'      => $suratPath,
                'surat_nama_asli' => $suratNamaAsli,
            ]);

            /* ================= SIMPAN ITEM ================= */
            if ($request->filled('barang_id')) {
                foreach ($request->barang_id as $i => $barangId) {

                    if (empty($barangId)) continue;

                    $barang = Barang::findOrFail($barangId);

                    $laporan->items()->create([
                        'barang_id'   => $barangId,
                        'nama_barang' => $barang->nama_barang, // 🔥 WAJIB
                        'satuan'      => $request->satuan[$i],
                        'jumlah'      => $request->jumlah[$i],
                        'keterangan'  => $request->keterangan[$i] ?? null,
                    ]);
                }
            }

            return redirect()
                ->route('dashboard.history')
                ->with('success', 'Laporan berhasil dikirim.');

        } catch (\Throwable $e) {
            dd(
                'ERROR MESSAGE: ' . $e->getMessage(),
                'FILE: ' . $e->getFile(),
                'LINE: ' . $e->getLine()
            );
        }
    }

    /* ============================================================
     | DETAIL USER
     ============================================================ */
    public function show(Laporan $laporan)
    {
        $this->authorizeLaporan($laporan);
        $laporan->load('items');
        return view('dashboard.laporan-show', compact('laporan'));
    }

    /* ============================================================
     | AUTH
     ============================================================ */
    protected function authorizeLaporan(Laporan $laporan)
    {
        if ($laporan->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /* ============================================================
     | EXPORT PDF
     ============================================================ */
    public function pdf($id)
    {
        $laporan = Laporan::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'laporan' => $laporan,
            'items'   => $laporan->items,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('bast.pdf');
    }
    public function edit($id)
{
    $laporan = Laporan::with(['items.barang'])->findOrFail($id);
    $barangs = Barang::orderBy('nama_barang')->get();

    return view('dashboard.laporan-edit', compact('laporan', 'barangs'));
}
public function update(Request $request, $id)
{
    $laporan = Laporan::findOrFail($id);

    // ✅ UPDATE FORM UTAMA (INI YANG KURANG)
    $laporan->update([
        'nama'          => strtoupper($request->nama),
        'nik'           => $request->nik,
        'instansi'      => strtoupper($request->instansi ?? '-'),
        'jabatan'       => strtoupper($request->jabatan ?? '-'),
        'no_hp'         => $request->no_hp,
        'tujuan'        => $request->tujuan,
        'jenis_bencana' => $request->jenis_bencana,
        'nama_posko'    => $request->nama_posko ?? '-',
        'tingkat_posko' => $request->tingkat_posko ?? '-',
        'rt'            => $request->rt,
        'rw'            => $request->rw,
        'desa'          => $request->desa,
        'kabupaten'     => $request->kabupaten,
        'kecamatan'     => $request->kecamatan,
        'kelurahan'     => $request->kelurahan,
    ]);

    // FILE
    if ($request->hasFile('foto')) {
        $laporan->foto_path = $request->file('foto')->store('foto_laporan', 'public');
    }

    if ($request->hasFile('surat')) {
        $laporan->surat_path = $request->file('surat')->store('laporan_surat', 'public');
    }

    $laporan->save();

    // ITEMS
    $laporan->items()->delete();

    if ($request->filled('barang_id')) {
        foreach ($request->barang_id as $i => $barangId) {
            if (!$barangId) continue;

            $barang = Barang::findOrFail($barangId);

            $laporan->items()->create([
                'barang_id'   => $barangId,
                'nama_barang' => $barang->nama_barang,
                'satuan'      => $request->satuan[$i],
                'jumlah'      => $request->jumlah[$i],
                'keterangan'  => $request->keterangan[$i] ?? null,
            ]);
        }
    }

    return redirect('/dashboard/history')
        ->with('success', 'Laporan berhasil diperbarui.');
}

public function destroy($id)
{
    $laporan = Laporan::findOrFail($id);

    // hapus item barang dulu (jika relasi cascade belum ada)
    $laporan->items()->delete();

    // hapus laporan
    $laporan->delete();

 return redirect('/dashboard/history')
    ->with('success', 'Laporan berhasil dihapus.');
}
}
