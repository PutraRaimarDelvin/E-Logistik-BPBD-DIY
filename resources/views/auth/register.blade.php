{{-- resources/views/auth/register.blade.php --}}
<x-layouts.base :title="'Sign Up | E-Logistik BPBD DIY'">
  {{-- Background gradasi --}}
  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw] rounded-2xl shadow-2xl ring-1 ring-black/20
                bg-[#5a3924]/90 backdrop-blur-sm p-8 text-white">

      {{-- === TOP BAR === --}}
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}"
               class="w-10 h-10 rounded-full object-contain" alt="BPBD DIY">
          <div>
            <div class="font-semibold leading-tight">BPBD DIY</div>
            <div class="text-[11px] text-white/70">E–Logistik Pelaporan</div>
          </div>
        </div>

        {{-- Hanya SIGN UP (LOGIN dihapus) --}}
        <nav class="flex items-center gap-5 text-sm">
          <span class="font-semibold border-b-2 border-white pb-[2px]">SIGN UP</span>
        </nav>
      </div>

      {{-- JUDUL --}}
      <h3 class="mt-6 text-white font-semibold text-[18px]">
        Buat Akun E-Logistik BPBD DIY
      </h3>
      <p class="text-xs text-white/70 mt-1">
        Setelah mendaftar, Anda akan diminta untuk <span class="font-semibold">verifikasi email</span>.
      </p>

      {{-- FLASH SUCCESS --}}
      @if (session('success'))
        <div class="mt-4 rounded-md bg-emerald-500/10 text-emerald-200 border border-emerald-400/40 px-3 py-2 text-sm">
          {{ session('success') }}
        </div>
      @endif

      {{-- ERROR VALIDATION --}}
      @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-500/10 text-red-200 border border-red-400/40 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      {{-- FORM SIGN UP --}}
      <form method="POST" action="{{ route('register') }}" class="mt-4 space-y-4">
        @csrf

        {{-- NAME --}}
        <div>
          <label for="name" class="text-xs text-white/80">Nama Lengkap</label>
          <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                 class="mt-1 w-full rounded-md px-3 py-3 text-sm text-[#2b180d]
                        bg-white/95 border
                        @error('name')
                          border-red-400 ring-2 ring-red-300/50
                        @else
                          border-white/10 focus:ring-2 focus:ring-amber-400
                        @enderror
                        shadow-inner outline-none" />
        </div>

        {{-- EMAIL --}}
        <div>
          <label for="email" class="text-xs text-white/80">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                 class="mt-1 w-full rounded-md px-3 py-3 text-sm text-[#2b180d]
                        bg-white/95 border
                        @error('email')
                          border-red-400 ring-2 ring-red-300/50
                        @else
                          border-white/10 focus:ring-2 focus:ring-amber-400
                        @enderror
                        shadow-inner outline-none" />
        </div>

        {{-- PASSWORD --}}
        <div>
          <label for="password" class="text-xs text-white/80">Kata Sandi</label>
          <input id="password" type="password" name="password" required autocomplete="new-password"
                 class="mt-1 w-full rounded-md px-3 py-3 text-sm text-[#2b180d]
                        bg-white/95 border
                        @error('password')
                          border-red-400 ring-2 ring-red-300/50
                        @else
                          border-white/10 focus:ring-2 focus:ring-amber-400
                        @enderror
                        shadow-inner outline-none" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
          <label for="password_confirmation" class="text-xs text-white/80">Konfirmasi Kata Sandi</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                 class="mt-1 w-full rounded-md px-3 py-3 text-sm text-[#2b180d]
                        bg-white/95 border border-white/10 focus:ring-2 focus:ring-amber-400
                        shadow-inner outline-none" />
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between pt-2">
          <p class="text-[12px] text-white/80">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="underline hover:text-white">Login di sini</a>
          </p>

          <button type="submit"
                  class="px-5 py-2.5 rounded-full font-semibold text-white
                         shadow-md hover:-translate-y-0.5 transition
                         bg-[#004AAD] hover:bg-[#00328A]">
            DAFTAR
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layouts.base>
