<x-layouts.base :title="'Verifikasi OTP | E-Logistik BPBD DIY'">

  <div class="min-h-screen flex items-center justify-center
              bg-gradient-to-br from-[rgb(200,110,0)]
              via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[420px] max-w-[92vw]
                bg-[#5a3924]/90 backdrop-blur-md
                rounded-2xl
                shadow-[0_30px_90px_rgba(0,0,0,0.65)]
                ring-1 ring-white/10
                p-8 text-white">

      {{-- TITLE --}}
      <h2 class="text-lg font-semibold text-center">
        Verifikasi OTP
      </h2>

      <p class="mt-2 text-sm text-white/80 text-center">
        Kami telah mengirimkan kode OTP ke email:<br>
        <strong>{{ session('otp_email') }}</strong><br>
        Masukkan 6 digit kode OTP di bawah ini.
      </p>

      {{-- ERROR --}}
      @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-500/10 text-red-200
                    border border-red-400/40 px-3 py-2 text-sm">
          @foreach ($errors->all() as $err)
            <div>• {{ $err }}</div>
          @endforeach
        </div>
      @endif

      {{-- FORM OTP --}}
      <form method="POST" action="{{ route('otp.verify') }}" class="mt-4">
        @csrf

        <input type="hidden" name="email" value="{{ session('otp_email') }}">
        <input type="hidden" name="otp" id="otp-hidden" required>

        {{-- OTP 6 BOX --}}
        <label class="text-xs text-white/80">Kode OTP</label>
        <div class="mt-2 flex justify-center gap-2">
          @for ($i = 0; $i < 6; $i++)
            <input type="text"
                   inputmode="numeric"
                   maxlength="1"
                   class="otp-box w-11 h-12 rounded-md
                          text-center text-lg font-semibold
                          bg-white/95 text-[#2b180d]
                          border border-white/10
                          focus:ring-2 focus:ring-amber-400
                          outline-none">
          @endfor
        </div>

        {{-- TIMER --}}
        <p id="otp-timer"
           class="mt-3 text-xs text-center text-white/80">
          Kode OTP berlaku selama <strong>02:00</strong>
        </p>

        {{-- BUTTON VERIFY --}}
        <button type="submit"
                class="w-[320px] mx-auto block mt-4
                       py-3 rounded-full font-semibold tracking-wide text-white
                       bg-[#1D4ED8]
                       shadow-[0_10px_30px_rgba(0,0,0,0.45)]
                       hover:bg-[#1E40AF]
                       hover:shadow-[0_16px_45px_rgba(0,0,0,0.6)]
                       active:scale-[0.98]
                       transition-all duration-300">
          Verify
        </button>
      </form>

      {{-- RESEND OTP --}}
      <div class="mt-4 flex items-center justify-center gap-1
                  text-xs text-white/80">
        <span>Tidak menerima OTP?</span>

        <form method="POST" action="{{ route('otp.resend') }}" class="inline">
          @csrf
          <input type="hidden" name="email" value="{{ session('otp_email') }}">
          <button type="submit"
                  class="text-[#F8C16A] hover:underline font-medium">
            Kirim ulang kode OTP
          </button>
        </form>
      </div>

    </div>
  </div>

  {{-- ================= JAVASCRIPT ================= --}}
  <script>
    /* ===== OTP INPUT (6 BOX) ===== */
    const inputs = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('otp-hidden');

    inputs.forEach((input, index) => {
      input.addEventListener('input', () => {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
        updateOtpValue();
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });

    function updateOtpValue() {
      hiddenInput.value =
        Array.from(inputs).map(i => i.value).join('');
    }

    /* ===== OTP COUNTDOWN (2 MENIT) ===== */
    const expiresAt = {{ $expiresAt ?? 0 }};
    const timerEl = document.getElementById('otp-timer');
    const verifyBtn = document.querySelector('button[type="submit"]');

    if (expiresAt > 0) {
      const timerInterval = setInterval(() => {
        const now = Date.now();
        const diff = expiresAt - now;

        // OTP EXPIRED
        if (diff <= 0) {
          clearInterval(timerInterval);
          timerEl.innerHTML =
            '<span class="text-red-300 font-semibold">Kode OTP telah kedaluwarsa</span>';
          verifyBtn.disabled = true;
          verifyBtn.classList.add('opacity-50', 'cursor-not-allowed');
          return;
        }

        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);

        timerEl.innerHTML =
          `Kode OTP berlaku selama <strong>${
            String(minutes).padStart(2,'0')
          }:${String(seconds).padStart(2,'0')}</strong>`;
      }, 1000);
    }
  </script>

</x-layouts.base>
