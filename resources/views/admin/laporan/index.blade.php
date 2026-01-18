<x-layouts.admin-shell :title="'Daftar Laporan | E-Logistik Admin'" active="laporan">

  {{-- Background --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%)">
  </div>

 <div class="max-w-6xl mx-auto mt-4 space-y-3">


    {{-- Judul --}}
    <div class="text-center">
      <h1 class="text-2xl font-bold italic text-[#111827] text-center">
    Selamat Datang, {{ auth()->user()->name ?? 'Admin BPBD' }} 👋
</h1>

<h2 class="text-lg font-semibold text-[#111827] mt-6 text-left">
    Daftar Laporan
</h2>

<p class="text-sm text-[#4B5563] text-left">
    bencana yang telah dilaporkan oleh pengguna
</p>
    </div>

    {{-- ⭐⭐⭐ <== BAGIAN 1: Jarak Judul → Search Bar --}}
   {{-- ⭐⭐⭐ SEARCH BAR --}}
<form method="GET" action="{{ route('admin.laporan.index') }}"
  class="mt-10 w-full sm:w-[600px] bg-white shadow-md rounded-full border border-[#eadfce]
         flex items-center gap-2 px-4 py-2 transition hover:shadow-lg">

  {{-- ICON --}}
  <div class="flex items-center flex-grow">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5 text-[#bf6b29] mr-2"
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
    </svg>

    <input type="text"
           name="kejadian"
           placeholder="Cari kejadian atau user..."
           value="{{ request('kejadian') }}"
           class="w-full bg-transparent border-none outline-none text-sm placeholder:text-gray-400 focus:ring-0 text-[#1f2937]">
  </div>

 <div class="flex items-center gap-2">

    {{-- Tanggal --}}
    <select name="tanggal"
        class="h-8 px-2 border border-[#eadfce] bg-white rounded-md text-sm text-[#374151]
               focus:ring-2 focus:ring-[#bf6b29]">
        <option value="">Tanggal</option>
        @for ($i = 1; $i <= 31; $i++)
            <option value="{{ $i }}" {{ request('tanggal') == $i ? 'selected' : '' }}>
                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
            </option>
        @endfor
    </select>

    {{-- Bulan --}}
    <select name="bulan"
        class="h-8 px-2 border border-[#eadfce] bg-white rounded-md text-sm text-[#374151]
               focus:ring-2 focus:ring-[#bf6b29]">
        <option value="">Bulan</option>
        @foreach ([1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'] as $num => $name)
            <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>

    {{-- Tahun --}}
    <select name="tahun"
        class="h-8 px-2 border border-[#eadfce] bg-white rounded-md text-sm text-[#374151]
               focus:ring-2 focus:ring-[#bf6b29]">
        <option value="">Tahun</option>
        @foreach(range(date('Y'), date('Y') - 10) as $year)
            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>

</div>


  {{-- BUTTON --}}
  <button type="submit"
          class="bg-gradient-to-r from-[#F8B84E] to-[#F39C3D] text-white text-sm font-semibold px-3 py-1.5 rounded-full hover:shadow-md hover:scale-[1.05] transition">
    Cari
  </button>

  @if(request()->hasAny(['tanggal','bulan','tahun','kejadian']))
    <a href="{{ route('admin.laporan.index') }}"
       class="text-sm px-3 py-1 rounded-full font-medium text-[#374151] border border-[#e5d8c7] hover:bg-[#FFF7EF] transition">
      Reset
    </a>
  @endif

</form>


    {{-- ⭐⭐⭐ <== BAGIAN 2: Jarak Search Bar → Tabel --}}
    {{-- Ubah mt-7 menjadi mt-5 / mt-6 / mt-8 --}}
    <div class="mt-3 overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.16)]">

      <div class="grid grid-cols-[0.7fr_0.6fr_1.4fr_1fr_0.7fr_60px]
        px-4 py-2 text-xs font-semibold uppercase tracking-wide
        text-white bg-gradient-to-r from-[#003366] via-[#0055A5] to-[#003366]">

        <div class="text-center -ml-8">Nama User</div>
        <div class="text-center pl-15">Tanggal</div>
        <div class="text-center">Alamat</div>
        <div class="text-center">Kejadian</div>
        <div class="text-center">Status</div>
        <div class="text-center">Aksi</div>
      </div>

      {{-- ROW --}}
      @forelse($laporans as $laporan)
        <div class="grid grid-cols-[0.7fr_0.6fr_1.4fr_1fr_0.7fr_60px]
          px-4 py-3 text-sm leading-snug bg-white
          hover:bg-[#D8E9FF] transition-colors border-b border-[#e5e7eb]">

          <div class="font-medium text-[#111827] text-left pl-10">
            {{ $laporan->user->name ?? '-' }}
          </div>

          <div class="text-center text-[#111827] pl-15">
            {{ $laporan->created_at?->format('d M Y, H:i') ?? '-' }}
          </div>

          <div class="text-[#374151] pl-16">
            {{ $laporan->desa }},
            RT {{ $laporan->rt }}/RW {{ $laporan->rw }},
            {{ $laporan->kecamatan }},
            {{ $laporan->kabupaten }}
          </div>

          <div class="flex items-center justify-center">
            <span class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-[#F8B84E] to-[#F39C3D] px-4 py-1 text-xs font-semibold text-black shadow-md">
              {{ $laporan->jenis_bencana ?? '-' }}
            </span>
          </div>

          <div class="flex items-center justify-center">
            @if ($laporan->status_validasi === 'Disetujui')
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
            @elseif ($laporan->status_validasi === 'Ditolak')
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
            @else
              <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
            @endif
          </div>

          <div class="flex items-center justify-center">
            <a href="{{ route('admin.laporan.show', $laporan->id) }}"
               class="text-[#1D4ED8] hover:text-[#0B3EA8] text-lg transition">
              <i class="fa-solid fa-eye"></i>
            </a>
          </div>

        </div>

      @empty
        <div class="px-4 py-6 text-center text-sm text-[#6B7280] bg-white">
          Belum ada data laporan yang masuk.
        </div>
      @endforelse

    </div>
<div class="mt-6 flex items-center justify-between">

    {{-- BACK --}}
    @if ($laporans->onFirstPage())
        <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            ‹ Back
        </span>
    @else
        <a href="{{ $laporans->previousPageUrl() }}"
           class="px-4 py-2 rounded-lg bg-blue-700 text-white hover:bg-blue-800">
            ‹ Back
        </a>
    @endif

    {{-- NEXT --}}
    @if ($laporans->hasMorePages())
        <a href="{{ $laporans->nextPageUrl() }}"
           class="px-4 py-2 rounded-lg bg-blue-700 text-white hover:bg-blue-800">
            Next ›
        </a>
    @else
        <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            Next ›
        </span>
    @endif

</div>



  </div>

</x-layouts.admin-shell>
