<x-layouts.admin-shell :title="'Detail Laporan | E-Logistik Admin'" active="laporan">

    {{-- Background --}}
    <div class="absolute inset-0 -z-10"
        style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD, #F1E3D6 45%, #EBDCCF 100%)">
    </div>

    <div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">

        {{-- Judul --}}
        <div class="mx-auto max-w-6xl mt-3">
            <h1 class="text-[26px] font-semibold text-[#1F2937]">Detail Laporan Bencana</h1>
            <div class="mt-2 h-[2px] rounded-full"
                style="background: linear-gradient(90deg,#E8D6C6 0%,#E8D6C6 60%,transparent 100%)"></div>
        </div>

        {{-- FORM UPDATE --}}
        <form method="POST" action="{{ route('admin.laporan.updateStatus', $laporan->id) }}">
            @csrf

            {{-- CARD --}}
            <div class="mx-auto max-w-6xl mt-4 rounded-xl border border-[#eadfce]
                        shadow-[0_8px_30px_rgba(0,0,0,0.07)]
                        bg-gradient-to-b from-[#FFFDF8] to-[#FBF3EA] p-6">

                {{-- IDENTITAS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-[#374151]">

                    <div class="space-y-3">
                        <div><b>Nama</b><br>{{ $laporan->nama }}</div>
                        <div><b>NIK</b><br>{{ $laporan->nik }}</div>
                        <div><b>Instansi</b><br>{{ $laporan->instansi ?: '-' }}</div>
                        <div><b>Jabatan</b><br>{{ $laporan->jabatan ?: '-' }}</div>
                        <div><b>No. HP</b><br>{{ $laporan->no_hp }}</div>
                    </div>

                    <div class="space-y-3">
                        <div><b>Nama Posko</b><br>{{ $laporan->nama_posko ?? '-' }}</div>
                        <div><b>Jenis Bencana</b><br>{{ $laporan->jenis_bencana }}</div>
                        <div><b>Tingkat Posko</b><br>{{ $laporan->tingkat_posko ?? '-' }}</div>
                        <div>
                            <b>Alamat Posko</b><br>
                            {{ $laporan->desa }},
                            RT {{ $laporan->rt }}/RW {{ $laporan->rw }},
                            {{ $laporan->kecamatan }},
                            {{ $laporan->kabupaten }},
                            {{ $laporan->kelurahan }}
                        </div>
                        <div><b>Tujuan Permohonan</b><br>{{ $laporan->tujuan }}</div>
                    </div>
                </div>

                 {{-- FOTO & SURAT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">

                    {{-- FOTO --}}
         {{-- FOTO --}}
<div>
    <div class="font-semibold text-[#111827] mb-2">Foto Kejadian</div>

    @if($laporan->foto_path)
      <div class="rounded-lg overflow-hidden shadow cursor-pointer 
                  w-full max-w-[400px]"> {{-- mengikuti ukuran lebih fleksibel --}}
          
          <img src="{{ asset('storage/' . $laporan->foto_path) }}"
               class="w-full h-auto max-h-[280px] object-contain bg-gray-100 cursor-pointer"
               onclick="openImageModal('{{ asset('storage/' . $laporan->foto_path) }}')">
      </div>
    @else
      <p class="text-gray-500 italic">Tidak ada foto diunggah.</p>
    @endif
</div>


                    {{-- SURAT --}}
                    <div class="space-y-5">
                        <div>
                            <div class="font-semibold mb-2">Surat / Dokumen</div>

                            @if($laporan->surat_path)
                                <div class="p-3 border rounded-lg bg-[#f8f8f8] shadow w-fit">
                                    <div class="text-sm mb-2">
                                        Nama File:
                                        <span class="text-blue-700 italic">{{ $laporan->surat_nama_asli }}</span>
                                    </div>

                                    <a href="{{ asset('storage/' . $laporan->surat_path) }}" target="_blank"
                                        class="inline-flex items-center gap-2 bg-[#0055A5] text-white px-4 py-2 rounded-lg shadow hover:bg-[#003f7d] transition">
                                        <i class="fa-solid fa-file-pdf"></i> Download Surat
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 italic">Tidak ada surat diunggah.</p>
                            @endif
                        </div>

                        {{-- NOMOR SURAT --}}
                        <div>
                            <div class="font-semibold mb-2">Nomor Surat Berita Acara</div>
                            <input type="text" name="nomor_surat"
                                   value="{{ old('nomor_surat', $laporan->nomor_surat) }}"
                                   class="border rounded-lg p-2 w-full max-w-[260px]">
                        </div>
                    </div>
                </div>

                {{-- =========================== --}}
                {{-- TABEL BARANG (EDITABLE) --}}
                {{-- =========================== --}}
                <div class="mt-10">
                    <div class="text-sm font-semibold mb-2">Daftar Kebutuhan</div>

                    <div class="overflow-hidden rounded-lg border bg-white">
                        <table class="w-full text-sm" id="barangTable">
                            <thead>
                                <tr class="bg-[#F2E7DA] text-[#374151] font-semibold text-center">
                                    <th class="px-4 py-3 border w-10">No</th>
                                    <th class="px-4 py-3 border w-32">Kode Barang</th>
                                    <th class="px-4 py-3 border">Nama Barang</th>
                                    <th class="px-4 py-3 border w-24">Satuan</th>
                                    <th class="px-4 py-3 border w-20">Jumlah</th>
                                    <th class="px-4 py-3 border w-32">Harga (Rp)</th>
                                    <th class="px-4 py-3 border w-32">Total Harga</th>
                                    <th class="px-4 py-3 border w-10">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
@forelse ($laporan->items as $i => $item)
<tr>
    {{-- 1. NO --}}
    <td class="px-3 py-3 border text-center">{{ $i + 1 }}</td>

    {{-- 2. KODE BARANG --}}
    <td class="px-3 py-3 border text-center">
        <input type="text"
            value="{{ $item->barang->kode_barang ?? '-' }}"
            class="w-full border rounded px-2 py-1 bg-gray-100 text-center"
            readonly>
    </td>

    {{-- hidden id (TIDAK HITUNG KOLOM) --}}
    <input type="hidden" name="barang_id[{{ $i }}]" value="{{ $item->barang_id }}">

    {{-- 3. NAMA BARANG --}}
    <td class="px-3 py-3 border">
        <input type="text"
            name="nama_barang[{{ $i }}]"
            value="{{ $item->nama_barang }}"
            class="w-full border rounded px-2 py-1 bg-gray-100"
            readonly>
    </td>

    {{-- 4. SATUAN --}}
    <td class="px-3 py-3 border text-center">
        <input type="text"
            name="satuan[{{ $i }}]"
            value="{{ $item->satuan }}"
            class="w-full border rounded px-2 py-1 text-center bg-gray-100 cursor-not-allowed"
       readonly>
    </td>

    {{-- 5. JUMLAH --}}
    <td class="px-3 py-3 border text-center">
        <input type="number" min="1"
            name="jumlah[{{ $i }}]"
            value="{{ $item->jumlah }}"
            class="w-full border rounded px-2 py-1 text-center jumlah-input"
            oninput="hitungTotal({{ $i }})">
    </td>

    {{-- 6. HARGA --}}
    <td class="px-3 py-3 border text-right">
        <input type="text"
            name="harga[{{ $i }}]"
            value="{{ number_format($item->harga, 0, ',', '.') }}"
            class="w-full border rounded px-2 py-1 text-right harga-input"
            oninput="
                this.value = formatRupiah(this.value);
                hitungTotal({{ $i }});
            ">
    </td>

    {{-- 7. TOTAL --}}
    <td class="px-3 py-3 border text-right font-semibold">
        <input type="text"
            name="total_harga[{{ $i }}]"
            value="{{ number_format($item->total_harga, 0, ',', '.') }}"
            class="w-full border rounded px-2 py-1 text-right bg-gray-100 total-harga-input"
            readonly style="pointer-events:none;">
    </td>

    {{-- 8. AKSI --}}
    <td class="px-3 py-3 border text-center">
        <button type="button"
            onclick="hapusBaris(this)"
            class="text-red-600 font-bold text-lg">×</button>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center py-4 text-gray-500">
        Tidak ada data barang.
    </td>
</tr>
@endforelse
</tbody>

                        </table>
                    </div>
<div class="mt-3 flex justify-end items-center gap-3 text-sm font-semibold">
    <span>Total Keseluruhan:</span>

   <input
        type="text"
        id="grandTotal"
        value="0"
        readonly
        class="border rounded-lg px-4 py-1 bg-gray-100 text-right w-32"
        style="pointer-events: none;"

    >
</div>

<!-- Tambahkan hidden input agar ikut dikirim ke backend -->
<input type="hidden" name="grand_total" id="grandTotalHidden">


                {{-- FORM STATUS --}}
                <div class="mt-10 grid grid-cols-1 md:grid-cols-[200px_1fr] gap-6">

                    <div>
                        <label class="font-semibold">Status Validasi</label>
                        <select name="status_validasi" class="mt-1 border rounded-lg p-2 w-full">
                            <option value="Menunggu"  {{ $laporan->status_validasi=='Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ $laporan->status_validasi=='Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak"   {{ $laporan->status_validasi=='Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold">Catatan Admin</label>
                        <textarea name="catatan_admin" rows="2"
                                  class="mt-1 border rounded-lg p-2 w-full">{{ $laporan->catatan_admin }}</textarea>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.laporan.index') }}"
                        class="rounded-full bg-gray-200 text-gray-700 px-4 py-2 text-sm hover:bg-gray-300">
                        ← Kembali
                    </a>

                    <a href="{{ route('admin.laporan.pdf', $laporan->id) }}" target="_blank"
                        class="rounded-full bg-green-600 text-white px-5 py-2 text-sm hover:bg-green-700">
                        Cetak PDF
                    </a>

                    <button type="submit"
                            class="rounded-full bg-[#bf6b29] text-white px-5 py-2 text-sm hover:bg-[#9a5a30]">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>

    </div>

   
{{-- ========================= --}}
{{-- MODAL ZOOM FOTO (PERSIS SEPERTI USER) --}}
{{-- ========================= --}}
<div id="imageZoomModal"
     class="fixed left-0 right-0 bottom-0 z-[99999] hidden flex items-center justify-center p-4"
     style="top: 80px; background: rgba(0,0,0,0.7);">

    <div class="relative bg-white rounded-xl shadow-xl p-4
                max-w-[90vw] max-h-[85vh] flex items-center justify-center">

        {{-- CLOSE --}}
        <button onclick="closeImageModal()"
            class="absolute -top-3 -right-3 bg-white text-black w-8 h-8 rounded-full shadow
            hover:bg-red-500 hover:text-white transition">
            ✕
        </button>

        {{-- GAMBAR --}}
        <img id="zoomedImage"
             class="max-w-full max-h-[80vh] w-auto h-auto object-contain rounded-lg">
    </div>

</div>



   <script>

   function openImageModal(src) {
    const modal = document.getElementById('imageZoomModal');
    const img = document.getElementById('zoomedImage');
    img.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeImageModal() {
    const modal = document.getElementById('imageZoomModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

        

// ----------------------------
// Format angka → "100000" => "100.000"
// ----------------------------
function formatRupiah(angka) {
    if (angka === null || angka === undefined) return "";

    // Ambil angka saja
    angka = angka.toString().replace(/\D/g, "");

    // Hilangkan nol depan
    angka = angka.replace(/^0+/, "");

    if (angka === "") return "0";

    return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// ----------------------------
// Convert string rupiah → integer
// ----------------------------
function parseRupiah(str) {
    if (!str) return 0;
    return parseInt(str.replace(/\./g, "")) || 0;
}

// ----------------------------
// Hitung total per item
// ----------------------------
function hitungTotal(i) {
    let jumlah = parseRupiah(document.getElementsByName(`jumlah[${i}]`)[0].value);
    let harga  = parseRupiah(document.getElementsByName(`harga[${i}]`)[0].value);

    let total = jumlah * harga;

    // Update input total
    document.getElementsByName(`total_harga[${i}]`)[0].value = formatRupiah(total);

    hitungGrandTotal();
}

// ----------------------------
// Hitung total keseluruhan
// ----------------------------
function hitungGrandTotal() {
    let total = 0;

    document.querySelectorAll('.total-harga-input').forEach(function(el){
        total += parseRupiah(el.value);
    });

    document.getElementById('grandTotal').value = formatRupiah(total);
}

// ----------------------------
// Hapus baris item
// ----------------------------
function hapusBaris(btn) {
    btn.closest('tr').remove();
    hitungGrandTotal();
}

// ----------------------------
// FORMAT ULANG SEMUA SAAT HALAMAN DIBUKA
// ----------------------------
document.addEventListener("DOMContentLoaded", function() {

    // Format ulang harga dan total per item
    document.querySelectorAll('.harga-input').forEach(function(el){
        el.value = formatRupiah(el.value);
    });

    document.querySelectorAll('.total-harga-input').forEach(function(el){
        el.value = formatRupiah(el.value);
    });

    // Hitung ulang total keseluruhan agar tidak "0" setelah reload
    hitungGrandTotal();
});


</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data berhasil diperbarui.',
        showConfirmButton: false,
        timer: 1800
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</x-layouts.admin-shell>
