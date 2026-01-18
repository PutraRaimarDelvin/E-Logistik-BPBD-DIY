<x-layouts.base :title="'Reset Password | E-Logistik BPBD DIY'">

  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw] bg-[#5a3924]/90 backdrop-blur-sm
                rounded-2xl shadow-2xl ring-1 ring-black/20 p-8">

      <h2 class="text-white/90 text-lg font-semibold mb-6">
        Reset Password
      </h2>

      {{-- Error --}}
      @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-500/10 text-red-200
                    border border-red-400/40 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email --}}
        <div>
          <label class="text-xs text-white/70">Email</label>
          <input type="email" name="email" value="{{ $email ?? old('email') }}" required
                 class="mt-1 w-full bg-white/95 border border-white/10
                        rounded-md px-3 py-3 text-sm text-[#2b180d]" />
        </div>

        {{-- Password --}}
        <div>
          <label class="text-xs text-white/70">Password Baru</label>
          <input type="password" name="password" required
                 class="mt-1 w-full bg-white/95 border border-white/10
                        rounded-md px-3 py-3 text-sm text-[#2b180d]" />
        </div>

        {{-- Confirm Password --}}
        <div>
          <label class="text-xs text-white/70">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" required
                 class="mt-1 w-full bg-white/95 border border-white/10
                        rounded-md px-3 py-3 text-sm text-[#2b180d]" />
        </div>

        <button
          class="w-full bg-[#004AAD] text-white font-semibold py-3
                 rounded-full hover:bg-[#003A91] transition">
          Reset Password
        </button>
      </form>

    </div>
  </div>

</x-layouts.base>
