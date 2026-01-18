<x-layouts.base :title="'Login | E-Logistik BPBD DIY'">
  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw] bg-[#5a3924]/90 backdrop-blur-sm rounded-2xl shadow-2xl ring-1 ring-black/20 p-8">
      
      {{-- Header --}}
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/icons/logo-bpbd.png') }}"
               class="w-12 h-12 rounded-full object-contain" alt="BPBD DIY">
          <h2 class="text-white/90 text-lg font-semibold">Login BPBD Logistik</h2>
        </div>

        {{-- Tampilkan SIGN IN saja --}}
        <div class="flex items-center gap-4 text-sm">
          <span class="text-white font-semibold border-b border-white pb-[2px]">SIGN IN</span>
        </div>
      </div>

      {{-- Error --}}
      @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 text-red-200 border border-red-400/40 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      {{-- FORM LOGIN --}}
      <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
          <label class="text-xs text-white/70">Email</label>
          <input name="email" type="email" required
                 class="mt-1 w-full bg-white/95 border border-white/10 rounded-md px-3 py-3 text-sm text-[#2b180d]" />
        </div>

        {{-- Password --}}
        <div>
          <label class="text-xs text-white/70">Password</label>
          <input name="password" type="password" required
                 class="mt-1 w-full bg-white/95 border border-white/10 rounded-md px-3 py-3 text-sm text-[#2b180d]" />
        </div>

        {{-- Lupa Password --}}
<div class="flex justify-end">
  <a href="{{ route('password.request') }}"
     class="text-xs text-[#F8C16A] hover:text-[#F39C3D] transition underline">
      Lupa password?
  </a>
</div>

        <button class="w-full bg-[#004AAD] text-white font-semibold py-3 rounded-full hover:bg-[#003A91] transition">
          LOGIN
        </button>

        {{-- Sign Up tetap di bawah --}}
        <p class="text-center text-[13px] text-white/70">
          Belum punya akun?
          <a href="{{ route('register') }}" class="text-[#F8C16A] hover:text-[#F39C3D] font-semibold">
            Sign Up di sini
          </a>
        </p>
      </form>

      {{-- Divider --}}
      <div class="my-6 h-px bg-white/10"></div>

      {{-- Google Login --}}
      <a href="{{ route('google.redirect') }}"
         class="w-full inline-flex justify-center items-center gap-2 border border-white/20 hover:bg-white/10
                rounded-md py-2 text-sm text-white/90 transition">
        Login dengan Google
      </a>

    </div>
  </div>
</x-layouts.base>
