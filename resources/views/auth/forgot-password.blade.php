<x-layouts.base :title="'Lupa Password | E-Logistik BPBD DIY'">

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br from-[rgb(200,110,0)]
            via-[rgb(230,145,40)] to-[rgb(190,90,10)] p-4">

    <div class="w-[520px] max-w-[95vw] bg-[#5a3924]/90 backdrop-blur-sm
                rounded-2xl shadow-2xl ring-1 ring-black/20 p-8">

        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ asset('images/icons/logo-bpbd.png') }}"
                 class="w-12 h-12 rounded-full object-contain">
            <h2 class="text-white/90 text-lg font-semibold">
                Lupa Password
            </h2>
        </div>

        <p class="text-sm text-white/70 mb-4">
            Masukkan email yang terdaftar. Kami akan mengirimkan link reset
            password ke email Anda.
        </p>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-500/10 text-red-200
                        border border-red-400/40 px-3 py-2 text-sm">
                @foreach ($errors->all() as $err)
                    <div>• {{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="text-xs text-white/70">Email</label>
                <input type="email" name="email" required
                       class="mt-1 w-full bg-white/95 border border-white/10
                              rounded-md px-3 py-3 text-sm text-[#2b180d]"
                       placeholder="contoh@email.com">
            </div>

            <button
                class="w-full bg-[#004AAD] text-white font-semibold py-3
                       rounded-full hover:bg-[#003A91] transition">
                Kirim Link Reset
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}"
               class="text-xs text-[#F8C16A] hover:text-[#F39C3D] underline">
                Kembali ke Login
            </a>
        </div>

    </div>
</div>

{{-- SWEETALERT POPUP --}}
@if (session('status'))
@push('scripts')
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Reset password berhasil dikirim ke email Anda.',
        confirmButtonColor: '#004AAD'
    });
</script>
@endpush
@endif

</x-layouts.base>
