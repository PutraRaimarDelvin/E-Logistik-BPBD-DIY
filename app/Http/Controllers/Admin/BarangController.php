<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('nama_barang')->get();
        return view('admin.barang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang',
            'nama_barang' => 'required',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required',
        ]);

        Barang::create($request->all());

        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

  public function update(Request $request, $id)
{
    $barang = Barang::findOrFail($id);

    $barang->update([
        'kode_barang' => $request->kode_barang,
        'nama_barang' => $request->nama_barang,
        'stok'        => $request->stok,
        'satuan'      => $request->satuan,
    ]);

    return back()->with('success', 'Barang berhasil diperbarui!');
}

public function form()
{
    $barang = Barang::where('stok', '>', 0)->get();

    return view('dashboard.form', compact('barang'));
}



  public function destroy($id)
{
    Barang::findOrFail($id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data barang berhasil dihapus'
    ]);
}

}

