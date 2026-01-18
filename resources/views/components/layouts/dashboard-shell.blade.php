@props(['title' => 'Dashboard | E-Logistik', 'active' => 'history'])

<x-layouts.base :title="$title">
  <style>
    html, body {
      background: #896e56ff;
      overflow: hidden;
    }
    [x-cloak]{display:none!important;}
  </style>

  {{-- GRID FULL LAYAR --}}
  <div x-data="{ showHistory:false, showForm:false, profileOpen:false }"
     class="min-h-screen grid grid-rows-[65px_1fr] grid-cols-[auto_1fr] gap-0">

    {{-- ========== HEADER ========== --}}
    <header class="row-start-1 col-span-2 z-[60] overflow-visible">
      <div class="h-[70px] w-full flex items-center text-white px-5 rounded-none shadow-md justify-between"
           style="background: radial-gradient(120% 120% at -10% -10%, #9a5a30 0%, #bf6b29 45%, #e3852f 70%, #f39c3d 100%); margin-bottom:-1px;">

        {{-- KIRI: Logo + instansi --}}
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}" alt="BPBD"
               class="w-10 h-10 rounded-full object-contain">
          <div class="leading-tight">
            <div class="text-base font-semibold tracking-wide">Badan Penanggulangan Bencana Daerah</div>
            <div class="text-[16px] opacity-90">Daerah Istimewa Yogyakarta</div>
          </div>
        </div>

        {{-- TENGAH: JAM WIB --}}
        <div class="flex-1 text-center">
          <div x-data="clockID()" x-init="start()"
               class="inline-flex items-center gap-2 text-[14px] sm:text-[15px] font-semibold tracking-wide">
            <span x-text="date"></span>
            <span>•</span>
            <span x-text="time"></span>
            <span class="opacity-90">WIB</span>
          </div>
        </div>

        {{-- KANAN: User + dropdown profil --}}
        <div class="relative flex items-center gap-3">
          <span class="text-[20px] font-medium whitespace-nowrap">
            {{ auth()->user()->name ?? 'User' }}
          </span>

          <button type="button"
                  @click="profileOpen = !profileOpen"
                  class="flex items-center gap-2 focus:outline-none">
            <img src="{{ asset('images/icons/user.png') }}" alt="User" class="w-8 h-8 rounded-full object-cover">

            <svg viewBox="0 0 24 24"
                 class="w-4 h-4 fill-white opacity-90 transition-transform"
                 :class="profileOpen ? 'rotate-180' : ''">
              <path d="M7 10l5 5 5-5z"/>
            </svg>
          </button>

          {{-- Dropdown profil --}}
         {{-- Dropdown profil --}}
<div x-cloak
     x-show="profileOpen"
     @click.outside="profileOpen = false"
     x-transition
     class="absolute right-0 top-[52px] mt-2 w-44 rounded-xl bg-white shadow-[0_4px_18px_rgba(0,0,0,0.12)]
            ring-1 ring-black/5 z-[80] overflow-hidden">

    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-2 px-4 py-3 text-sm text-[#374151]
              hover:bg-[#FFF4E5] transition">

        <i class="fa-solid fa-user-pen text-[#bf6b29]"></i>
        <span>Edit Profil</span>
    </a>

</div>

        </div>
      </div>
    </header>

          {{-- ========== SIDEBAR ========== --}}
      <aside class="row-start-2 col-start-1 text-white relative z-20 w-56">
        <div class="h-full rounded-tr-3xl overflow-hidden relative flex flex-col"
            style="background: radial-gradient(120% 120% at -10% -10%, #9a5a30 0%, #bf6b29 45%, #e3852f 70%, #f39c3d 100%); margin-top:-1px;">

          <div class="absolute top-0 left-0 right-0 h-[5px] bg-gradient-to-b from-black/10 to-transparent"></div>

          <nav class="p-4 text-sm mt-2 space-y-1">



          {{-- History: buka modal --}}
          <button type="button"
                  @click="showHistory=true"
                  class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                         {{ $active==='history' ? 'bg-white/25 text-white' : 'hover:bg-white/10 text-white/90' }}">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z"/>
            </svg>
            History Laporan
          </button>

          {{-- Form: buka modal --}}
          <button type="button"
                  @click="showForm=true"
                  class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                         {{ $active==='form' ? 'bg-white/25 text-white' : 'hover:bg-white/10 text-white/90' }}">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7v-2H5V7h14v5h2V5a2 2 0 0 0-2-2Zm1.71 13.29-1-1a1 1 0 0 0-1.42 0L15 18.59V21h2.41l3.29-3.29a1 1 0 0 0 0-1.42Z"/>
            </svg>
            Formulir Laporan
          </button>

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
        
@if (request()->routeIs('dashboard') || request()->routeIs('dashboard.history'))
    <div class="mt-auto px-3 pb-4">
        <a
            href="https://api.whatsapp.com/send?phone=6285163683861&text={{ urlencode(
    'Halo BPBD DIY, saya ' . auth()->user()->name . ' ingin melaporkan kebutuhan logistik bencana.'
) }}"
            target="_blank"
            rel="noopener noreferrer"
            class="block rounded-xl bg-[#003366] p-3 text-white shadow-md hover:bg-[#002244] transition"
        >


        <div class="flex items-center gap-3">
    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#25D366] text-white">
        <i class="fa-brands fa-whatsapp"></i>
    </div>

    <div class="leading-tight">
        <p class="text-xs font-semibold uppercase tracking-wide italic">
            whatsapp
        </p>
        <p class="text-sm font-bold">
            LOGISTIK BPBD
        </p>
    </div>
</div>



    </a>
        </div>
@endif
    


      </div>
    </aside>

    {{-- ========== MAIN ========== --}}
    <main class="row-start-2 col-start-2 relative z-10">
      <div class="absolute inset-0 -z-10" style="background:#F0F8FF;"></div>

      <div class="px-6 py-6 overflow-hidden">
        {{ $slot }}
      </div>
    </main>

    {{-- ========== MODAL: HISTORY LAPORAN ========== --}}
    <div x-cloak x-show="showHistory" @keydown.escape.window="showHistory=false"
         class="fixed inset-0 z-[100] flex items-center justify-center">
      <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showHistory=false"></div>
      <div x-transition
           class="relative w-[520px] max-w-[92vw] rounded-2xl shadow-2xl overflow-hidden border border-white/20"
           style="background:linear-gradient(180deg,#f7f0e9 0%,#efe3d7 100%);">
        <div class="px-6 py-5 flex items-start gap-3">
          <div class="shrink-0 w-10 h-10 rounded-lg flex items-center justify-center text-white"
               style="background:linear-gradient(135deg,#B76320,#F39C3D);">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z"/>
            </svg>
          </div>
          <div class="grow">
            <h3 class="font-semibold text-[#4A2E17] text-lg">History Laporan</h3>
            <p class="text-sm text-[#6b5a4e] mt-1">
              Lihat daftar laporan masuk lengkap dengan departemen, role, serta aksi (lihat, edit, hapus).
            </p>
          </div>
        </div>
        <div class="px-6 pb-5 flex justify-end gap-3">
          <button @click="showHistory=false"
                  class="px-4 py-2 rounded-full text-[#4A2E17] border border-[#e7d6c7] bg-white hover:bg-[#fff7ef]">
            Tutup
          </button>
          <a href="{{ route('dashboard.history') }}"
             class="px-5 py-2 rounded-full font-semibold text-white hover:shadow-md"
             style="background:linear-gradient(90deg,#F8C16A 0%,#F39C3D 100%);">
            Buka Halaman
          </a>
        </div>
      </div>
    </div>

    {{-- ========== MODAL: FORMULIR LAPORAN ========== --}}
    <div x-cloak x-show="showForm" @keydown.escape.window="showForm=false"
         class="fixed inset-0 z-[100] flex items-center justify-center">
      <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showForm=false"></div>
      <div x-transition
           class="relative w-[520px] max-w-[92vw] rounded-2xl shadow-2xl overflow-hidden border border-white/20"
           style="background:linear-gradient(180deg,#f7f0e9 0%,#efe3d7 100%);">
        <div class="px-6 py-5 flex items-start gap-3">
          <div class="shrink-0 w-10 h-10 rounded-lg flex items-center justify-center text-white"
               style="background:linear-gradient(135deg,#B76320,#F39C3D);">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Zm1 7H8V7h7v2Zm0 4H8v-2h7v2Zm-3 4H8v-2h4v2Z"/>
            </svg>
          </div>
          <div class="grow">
            <h3 class="font-semibold text-[#4A2E17] text-lg">Formulir Laporan</h3>
            <p class="text-sm text-[#6b5a4e] mt-1">
              Buat laporan baru dengan data pemohon, kebutuhan logistik, dan dokumen pendukung.
            </p>
          </div>
        </div>
        <div class="px-6 pb-5 flex justify-end gap-3">
          <button @click="showForm=false"
                  class="px-4 py-2 rounded-full text-[#4A2E17] border border-[#e7d6c7] bg-white hover:bg-[#fff7ef]">
            Tutup
          </button>
          <a href="{{ route('dashboard.form') }}"
             class="px-5 py-2 rounded-full font-semibold text-white hover:shadow-md"
             style="background:linear-gradient(90deg,#F8C16A 0%,#F39C3D 100%);">
            Buka Halaman
          </a>
        </div>
      </div>
    </div>

  </div>

  {{-- Komponen jam WIB untuk Alpine --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('clockID', () => ({
        date: '', time: '',
        fmtDate: new Intl.DateTimeFormat('id-ID', {
          weekday: 'short', day: '2-digit', month: 'short', year: 'numeric',
          timeZone: 'Asia/Jakarta'
        }),
        fmtTime: new Intl.DateTimeFormat('id-ID', {
          hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false,
          timeZone: 'Asia/Jakarta'
        }),
        tick() {
          const now = new Date();
          this.date = this.fmtDate.format(now);
          this.time = this.fmtTime.format(now);
        },
        start() {
          this.tick();
          setInterval(() => this.tick(), 1000);
        }
      }))
    });
  </script>

  {{-- SweetAlert2 CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- SweetAlert flash message --}}
  @if (session('success'))
    <script>
      Swal.fire({
        title: '✅ Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonColor: '#e3852f',
        background: '#fffaf3',
        color: '#3d2a1d'
      })
    </script>
  @endif

  @if (session('error'))
    <script>
      Swal.fire({
        title: '❌ Gagal!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonColor: '#e3852f',
        background: '#fffaf3',
        color: '#3d2a1d'
      })
    </script>
  @endif

</x-layouts.base>
