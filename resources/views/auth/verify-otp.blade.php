<x-layouts.base :title="'Verifikasi OTP | E-Logistik BPBD DIY'">

  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)] via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[420px] max-w-[95vw] rounded-2xl shadow-2xl ring-1 ring-black/20
                bg-[#5a3924]/90 backdrop-blur-sm p-8 text-white">

      <h2 class="text-lg font-semibold">Verifikasi OTP</h2>

      <p class="mt-1 text-sm text-white/80">
        Kami telah mengirimkan kode OTP ke email:
        <strong>{{ session('otp_email') }}</strong><br>
        Masukkan 6 digit kode OTP di bawah ini.
      </p>

      {{-- Flash Error --}}
      @if (session('error'))
        <div class="mt-4 rounded-md bg-red-500/10 text-red-200 border border-red-400/40 px-3 py-2 text-sm">
          {{ session('error') }}
        </div>
      @endif

      {{-- Validasi --}}
      @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-500/10 text-red-200 border border-red-400/40 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('otp.verify') }}" class="mt-4 space-y-4">
    @csrf

    {{-- Email dari session --}}
    <input type="hidden" name="email" value="{{ session('otp_email') }}">

    <div>
        <label class="text-xs text-white/80">Kode OTP</label>
        <input name="otp" maxlength="6" required
               class="mt-1 w-full rounded-md px-3 py-3 text-center tracking-[0.5em] text-lg text-[#2b180d]
                      bg-white/95 border border-white/10 focus:ring-2 focus:ring-amber-400 shadow-inner outline-none">
    </div>

    <button type="submit"
            class="w-full mt-2 px-5 py-2.5 rounded-full font-semibold text-white shadow-md"
            style="background:#004AAD;">
        VERIFIKASI & MASUK
    </button>
</form>

      {{-- Kirim Ulang OTP --}}
      <div class="mt-4 text-xs text-white/80 text-center">
        <p>Tidak menerima email? Cek folder spam / promosi.</p>

      <form method="POST" action="{{ route('otp.resend') }}" class="mt-1 inline">
          @csrf
          <input type="hidden" name="email" value="{{ session('otp_email') }}">
          <button class="text-[11px] text-blue-200 hover:underline">
            Kirim ulang kode OTP
          </button>
        </form>
      </div>

    </div>
  </div>

</x-layouts.base>
