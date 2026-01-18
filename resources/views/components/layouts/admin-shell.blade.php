{{-- resources/views/layouts/admin-shell.blade.php --}}
@props(['title' => 'Dashboard Admin | E-Logistik', 'active' => 'dashboard'])

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-layouts.base :title="$title">
  <div class="min-h-screen grid grid-rows-[65px_1fr] grid-cols-[auto_1fr]">

    {{-- ================= HEADER ================= --}}
    <header class="row-start-1 col-span-2 z-[60]">
      <div class="h-[70px] w-full flex items-center text-white px-5 shadow-md justify-between"
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
               class="inline-flex items-center gap-2 text-[14px] sm:text-[15px] font-semibold">
            <span x-text="date"></span>
            <span>•</span>
            <span x-text="time"></span>
            <span class="opacity-90">WIB</span>
          </div>
        </div>

        {{-- ============ DROPDOWN PROFILE ADMIN ============ --}}
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
                  class="flex items-center gap-2 text-white font-medium px-3 py-2 rounded-md hover:bg-[#e3852f] transition">
            <span class="text-[18px] font-semibold">
              {{ auth()->user()->name ?? 'Admin BPBD' }}
            </span>
            <img src="{{ asset('images/icons/user.png') }}" class="w-8 h-8 rounded-full">
            <i class="fa-solid fa-caret-down text-lg"></i>
          </button>

          {{-- Dropdown menu --}}
          <div x-show="open" @click.away="open = false"
               class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl border border-[#eadfce] z-50">

            <a href="{{ route('admin.profile.edit') }}"
               class="flex items-center gap-3 px-4 py-2 text-sm text-[#1F2937] hover:bg-[#FFF3E6]">
              <i class="fa-solid fa-user-pen text-[#bf6b29]"></i>
              Edit Profil
            </a>
          </div>
        </div>

      </div>
    </header>

    {{-- ================= SIDEBAR ================= --}}
    <aside class="row-start-2 col-start-1 text-white w-56">
      <div class="h-full rounded-tr-3xl overflow-hidden"
           style="background: radial-gradient(120% 120% at -10% -10%, #9a5a30 0%, #bf6b29 45%, #e3852f 70%, #f39c3d 100%);">

        <nav class="p-4 text-sm mt-2 space-y-1">

          <a href="{{ route('admin.laporan.index') }}"
             class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg
                    {{ $active==='laporan' ? 'bg-white/25 text-white' : 'hover:bg-white/10 text-white/90' }}">
            <i class="fa-solid fa-list"></i> Daftar Laporan
          </a>

          {{-- Menu Daftar Barang --}}
          <a href="{{ route('admin.barang.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg
                    hover:bg-white/10 transition
                    {{ request()->routeIs('admin.barang.*') ? 'bg-white/20 text-white font-semibold' : 'text-white/80' }}">
              <i class="fa-solid fa-box"></i>
              <span>Daftar Barang</span>
          </a>


          <a href="{{ route('admin.users.index') }}"
             class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg
                    {{ $active==='users' ? 'bg-white/25 text-white' : 'hover:bg-white/10 text-white/90' }}">
            <i class="fa-solid fa-users"></i> Kelola User
          </a>
            {{-- Logout --}}
          <form method="POST" action="{{ route('logout') }}" class="px-3 mt-6">
            @csrf
            <button
              class="flex items-center gap-2 text-sm font-medium text-white/90 hover:text-white transition">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12H3m12 0l-4 4m4-4l-4-4m9 12a9 9 0 110-18 9 9 0 010 18z" />
              </svg>
              Logout
            </button>
          </form>

        </nav>

      </div>
    </aside>

    {{-- ================= MAIN SLOT ================= --}}
    <main class="row-start-2 col-start-2 relative">
      <div class="absolute inset-0 -z-10" style="background:#F0F8FF;"></div>
      <div class="px-6 py-6">
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
