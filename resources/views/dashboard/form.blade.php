{{-- resources/views/dashboard/form.blade.php --}}
<x-layouts.dashboard-shell :title="'Permohonan Logistik | E-Logistik'" active="form">

{{-- Background lembut --}}
<div class="absolute inset-0 -z-10"
     style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%);">
</div>

<div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">

<div class="mx-auto max-w-6xl mt-2">
    <h1 class="text-[26px] font-semibold text-[#1F2937]">Permohonan Logistik</h1>
    <div class="mt-2 h-[2px] w-full rounded-full"
         style="background: linear-gradient(90deg,#E8D6C6 0%,#E8D6C6 60%, transparent 100%);">
    </div>
</div>

{{-- Error --}}
@if ($errors->any())
<div class="mt-4 mx-auto max-w-6xl">
    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-700">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- Card --}}
<div class="mx-auto mt-4 max-w-6xl rounded-xl border border-[#eadfce] bg-white/90 p-5 shadow"
     style="background:linear-gradient(180deg,#FFFDF8 0%,#FBF3EA 100%);">

<form method="POST"
      action="{{ route('laporan.store') }}"
      enctype="multipart/form-data"
      x-data="{
        kabupaten: '{{ old('kabupaten') }}',
        kecamatan: '{{ old('kecamatan') }}',
        kecMap: {
            'Kota Yogyakarta': ['Mantrijeron','Kraton','Mergangsan','Umbulharjo','Kotagede','Gondokusuman','Danurejan','Pakualaman','Gondomanan','Ngampilan','Wirobrajan','Gedongtengen','Jetis','Tegalrejo'],
            'Sleman': ['Moyudan','Minggir','Seyegan','Godean','Gamping','Mlati','Depok','Berbah','Prambanan','Kalasan','Ngemplak','Ngaglik','Sleman','Tempel','Turi','Pakem','Cangkringan'],
            'Bantul': ['Srandakan','Sanden','Kretek','Pundong','Bambanglipuro','Pandak','Bantul','Jetis','Imogiri','Dlingo','Pleret','Piyungan','Banguntapan','Sewon','Kasihan','Pajangan','Sedayu'],
            'Kulon Progo': ['Temon','Wates','Panjatan','Galur','Lendah','Sentolo','Pengasih','Kokap','Girimulyo','Nanggulan','Kalibawang','Samigaluh'],
            'Gunungkidul': ['Wonosari','Nglipar','Playen','Patuk','Paliyan','Saptosari','Tanjungsari','Tepus','Rongkop','Semin','Ngawen','Karangmojo','Ponjong','Semanu','Girisubo','Purwosari','Panggang','Gedangsari']
        },
        get kecOptions() {
            return this.kabupaten ? this.kecMap[this.kabupaten] : []
        }
      }"
>
@csrf

{{-- ================= FORM IDENTITAS (PUNYA KAMU) ================= --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    {{-- Nama --}}
     <label class="block">
                        <span class="text-xs font-medium text-[#374151]">
                            Nama<span class="text-red-500">*</span>
                        </span>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            oninput="this.value = this.value.toUpperCase()"
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>

    {{-- NIK --}}
      <label class="block">
                        <span class="text-xs font-medium text-[#374151]">
                            NIK<span class="text-red-500">*</span>
                        </span>
                        <input type="text" name="nik" value="{{ old('nik') }}" required maxlength="16"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,16)"
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>

    {{-- Instansi --}}
    <label class="block">
                        <span class="text-xs font-medium text-[#374151]">Instansi</span>
                        <input type="text" name="instansi" value="{{ old('instansi') }}"
                            oninput="this.value = this.value.toUpperCase()"
                            onblur="if(this.value.trim()==='') this.value='-'"
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>


    {{-- Jabatan --}}
   <label class="block">
                        <span class="text-xs font-medium text-[#374151]">Jabatan</span>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}"
                            oninput="this.value = this.value.toUpperCase()"
                            onblur="if(this.value.trim()==='') this.value='-'"
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>

    {{-- No HP --}}
      <label class="block">
                        <span class="text-xs font-medium text-[#374151]">
                            No. HP<span class="text-red-500">*</span>
                        </span>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>


    {{-- Tujuan --}}
    <label class="block">
                        <span class="text-xs font-medium text-[#374151]">
                            Tujuan Permohonan<span class="text-red-500">*</span>
                        </span>
                        <input type="text" name="tujuan" value="{{ old('tujuan') }}" required
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                    </label>

    {{-- Nama Posko --}}
    <label class="block">
        <span class="text-xs font-medium">Nama Posko</span>
        <input type="text" name="nama_posko" value="{{ old('nama_posko') }}"
               class="mt-1 w-full rounded-md border px-3 py-2">
    </label>

    {{-- Jenis Bencana --}}
    <label class="block">
                        <span class="text-xs font-medium text-[#374151]">
                            Jenis Bencana<span class="text-red-500">*</span>
                        </span>
                        <select name="jenis_bencana" required
                            class="mt-1 w-full rounded-md border border-[#e5d8c7] bg-white/70 px-3 py-2 text-sm focus:ring-2 focus:ring-[#F39C3D]">
                            <option value="" disabled selected>Pilih Jenis Bencana</option>
                            @foreach ([
                                'ANGIN KENCANG','BANJIR','COVID19','GEMPA BUMI',
                                'KEBAKARAN BANGUNAN','KEBAKARAN LAHAN/ HUTAN',
                                'KEKERINGAN','KONFLIK SOSIAL','LETUSAN GUNUNG API',
                                'TANAH LONGSOR','TSUNAMI'
                            ] as $bencana)
                                <option value="{{ $bencana }}" {{ old('jenis_bencana') == $bencana ? 'selected' : '' }}>
                                    {{ $bencana }}
                                </option>
                            @endforeach
                        </select>
                    </label>


    {{-- Tingkat Posko --}}
    <label class="block">
        <span class="text-xs font-medium">Tingkat Posko</span>
        <input type="text" name="tingkat_posko"
               class="mt-1 w-full rounded-md border px-3 py-2">
    </label>

    {{-- RT RW --}}
    <div class="grid grid-cols-2 gap-3">
        <label class="block">
            <span class="text-xs font-medium">RT *</span>
            <input type="text" name="rt" required
                   class="mt-1 w-full rounded-md border px-3 py-2">
        </label>
        <label class="block">
            <span class="text-xs font-medium">RW *</span>
            <input type="text" name="rw" required
                   class="mt-1 w-full rounded-md border px-3 py-2">
        </label>
    </div>

    {{-- Kabupaten --}}
    <label class="block">
        <span class="text-xs font-medium">Kabupaten *</span>
        <select name="kabupaten" x-model="kabupaten" required
                class="mt-1 w-full rounded-md border px-3 py-2">
            <option value="">Pilih Kabupaten</option>
            @foreach(['Kota Yogyakarta','Sleman','Bantul','Kulon Progo','Gunungkidul'] as $kab)
                <option value="{{ $kab }}">{{ $kab }}</option>
            @endforeach
        </select>
    </label>

    {{-- Kecamatan --}}
   <label class="block">
    <span class="text-xs font-medium">Kecamatan *</span>
    <select name="kecamatan"
            x-model="kecamatan"
            required
            class="mt-1 w-full rounded-md border px-3 py-2">
        <option value="">Pilih Kecamatan</option>

        <template x-for="k in kecOptions" :key="k">
            <option :value="k" x-text="k"></option>
        </template>
    </select>
</label>


    {{-- Kelurahan --}}
    <label class="block">
        <span class="text-xs font-medium">Kelurahan *</span>
        <input type="text" name="kelurahan" required
               class="mt-1 w-full rounded-md border px-3 py-2">
    </label>

    {{-- Desa --}}
    <label class="block">
        <span class="text-xs font-medium">Desa *</span>
        <input type="text" name="desa" required
               class="mt-1 w-full rounded-md border px-3 py-2">
    </label>

    {{-- Upload --}}
  <label class="block">
    <span class="text-xs font-medium text-[#374151]">
        Upload Foto Kejadian<span class="text-red-500">*</span>
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
</label>


    <label class="block">
    <span class="text-xs font-medium text-[#374151]">
        Upload Surat (PDF / DOC / DOCX)<span class="text-red-500">*</span>
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
</label>


</div>

{{-- ================= DAFTAR KEBUTUHAN LOGISTIK ================= --}}
@php
    $barangList = $barang->map(fn($b) => [
        'id' => $b->id,
        'nama' => $b->nama_barang,
        'satuan' => $b->satuan,
        'stok' => $b->stok
    ]);
@endphp

{{-- JUDUL DI LUAR CARD --}}
<h3 class="mt-6 mb-2 text-sm font-semibold text-[#374151]">
    Daftar Kebutuhan Logistik
</h3>

{{-- CARD TABEL --}}
<div
    x-data="{
        rows:[0],
        barang:@js($barangList),
        addRow(){ this.rows.push(this.rows.length) },
        removeRow(i){
            if(this.rows.length > 1) this.rows.splice(i,1)
        }
    }"
    class="rounded-xl border border-[#EADFCF] bg-[#FFF9F2] p-5"
>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-[#F2E7DA] text-[#374151]">
                    <th class="border border-[#EADFCF] px-3 py-2 w-12 text-center">No.</th>
                    <th class="border border-[#EADFCF] px-3 py-2">Nama Barang</th>
                    <th class="border border-[#EADFCF] px-3 py-2 w-28">Satuan</th>
                    <th class="border border-[#EADFCF] px-3 py-2 w-28">Jumlah</th>
                    <th class="border border-[#EADFCF] px-3 py-2">Keterangan</th>
                    <th class="border border-[#EADFCF] px-3 py-2 w-12"></th>
                </tr>
            </thead>

            <tbody>
                <template x-for="(r, i) in rows" :key="i">
                    <tr class="bg-white">
                        {{-- NO --}}
                        <td class="border border-[#EADFCF] text-center" x-text="i + 1"></td>

                        {{-- NAMA BARANG --}}
                        <td class="border border-[#EADFCF] px-3 py-2">
                            <select
                                name="barang_id[]"
                                required
                                class="w-full bg-transparent border-none focus:ring-0"
                                @change="
                                    let b = barang.find(x => x.id == $event.target.value);
                                    let tr = $el.closest('tr');
                                    tr.querySelector('.satuan').value = b ? b.satuan : '';
                                    tr.querySelector('.jumlah').max = b ? b.stok : 1;
                                "
                            >
                                <option value="">-- Pilih Barang --</option>
                                <template x-for="b in barang" :key="b.id">
                                    <option :value="b.id" x-text="b.nama"></option>
                                </template>
                            </select>
                        </td>

                        {{-- SATUAN --}}
                        <td class="border border-[#EADFCF] px-3 py-2">
                            <input
                                type="text"
                                name="satuan[]"
                                readonly
                                class="satuan w-full rounded-md bg-gray-100
                                       border border-gray-200 px-2 py-1
                                       text-center text-sm"
                            >
                        </td>

                        {{-- JUMLAH --}}
                    <td class="border border-[#EADFCF] px-3 py-2">
                        <input
                            type="number"
                            name="jumlah[]"
                            min="1"
                            required
                            class="jumlah w-full rounded-md bg-gray-100
                                border border-gray-200 px-2 py-1
                                text-center text-sm
                                focus:ring-0"
                        >
                    </td>


                        {{-- KETERANGAN --}}
                    <td class="border border-[#EADFCF] px-3 py-2">
                        <input
                            type="text"
                            name="keterangan[]"
                            class="w-full rounded-md bg-gray-100
                                border border-gray-200 px-2 py-1
                                text-sm focus:ring-0"
                        >
                    </td>


                        {{-- HAPUS --}}
                        <td class="border border-[#EADFCF] text-center">
                            <button
                                type="button"
                                @click="removeRow(i)"
                                class="text-red-500 text-lg font-bold hover:text-red-700"
                            >
                                ✕
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- TOMBOL TAMBAH BARIS --}}
    <div class="mt-4 flex justify-center">
        <button
            type="button"
            @click="addRow()"
            class="rounded-full px-6 py-2 text-sm font-semibold text-white shadow hover:shadow-md"
            style="background:linear-gradient(90deg,#F8C16A,#F39C3D);"
        >
            + Tambah Baris
        </button>
    </div>
</div>

{{-- TOMBOL BAWAH --}}
<div class="mt-6 flex justify-end gap-3">
    <a
        href="{{ route('dashboard.history') }}"
        class="rounded-full bg-gray-200 px-5 py-2 text-sm font-semibold text-gray-700
               border border-gray-300 hover:bg-gray-300 transition"
    >
        Batal
    </a>

    <button
        type="submit"
        class="rounded-full px-6 py-2 text-sm font-semibold text-white shadow hover:shadow-md"
        style="background:linear-gradient(90deg,#F8C16A,#F39C3D);"
    >
        Simpan Perubahan
    </button>
</div>


</form>
</div>
</div>

</x-layouts.dashboard-shell>
