{{-- resources/views/dashboard/laporan-edit.blade.php --}}
<x-layouts.dashboard-shell :title="'Edit Laporan | E-Logistik BPBD DIY'" active="history">

  {{-- Background lembut --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #EBDCCF 100%);"></div>

  <div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">
    <div class="mx-auto max-w-5xl mt-2">
      <h1 class="text-[24px] font-semibold text-[#1F2937]">
        Edit Laporan Permohonan Logistik
      </h1>
      <div class="mt-2 h-[2px] w-full rounded-full"
           style="background: linear-gradient(90deg,#E8D6C6 0%,#E8D6C6 60%, transparent 100%);"></div>
    </div>

    {{-- CARD --}}
    <div class="mx-auto max-w-5xl mt-4 rounded-xl border border-[#eadfce] bg-white/90 p-5 
                shadow-[0_8px_30px_rgba(0,0,0,0.07)]"
         style="background:linear-gradient(180deg,#FFFDF8 0%,#FBF3EA 100%);">

      {{-- Error --}}
      @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-700">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST"
      action="{{ route('laporan.update', $laporan->id) }}"
      enctype="multipart/form-data"
      x-data='{
        rows: {{ json_encode($laporan->items->map(fn($i)=>[
          "nama_barang"=>$i->nama_barang,
          "satuan"=>$i->satuan,
          "jumlah"=>$i->jumlah,
          "keterangan"=>$i->keterangan
        ])) }},
        addRow() {
          this.rows.push({
            baru: true,
            satuan: "",
            jumlah: 1,
            keterangan: ""
          })
              this.$nextTick(() => renumberRows())
        },


      }'
>



        @csrf
        @method('PUT')

        {{-- FORM GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-[#374151]">

          {{-- Nama --}}
          <label class="block">
            <span class="text-xs font-medium">Nama</span>
            <input type="text" name="nama"
                   value="{{ old('nama', $laporan->nama) }}"
                   oninput="this.value=this.value.toUpperCase()" required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- NIK --}}
          <label class="block">
            <span class="text-xs font-medium">NIK</span>
            <input type="text" name="nik"
                   value="{{ old('nik', $laporan->nik) }}" maxlength="16"
                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,16)"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Jabatan --}}
          <label class="block">
            <span class="text-xs font-medium">Jabatan</span>
            <input type="text" name="jabatan"
                   value="{{ old('jabatan', $laporan->jabatan) }}"
                   oninput="this.value=this.value.toUpperCase()"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Instansi --}}
          <label class="block">
            <span class="text-xs font-medium">Instansi</span>
            <input type="text" name="instansi"
                   value="{{ old('instansi', $laporan->instansi) }}"
                   oninput="this.value=this.value.toUpperCase()" required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- No HP --}}
          <label class="block">
            <span class="text-xs font-medium">No. HP</span>
            <input type="text" name="no_hp"
                   value="{{ old('no_hp', $laporan->no_hp) }}" required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Tujuan --}}
          <label class="block">
            <span class="text-xs font-medium">Tujuan Permohonan</span>
            <input type="text" name="tujuan"
                   value="{{ old('tujuan', $laporan->tujuan) }}" required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Nama Posko --}}
          <label class="block">
            <span class="text-xs font-medium">Nama Posko</span>
            <input type="text" name="nama_posko"
                   value="{{ old('nama_posko', $laporan->nama_posko) }}"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Jenis Bencana --}}
          <label class="block">
            <span class="text-xs font-medium">Jenis Bencana</span>
            <select name="jenis_bencana" required
                    class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                           px-3 py-2 focus:ring-2 focus:ring-[#F39C3D]">
              @php
                $jenisList = [
                  'Banjir','Tanah Longsor','Gempa Bumi','Letusan Gunung Api','Tsunami',
                  'Kebakaran','Puting Beliung','Kekeringan','Banjir Bandang','Gelombang Pasang',
                  'Konflik Sosial','Kecelakaan Transportasi','Tanaman/Pangan Gagal','Lainnya'
                ];
              @endphp
              @foreach($jenisList as $j)
                <option value="{{ $j }}" {{ old('jenis_bencana', $laporan->jenis_bencana) === $j ? 'selected' : '' }}>
                  {{ $j }}
                </option>
              @endforeach
            </select>
          </label>

          {{-- Tingkat Posko --}}
          <label class="block">
            <span class="text-xs font-medium">Tingkat Posko</span>
            <input type="text" name="tingkat_posko"
                   value="{{ old('tingkat_posko', $laporan->tingkat_posko) }}"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80
                          px-3 py-2 placeholder:uppercase placeholder:text-gray-400
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- RT / RW --}}
          <div class="grid grid-cols-2 gap-3">
            <label class="block">
              <span class="text-xs font-medium">RT</span>
              <input type="text" name="rt"
                     value="{{ old('rt', $laporan->rt) }}" required
                     class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                            focus:ring-2 focus:ring-[#F39C3D]">
            </label>

            <label class="block">
              <span class="text-xs font-medium">RW</span>
              <input type="text" name="rw"
                     value="{{ old('rw', $laporan->rw) }}" required
                     class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                            focus:ring-2 focus:ring-[#F39C3D]">
            </label>
          </div>

          {{-- Kabupaten --}}
          <label class="block">
            <span class="text-xs font-medium">Kabupaten/Kota</span>
            <input type="text" name="kabupaten"
                   value="{{ old('kabupaten', $laporan->kabupaten) }}"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Kecamatan --}}
          <label class="block">
            <span class="text-xs font-medium">Kecamatan</span>
            <input type="text" name="kecamatan"
                   value="{{ old('kecamatan', $laporan->kecamatan) }}"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Kelurahan --}}
          <label class="block">
            <span class="text-xs font-medium">Kalurahan / Kelurahan</span>
            <input type="text" name="kelurahan"
                   value="{{ old('kelurahan', $laporan->kelurahan) }}"required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

          {{-- Desa --}}
          <label class="block">
            <span class="text-xs font-medium">Desa / Dusun</span>
            <input type="text" name="desa"
                   value="{{ old('desa', $laporan->desa) }}" required
                   class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/80 px-3 py-2 
                          focus:ring-2 focus:ring-[#F39C3D]">
          </label>

   {{-- Upload Foto --}}
<label class="block">
  <span class="text-xs font-medium text-[#374151]">
      Upload Foto Kejadian
  </span>

  <input
      type="file"
      name="foto"
      accept=".jpg,.jpeg,.png,.webp,image/*"
      class="
          mt-1 w-full rounded-md border border-[#e5d8c7]
          bg-white px-3 py-2 text-sm
          file:mr-4 file:rounded-md file:border-0
          file:bg-blue-600 file:px-4 file:py-2
          file:text-sm file:font-medium file:text-white
          hover:file:bg-blue-700
          focus:ring-2 focus:ring-[#F39C3D]
      "
  >

  @if ($laporan->foto_path)
    <img src="{{ asset('storage/' . $laporan->foto_path) }}"
         class="mt-2 w-32 rounded-lg shadow">
  @endif
</label>

{{-- Upload Surat --}}
<label class="block">
  <span class="text-xs font-medium text-[#374151]">
      Upload Surat (PDF / DOC / DOCX)
  </span>

  <input
      type="file"
      name="surat"
      accept=".pdf,.doc,.docx"
      class="
          mt-1 w-full rounded-md border border-[#e5d8c7]
          bg-white px-3 py-2 text-sm
          file:mr-4 file:rounded-md file:border-0
          file:bg-blue-600 file:px-4 file:py-2
          file:text-sm file:font-medium file:text-white
          hover:file:bg-blue-700
          focus:ring-2 focus:ring-[#F39C3D]
      "
  >

  @if ($laporan->surat_path ?? false)
    <a href="{{ asset('storage/' . $laporan->surat_path) }}"
       class="text-blue-700 underline block mt-2 text-xs">
        Lihat Surat Upload Sebelumnya
    </a>
  @endif
</label>


        </div>

       {{-- ===================== TABLE BARANG DINAMIS ===================== --}}
<h3 class="mt-6 mb-2 text-sm font-semibold text-[#374151]">
    Daftar Kebutuhan Logistik
</h3>

<div
    x-data="{ rows: [] }"
    class="rounded-xl border border-[#EADFCF] bg-[#FFF9F2] p-5"
>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-[#F2E7DA] text-[#374151]">
                    <th class="border border-[#EADFCF] w-12 px-3 py-2 text-center">No.</th>
                    <th class="border border-[#EADFCF] px-3 py-2">Nama Barang</th>
                    <th class="border border-[#EADFCF] w-28 px-3 py-2">Satuan</th>
                    <th class="border border-[#EADFCF] w-28 px-3 py-2">Jumlah</th>
                    <th class="border border-[#EADFCF] px-3 py-2">Keterangan</th>
                    <th class="border border-[#EADFCF] w-12"></th>
                </tr>
            </thead>

            <tbody>
                {{-- BARIS LAMA --}}
                @foreach ($laporan->items as $i => $item)
                <tr class="bg-white">
                    <td class="border border-[#EADFCF] text-center">{{ $i + 1 }}</td>

                    <td class="border border-[#EADFCF] px-3 py-2">
                        {{ $item->barang->nama_barang ?? $item->nama_barang }}
                        <input type="hidden" name="barang_id[]" value="{{ $item->barang_id }}">
                    </td>

                    <td class="border border-[#EADFCF] px-3 py-2">
                        <input type="text" name="satuan[]" value="{{ $item->satuan }}" readonly
                               class="w-full rounded-md bg-gray-100 border border-gray-200
                                      px-2 py-1 text-center text-sm">
                    </td>

                    <td class="border border-[#EADFCF] px-3 py-2">
                        <input type="number" name="jumlah[]" value="{{ $item->jumlah }}"
                               class="w-full rounded-md bg-gray-100 border border-gray-200
                                      px-2 py-1 text-center text-sm focus:ring-0">
                    </td>

                    <td class="border border-[#EADFCF] px-3 py-2">
                        <input type="text" name="keterangan[]" value="{{ $item->keterangan }}"
                               class="w-full rounded-md bg-gray-100 border border-gray-200
                                      px-2 py-1 text-sm focus:ring-0">
                    </td>

                    <td class="border border-[#EADFCF] text-center">
                        <button type="button"
                                class="text-red-500 text-lg font-bold hover:text-red-700"
                                @click="$el.closest('tr').remove()">
                            ✕
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- TOMBOL TAMBAH BARIS --}}
    <div class="mt-4 flex justify-center">
        <button type="button" @click="addRow()"
                class="rounded-full px-6 py-2 text-sm font-semibold text-white shadow hover:shadow-md"
                style="background:linear-gradient(90deg,#F8C16A,#F39C3D);">
            + Tambah Baris
        </button>
    </div>
</div>

{{-- TOMBOL BAWAH --}}
<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('dashboard.history') }}"
       class="rounded-full bg-gray-200 px-5 py-2 text-sm font-semibold text-gray-700
              border border-gray-300 hover:bg-gray-300 transition">
        Batal
    </a>

    <button type="submit"
            class="rounded-full px-6 py-2 text-sm font-semibold text-white shadow hover:shadow-md"
            style="background:linear-gradient(90deg,#F8C16A,#F39C3D);">
        Simpan Perubahan
    </button>
</div>



      </form>
    </div>
  </div>

  <script>
function isiSatuan(selectEl) {
  const satuan = selectEl.options[selectEl.selectedIndex]
                 .getAttribute('data-satuan');

  const row = selectEl.closest('tr');
  row.querySelector('input[name="satuan[]"]').value = satuan || '';
}

function renumberRows() {
  document.querySelectorAll('#tabel-barang tbody tr').forEach((tr, index) => {
    const noCell = tr.querySelector('.col-no');
    if (noCell) {
      noCell.textContent = index + 1;
    }
  });
}
</script>


</x-layouts.dashboard-shell>
