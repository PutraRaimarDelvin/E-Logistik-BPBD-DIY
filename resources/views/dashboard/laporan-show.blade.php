{{-- resources/views/dashboard/laporan-show.blade.php --}}
<x-layouts.dashboard-shell :title="'Detail Laporan | E-Logistik'" active="history">

   {{-- Background lembut --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #EBDCCF 100%);"></div>

  <div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">
    <div class="mx-auto max-w-5xl mt-2">
      <h1 class="text-[24px] font-semibold text-[#1F2937]">Detail Laporan Bencana</h1>

      <div class="mt-2 h-[2px] w-full rounded-full"
           style="background: linear-gradient(90deg,#E8D6C6 0%,#E8D6C6 60%, transparent 100%);"></div>
    </div>

    {{-- CARD --}}
    <div class="mx-auto max-w-5xl mt-4 rounded-xl border border-[#eadfce] bg-white/90 p-5 
                shadow-[0_8px_30px_rgba(0,0,0,0.07)]"
         style="background:linear-gradient(180deg,#FFFDF8 0%,#FBF3EA 100%);">

      {{-- STATUS & CATATAN ADMIN --}}
      <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <div class="font-semibold text-[#111827] mb-1">Status Validasi</div>

            @if($laporan->status_validasi === 'Disetujui')
              <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">✔ Disetujui</span>
            @elseif($laporan->status_validasi === 'Ditolak')
              <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">✘ Ditolak</span>
            @else
              <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">⏳ Menunggu Validasi</span>
            @endif
        </div>

        @if($laporan->catatan_admin)
        <div class="flex flex-col">
            <div class="font-semibold text-[#111827] mb-1">Catatan Admin</div>

            <div class="rounded-lg border border-[#f3c694] 
                        bg-[#FFF6E9] shadow px-4 py-3 text-sm text-black">
                {{ $laporan->catatan_admin }}
            </div>
        </div>
        @endif

      </div>

      {{-- IDENTITAS --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-[#374151]">

        <div class="space-y-3">
          <div><b>Nama</b><br>{{ $laporan->nama }}</div>
          <div><b>NIK</b><br>{{ $laporan->nik }}</div>
          <div><b>Jabatan</b><br>{{ $laporan->jabatan ?: '-' }}</div>
          <div><b>Instansi</b><br>{{ $laporan->instansi ?: '-' }}</div>
          <div><b>No. HP</b><br>{{ $laporan->no_hp }}</div>
        </div>

        <div class="space-y-3">
          <div><b>Tujuan Permohonan</b><br>{{ $laporan->tujuan }}</div>
          <div><b>Jenis Bencana</b><br>{{ $laporan->jenis_bencana }}</div>
          <div><b>Nama Posko</b><br>{{ $laporan->nama_posko }}</div>
          <div><b>Tingkat Posko</b><br>{{ $laporan->tingkat_posko }}</div>
          <div>
            <b>Alamat Posko</b><br>
            {{ $laporan->desa }},
            RT {{ $laporan->rt }}/RW {{ $laporan->rw }},
            {{ $laporan->kecamatan }},
            {{ $laporan->kabupaten }},
            {{ $laporan->kelurahan }}
          </div>
        </div>

      </div>

      {{-- FOTO & SURAT --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">

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
        <div>
          <div class="font-semibold mb-2">Surat / Dokumen</div>

          @if($laporan->surat_path)
            <div class="p-3 border rounded-lg bg-[#f8f8f8] shadow w-fit">
              <div class="text-sm mb-2">
                Nama File:
                <span class="text-blue-700">{{ $laporan->surat_nama_asli }}</span>
              </div>

              <a href="{{ asset('storage/' . $laporan->surat_path) }}"
                 target="_blank"
                 class="inline-flex items-center gap-2 bg-[#0055A5] text-white
                        px-4 py-2 rounded-lg shadow hover:bg-[#003f7d] transition">
                <i class="fa-solid fa-file-pdf"></i> Download Surat
              </a>
            </div>
          @else
            <p class="text-gray-500 italic">Tidak ada surat diunggah.</p>
          @endif
        </div>

      </div>

      {{-- TABEL BARANG --}}
      <div class="mt-10">
          <div class="text-sm font-semibold mb-2">Daftar Kebutuhan</div>

          <div class="overflow-hidden rounded-lg border bg-white">
              <table class="w-full text-sm">
                  <thead>
                      <tr class="bg-[#F2E7DA] text-[#374151] font-semibold">
                          <th class="px-4 py-3 border w-12 text-center">No.</th>
                          <th class="px-4 py-3 border">Nama Barang</th>
                          <th class="px-4 py-3 border w-24">Satuan</th>
                          <th class="px-4 py-3 border w-24">Jumlah</th>
                          <th class="px-4 py-3 border">Keterangan</th>
                      </tr>
                  </thead>

                  <tbody>
                      @foreach($laporan->items as $index => $item)
                      <tr>
                          <td class="px-4 py-3 border text-center">{{ $index + 1 }}</td>
                          <td class="px-4 py-3 border">{{ $item->nama_barang }}</td>
                          <td class="px-4 py-3 border">{{ $item->satuan }}</td>
                          <td class="px-4 py-3 border">{{ $item->jumlah }}</td>
                          <td class="px-4 py-3 border">{{ $item->keterangan }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>

   <div class="mt-8">
    <a href="{{ route('dashboard.history') }}"
       class="inline-flex items-center justify-center rounded-full
              px-6 py-2.5 text-sm font-semibold text-white
              shadow hover:shadow-md transition"
       style="background:linear-gradient(90deg,#F8C16A,#F39C3D);">
        Kembali ke History
    </a>
</div>


    </div>
  </div>

</x-layouts.dashboard-shell>

{{-- ========================= --}}
{{-- MODAL ZOOM FOTO (FIXED) --}}
{{-- ========================= --}}
<div id="imageZoomModal"
     class="fixed inset-0 bg-black/70 z-[99999] hidden flex items-center justify-center p-4">

    <div class="relative bg-white rounded-xl shadow-xl p-4
                max-w-[90vw] max-h-[90vh] flex items-center justify-center">

        {{-- CLOSE --}}
        <button onclick="closeImageModal()"
            class="absolute -top-3 -right-3 bg-white text-black w-8 h-8 rounded-full shadow
            hover:bg-red-500 hover:text-white transition">
            ✕
        </button>

        {{-- GAMBAR --}}
        <img id="zoomedImage"
             class="max-w-full max-h-[85vh] w-auto h-auto object-contain rounded-lg">
    </div>

</div>


{{-- SCRIPT --}}
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
</script>
