{{-- resources/views/Pages/landing.blade.php --}}
<x-layouts.base :title="'BPBD DIY | E–Logistik Pelaporan'">

  <div class="min-h-screen flex flex-col bg-[#F7F4EE] text-[#3d2a1d] overflow-hidden">

    {{-- ================= NAVBAR ================= --}}
    <header class="sticky top-0 z-20 bg-white/95 backdrop-blur border-b border-[#eadfcf] shadow-sm">
      <div class="mx-auto max-w-6xl h-20 px-6 flex items-center justify-between">
        {{-- Logo dan Judul --}}
        <div class="flex items-center gap-4">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}" class="w-12 h-12 rounded-full" alt="BPBD DIY">
          <span class="font-bold tracking-wide text-[17px] text-[#3d2a1d]">
            BPBD DIY | <span class="text-[#9b6a3a] font-semibold">E–Logistik Pelaporan</span>
          </span>
        </div>

        {{-- Tombol Auth --}}
        <nav class="flex items-center gap-3">
          @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="px-5 py-2.5 rounded-full font-semibold border border-[#E8D7C7] text-[#7A5A3A]
                      bg-white hover:bg-[#FFF7EF] text-[15px] transition">
              Sign Up
            </a>
          @endif
          @php $loginUrl = Route::has('login') ? route('login') : url('/login'); @endphp
          <a href="{{ $loginUrl }}"
             class="px-5 py-2.5 rounded-full font-semibold text-[#3d2a1d]
                    text-[15px] shadow-md hover:-translate-y-0.5 transition"
             style="background:linear-gradient(90deg,#F8C16A 0%,#F39C3D 100%);">
            Sign In
          </a>
        </nav>
      </div>
    </header>

    {{-- ================= HERO SECTION ================= --}}
    <section class="relative bg-[#8A552D] text-white overflow-hidden flex flex-col items-center justify-center min-h-[48vh]">
      {{-- Background peta --}}
      <img src="{{ asset('images/icons/peta.png') }}" alt="Peta Indonesia"
           class="absolute inset-0 w-full h-full object-cover opacity-25 mix-blend-multiply" />

      {{-- Konten --}}
      <div class="relative z-10 text-center px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
          Sistem Pelaporan Logistik BPBD DIY
        </h1>
        <p class="text-white/90 max-w-3xl mx-auto">
          Platform resmi untuk mengajukan kebutuhan logistik dan memantau riwayat pelaporan Anda secara digital.
        </p>
        <div class="mt-8">
          <a href="{{ $loginUrl }}"
             class="inline-block px-7 py-3 rounded-full font-bold text-white
                    shadow-md hover:-translate-y-0.5 transition"
             style="background:#F7941D;">
            MULAI LAPOR
          </a>
        </div>
      </div>
    </section>

    {{-- ================= FITUR SECTION ================= --}}
    <section class="relative bg-white h-[300px] flex items-center justify-center shadow-inner">
      <div class="mx-auto max-w-6xl px-6">
        <h2 class="text-center text-[#6B5140] tracking-[.15em] font-semibold text-sm md:text-base mb-8 md:mb-10">
          DIRANCANG UNTUK MEMUDAHKAN ANDA
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          {{-- Kartu 1 --}}
          <div class="rounded-2xl bg-[#F9F8F6] border border-[#E5DBC9] p-8
                      shadow-[0_4px_20px_rgba(0,0,0,0.08)]
                      hover:shadow-[0_12px_30px_rgba(0,0,0,0.15)]
                      transition-all duration-300 hover:-translate-y-1 hover:scale-[1.01]">
            <div class="flex flex-col items-center text-center gap-4">
              <img src="{{ asset('images/icons/new.png') }}" alt="Pelaporan" class="w-14 h-14 object-contain">
              <div>
                <h3 class="font-semibold text-[#1f1a14] text-lg">Pelaporan Digital Cepat</h3>
                <p class="text-sm text-[#6E5C49] mt-1">
                  Permohonan & pelaporan logistik terekam otomatis dan terstruktur.
                </p>
              </div>
            </div>
          </div>

          {{-- Kartu 2 --}}
          <div class="rounded-2xl bg-[#F9F8F6] border border-[#E5DBC9] p-8
                      shadow-[0_4px_20px_rgba(0,0,0,0.08)]
                      hover:shadow-[0_12px_30px_rgba(0,0,0,0.15)]
                      transition-all duration-300 hover:-translate-y-1 hover:scale-[1.01]">
            <div class="flex flex-col items-center text-center gap-4">
              <img src="{{ asset('images/icons/waktu.png') }}" alt="Lacak" class="w-14 h-14 object-contain">
              <div>
                <h3 class="font-semibold text-[#1f1a14] text-lg">Lacak Riwayat Laporan</h3>
                <p class="text-sm text-[#6E5C49] mt-1">
                  Semua status & histori dapat dipantau real-time kapan saja.
                </p>
              </div>
            </div>
          </div>

          {{-- Kartu 3 --}}
          <div class="rounded-2xl bg-[#F9F8F6] border border-[#E5DBC9] p-8
                      shadow-[0_6px_24px_rgba(0,0,0,0.10)]
                      hover:shadow-[0_16px_38px_rgba(0,0,0,0.18)]
                      transition-all duration-300 hover:-translate-y-1.5 hover:scale-[1.02]">
            <div class="flex flex-col items-center text-center gap-4">
              <img src="{{ asset('images/icons/Download.png') }}" alt="Data Aman" class="w-14 h-14 object-contain">
              <div>
                <h3 class="font-semibold text-[#1f1a14] text-lg">Data Terverifikasi Aman</h3>
                <p class="text-sm text-[#6E5C49] mt-1">
                  Arsip terintegrasi dan mudah dievaluasi dengan aman.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</x-layouts.base>
