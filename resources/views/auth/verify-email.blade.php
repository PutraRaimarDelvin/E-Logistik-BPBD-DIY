{{-- resources/views/auth/verify-email.blade.php --}}
<x-layouts.base :title="'Verifikasi Email | E-Logistik BPBD DIY'">
  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw] rounded-2xl shadow-2xl ring-1 ring-black/20
                bg-[#5a3924]/90 backdrop-blur-sm p-8 text-white">

      <div class="flex items-center gap-3">
        <img src="{{ asset('images/icons/logo-bpbd.png') }}"
             class="w-10 h-10 rounded-full object-contain" alt="BPBD DIY">
        <div>
          <div class="font-semibold leading-tight">BPBD DIY</div>
          <div class="text-[11px] text-white/70">E–Logistik Pelaporan</div>
        </div>
      </div>

      <h1 class="mt-6 text-xl font-semibold">Verifikasi Email Anda</h1>
      <p class="mt-2 text-sm text-white/80">
        Kami telah mengirimkan link verifikasi ke alamat email yang Anda daftarkan.
        Silakan cek inbox (atau folder spam) lalu klik link tersebut untuk mengaktifkan akun.
      </p>

      @if (session('success'))
        <div class="mt-4 rounded-md bg-emerald-500/10 text-emerald-200 border border-emerald-400/40 px-3 py-2 text-sm">
          {{ session('success') }}
        </div>
      @endif

      {{-- Form kirim ulang email verifikasi --}}
      <form method="POST" action="{{ route('verification.send') }}" class="mt-6 space-y-3">
        @csrf
        <button type="submit"
                class="w-full px-4 py-2.5 rounded-full font-semibold text-white
                       shadow-md hover:-translate-y-0.5 transition
                       bg-[#004AAD] hover:bg-[#00328A]">
          Kirim Ulang Link Verifikasi
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit"
                class="w-full px-4 py-2 rounded-full text-sm font-medium
                       bg-white/10 hover:bg-white/15 text-white">
          Keluar
        </button>
      </form>
    </div>
  </div>
</x-layouts.base>
