{{-- resources/views/layouts/admin-shell.blade.php --}}
@props(['title' => 'Dashboard Admin | E-Logistik', 'active' => 'dashboard'])

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-layouts.base :title="$title">
  {{-- ⛔ MATIKAN SCROLL BODY --}}
  <div class="h-screen overflow-hidden grid grid-rows-[70px_1fr] grid-cols-[auto_1fr]">

    {{-- ================= HEADER ================= --}}
    <header class="row-start-1 col-span-2 z-[60] h-[70px]">
      <div class="h-full w-full flex items-center text-white px-5 shadow-md justify-between"
           style="background: radial-gradient(120% 120% at -10% -10%, #9a5a30 0%, #bf6b29 45%, #e3852f 70%, #f39c3d 100%);">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}" class="w-10 h-10 rounded-full object-contain">
          <div class="leading-tight">
            <div class="text-base font-semibold">Badan Penanggulangan Bencana Daerah</div>
            <div class="text-[16px] opacity-90">Daerah Istimewa Yogyakarta</div>
          </div>
        </div>

        {{-- Jam --}}
        <div class="flex-1 text-center">
          <div x-data="clockID()" x-init="start()"
               class="inline-flex items-center gap-2 text-[14px] font-semibold">
            <span x-text="date"></span>
            <span>•</span>
            <span x-text="time"></span>
            <span class="opacity-90">WIB</span>
          </div>
        </div>

        {{-- Profile --}}
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
                  class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#e3852f]">
            <span class="font-semibold">{{ auth()->user()->name ?? 'Admin BPBD' }}</span>
            <img src="{{ asset('images/icons/user.png') }}" class="w-8 h-8 rounded-full">
            <i class="fa-solid fa-caret-down"></i>
          </button>

          <div x-show="open" @click.away="open=false"
               class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl border z-50">
            <a href="{{ route('admin.profile.edit') }}"
               class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-[#FFF3E6]">
              <i class="fa-solid fa-user-pen text-[#bf6b29]"></i> Edit Profil
            </a>
          </div>
        </div>

      </div>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <aside class="row-start-2 col-start-1 w-56 text-white">
      <div class="h-full rounded-tr-3xl"
           style="background: radial-gradient(120% 120% at -10% -10%, #9a5a30 0%, #bf6b29 45%, #e3852f 70%, #f39c3d 100%);">

        <nav class="p-4 space-y-1 text-sm">

          {{-- Dashboard --}}
          <a href="{{ route('admin.dashboard') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg
             {{ $active==='dashboard' ? 'bg-white/25 font-semibold' : 'hover:bg-white/10' }}">
            <i class="fa-solid fa-house"></i> Dashboard
          </a>

          <a href="{{ route('admin.laporan.index') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg
             {{ $active==='laporan' ? 'bg-white/25 font-semibold' : 'hover:bg-white/10' }}">
            <i class="fa-solid fa-list"></i> Daftar Laporan
          </a>

          <a href="{{ route('admin.barang.index') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg
             {{ request()->routeIs('admin.barang.*') ? 'bg-white/25 font-semibold' : 'hover:bg-white/10' }}">
            <i class="fa-solid fa-box"></i> Daftar Barang
          </a>

          <a href="{{ route('admin.users.index') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg
             {{ $active==='users' ? 'bg-white/25 font-semibold' : 'hover:bg-white/10' }}">
            <i class="fa-solid fa-users"></i> Kelola User
          </a>

          {{-- Logout --}}
          <form method="POST" action="{{ route('logout') }}" class="mt-6 px-3">
            @csrf
            <button class="flex items-center gap-2 text-sm hover:text-white">
              <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </button>
          </form>

        </nav>
      </div>
    </aside>

    {{-- ================= MAIN (SCROLL AREA) ================= --}}
  <main class="row-start-2 col-start-2 relative overflow-hidden">


      <div class="absolute inset-0 -z-10 bg-[#F0F8FF]"></div>

      {{-- ⬇️ PENTING: min-h-full --}}
      <div class="px-6 py-6 min-h-full pb-32">
        {{ $slot }}
      </div>
    </main>

  </div>  
  {{-- ================= JAM SCRIPT ================= --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('clockID', () => ({
        date: '', time: '',
        fmtDate: new Intl.DateTimeFormat('id-ID', { weekday:'short', day:'2-digit', month:'short', year:'numeric', timeZone:'Asia/Jakarta' }),
        fmtTime: new Intl.DateTimeFormat('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:false, timeZone:'Asia/Jakarta' }),
        tick(){ const n=new Date(); this.date=this.fmtDate.format(n); this.time=this.fmtTime.format(n); },
        start(){ this.tick(); setInterval(()=>this.tick(),1000); }
      }))
    });
  </script>

  {{-- ================= SWEETALERT ================= --}}
  @if (session('success'))
  <script>
    Swal.fire({
      title: 'Berhasil!',
      text: "{{ session('success') }}",
      icon: 'success',
      confirmButtonColor: '#e3852f',
      background: '#fffaf3'
    });
  </script>
  @endif

  @if (session('error'))
  <script>
    Swal.fire({
      title: 'Gagal!',
      text: "{{ session('error') }}",
      icon: 'error',
      confirmButtonColor: '#e3852f',
      background: '#fffaf3'
    });
  </script>
  @endif

  <script src="//unpkg.com/alpinejs" defer></script>

</x-layouts.base>
