<x-layouts.base :title="'Sign Up | E-Logistik BPBD DIY'">
  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw]
                bg-[#5a3924]/90 backdrop-blur-md
                rounded-2xl
                shadow-[0_30px_90px_rgba(0,0,0,0.65)]
                ring-1 ring-white/10
                p-8 text-white">

      {{-- HEADER --}}
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}"
               class="w-11 h-11 rounded-full object-contain bg-white/90 p-1"
               alt="BPBD DIY">
          <div>
            <p class="font-semibold leading-tight">BPBD DIY</p>
            <span class="text-[11px] text-white/70">E–Logistik Pelaporan</span>
          </div>
        </div>

        <span class="text-sm font-semibold border-b border-white pb-[2px]">
          SIGN UP
        </span>
      </div>

      {{-- TITLE --}}
      <h3 class="text-lg font-semibold">Buat Akun E-Logistik</h3>
      <p class="text-xs text-white/70 mt-1">
        Email akan digunakan untuk proses verifikasi akun.
      </p>

      {{-- SUCCESS --}}
      @if (session('success'))
        <div class="mt-4 rounded-md bg-emerald-500/10
                    border border-emerald-400/40
                    text-emerald-200 px-3 py-2 text-sm">
          {{ session('success') }}
        </div>
      @endif

      {{-- ERROR --}}
      @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-500/10
                    border border-red-400/40
                    text-red-200 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      {{-- FORM --}}
      <form method="POST" action="{{ route('register') }}" class="mt-5 space-y-4">
        @csrf

        {{-- NAMA --}}
        <div>
          <label class="text-xs text-white/80">Nama Lengkap</label>
          <input name="name" value="{{ old('name') }}" required
            class="mt-1 w-full rounded-md px-3 py-3 text-sm
                   bg-white/95 text-[#2b180d]
                   border border-white/10
                   focus:ring-2 focus:ring-[#004AAD]
                   shadow-inner outline-none">
        </div>

        {{-- EMAIL --}}
        <div>
          <label class="text-xs text-white/80">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="mt-1 w-full rounded-md px-3 py-3 text-sm
                   bg-white/95 text-[#2b180d]
                   border border-white/10
                   focus:ring-2 focus:ring-[#004AAD]
                   shadow-inner outline-none">
        </div>

        {{-- PASSWORD --}}
        <div class="relative">
          <label class="text-xs text-white/80">Kata Sandi</label>
          <input id="password" type="password" name="password" required
            class="mt-1 w-full rounded-md px-3 py-3 pr-10 text-sm
                   bg-white/95 text-[#2b180d]
                   border border-white/10
                   focus:ring-2 focus:ring-[#004AAD]
                   shadow-inner outline-none">

              <button
              type="button"
              aria-label="Show password"
              class="absolute right-3 top-[36px]
                    active:scale-95 transition"
              onmousedown="showPassword('password')"
              onmouseup="hidePassword('password')"
              onmouseleave="hidePassword('password')"
              ontouchstart="showPassword('password')"
              ontouchend="hidePassword('password')"
            >
              <img
                src="{{ asset('images/icons/show.png') }}"
                alt="Show password"
                class="w-5 h-5 opacity-70 hover:opacity-100">
            </button>

        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="relative">
          <label class="text-xs text-white/80">Konfirmasi Kata Sandi</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required
            class="mt-1 w-full rounded-md px-3 py-3 pr-10 text-sm
                   bg-white/95 text-[#2b180d]
                   border border-white/10
                   focus:ring-2 focus:ring-[#004AAD]
                   shadow-inner outline-none">

                <button
          type="button"
          aria-label="Show confirm password"
          class="absolute right-3 top-[36px]
                active:scale-95 transition"
          onmousedown="showPassword('password_confirmation')"
          onmouseup="hidePassword('password_confirmation')"
          onmouseleave="hidePassword('password_confirmation')"
          ontouchstart="showPassword('password_confirmation')"
          ontouchend="hidePassword('password_confirmation')"
        >
          <img
            src="{{ asset('images/icons/show.png') }}"
            alt="Show password"
            class="w-5 h-5 opacity-70 hover:opacity-100">
        </button>


        {{-- ACTION --}}
        <div class="flex items-center justify-between pt-3">
          <p class="text-xs text-white/80">
            Sudah punya akun?
            <a href="{{ route('login') }}"
            class="text-[#F8C16A] hover:text-[#FFD27D] transition underline">
            Login
          </a>

          </p>

          <button type="submit"
            class="px-6 py-2.5 rounded-full font-semibold text-white
                   bg-[#1D4ED8]
                   hover:bg-[#1E40AF]
                   shadow-[0_8px_25px_rgba(0,0,0,0.45)]
                   active:scale-[0.97]
                   transition-all">
            DAFTAR
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- SCRIPT SHOW / HIDE PASSWORD (HOLD) --}}
  <script>
    function showPassword(id) {
      const input = document.getElementById(id);
      if (input) input.type = 'text';
    }

    function hidePassword(id) {
      const input = document.getElementById(id);
      if (input) input.type = 'password';
    }
  </script>
</x-layouts.base>
