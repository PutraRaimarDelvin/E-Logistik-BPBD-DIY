<x-layouts.base :title="'Login | E-Logistik BPBD DIY'">
  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

<div class="w-[520px] max-w-[95vw]
            bg-[#5a3924]/90 backdrop-blur-md
            rounded-2xl
            shadow-[0_30px_90px_rgba(0,0,0,0.65)]
            ring-1 ring-white/10
            p-8">

      
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
        <div class="relative">
  <label class="text-xs text-white/70">Password</label>

  <input
    id="password"
    name="password"
    type="password"
    required
    autocomplete="current-password"
    class="mt-1 w-full bg-white/95 border border-white/10
           rounded-md px-3 py-3 pr-11
           text-sm text-[#2b180d]" />

  <!-- ICON MATA (CUSTOM, HOLD) -->
  <button
    type="button"
    aria-label="Show password"
    class="absolute right-3 top-[36px] active:scale-95 transition"
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


        {{-- Lupa Password --}}
        <div class="flex justify-end">
          <a href="{{ route('password.request') }}"
        class="text-xs text-[#F8C16A] hover:text-[#FFD27D] transition underline">
              Lupa password?
          </a>
        </div>
          
        {{-- Button Login --}}
        <button
  class="w-[320px] mx-auto block
         py-3 rounded-full font-semibold tracking-wide text-white
         bg-[#1D4ED8]
         shadow-[0_10px_30px_rgba(0,0,0,0.45)]
         hover:bg-[#1E40AF]
         hover:shadow-[0_16px_45px_rgba(0,0,0,0.6)]
         active:scale-[0.98]
         transition-all duration-300">
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
   class="w-full inline-flex items-center justify-center gap-3
          bg-white text-gray-700
          border border-gray-300
          rounded-xl py-3
          text-sm font-medium
          shadow-sm
          hover:bg-gray-50 hover:shadow-md
          active:scale-[0.99]
          transition-all duration-200">

        {{-- Google Icon --}}
        <svg class="w-5 h-5" viewBox="0 0 48 48">
          <path fill="#EA4335" d="M24 9.5c3.54 0 6.02 1.54 7.41 2.83l5.45-5.45C33.55 3.77 29.17 2 24 2 14.73 2 6.91 7.58 3.69 15.55l6.34 4.92C11.64 14.09 17.34 9.5 24 9.5z"/>
          <path fill="#4285F4" d="M46.5 24.5c0-1.57-.14-2.87-.43-4.21H24v8.01h12.69c-.26 2.1-1.69 5.26-4.87 7.38l7.46 5.78c4.36-4.02 6.92-9.95 6.92-16.96z"/>
          <path fill="#FBBC05" d="M10.03 28.47A14.5 14.5 0 019.25 24c0-1.55.27-3.05.78-4.47l-6.34-4.92A22.01 22.01 0 002 24c0 3.55.86 6.91 2.39 9.89l6.64-5.42z"/>
          <path fill="#34A853" d="M24 46c6.17 0 11.34-2.04 15.12-5.54l-7.46-5.78c-2 1.39-4.69 2.35-7.66 2.35-6.66 0-12.36-4.59-13.97-10.96l-6.64 5.42C6.91 40.42 14.73 46 24 46z"/>
        </svg>

        <span>Sign in with Google</span>
      </a>


    </div>
  </div>

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
