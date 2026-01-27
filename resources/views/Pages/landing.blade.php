{{-- resources/views/Pages/landing.blade.php --}}
<x-layouts.base :title="'BPBD DIY | E–Logistik Pelaporan'">

{{-- overflow-x-hidden dipindahkan ke body wrapper utama untuk mencegah scroll horizontal akibat gambar yang besar --}}
<div class="min-h-screen flex flex-col bg-[#F7F4EE] text-[#3d2a1d] overflow-x-hidden">

  {{-- ================= NAVBAR (JANGAN DIUBAH) ================= --}}
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-[#eadfcf] shadow-sm">
    <div class="mx-auto max-w-6xl h-20 px-6 flex items-center justify-between">

      <div class="flex items-center gap-4">
        <img src="{{ asset('images/icons/logo-bpbd.png') }}"
             class="w-12 h-12 rounded-full" alt="BPBD DIY">
        <span class="font-bold tracking-wide text-[17px] text-[#3d2a1d]">
          BPBD DIY |
          <span class="text-[#9b6a3a] font-semibold">E–Logistik Pelaporan</span>
        </span>
      </div>

      <nav class="flex items-center gap-3">
        @if (Route::has('register'))
          <a href="{{ route('register') }}"
       class="px-5 py-2.5 rounded-full font-semibold
       text-black
       bg-white
       border border-[#F8C16A]
       shadow-[0_6px_14px_rgba(0,0,0,0.15)]
       transition-all duration-300
       hover:text-white
       hover:bg-gradient-to-r
       hover:from-[#F8C16A]
       hover:to-[#F39C3D]
       hover:shadow-[0_8px_18px_rgba(0,0,0,0.25)]
       hover:-translate-y-0.5">



            Sign Up
          </a>
        @endif

        @php $loginUrl = Route::has('login') ? route('login') : url('/login'); @endphp
        <a href="{{ $loginUrl }}"
           class="px-5 py-2.5 rounded-full font-semibold
       text-black
       bg-gradient-to-r from-[#F8C16A] to-[#F39C3D]
       shadow-[0_6px_14px_rgba(0,0,0,0.18)]
       hover:shadow-[0_8px_18px_rgba(0,0,0,0.25)]
       hover:-translate-y-0.5
       transition-all duration-300">
          Sign In

        </a>
      </nav>
    </div>
  </header>

  {{-- ================= HERO SECTION (PERBAIKAN TOTAL) ================= --}}
  {{--
      PERHATIAN:
      1.  Tinggi section ditetapkan h-[450px].
      2.  PASTIKAN TIDAK ADA 'overflow-hidden' di section ini atau anak-anaknya.
      3.  Z-index diatur ke 30 agar berada di atas section fitur (yang nanti z-20).
  --}}
  <section
    class="relative bg-gradient-to-br from-[#6f3f1d] via-[#7b4a24] to-[#5c3316]
           h-[400px] flex items-center z-30">

    {{-- BACKGROUND PETA --}}
    {{-- HAPUS class 'overflow-hidden' dari div ini jika sebelumnya ada --}}
    <div class="absolute inset-0">
      <div class="absolute inset-0 bg-black/30"></div>
     <img src="{{ asset('images/icons/peta.png') }}"
     class="absolute right-0 top-0
            w-[93%] h-[93%]
            object-cover
            translate-x-[-14%]
            translate-y-[5%]
            opacity-30 mix-blend-multiply">

    </div>

    {{-- CONTENT TEKS --}}
<div class="relative z-10 max-w-7xl mx-auto px-10 h-full flex items-center justify-center">
      <div class="max-w-lg lg:max-w-xl text-white
            mt-10 md:mt-0
            text-center
            translate-x-[-40%]">
{{-- Sedikit margin top di mobile --}}
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
          Sistem Pelaporan<br>
          <span
          class="font-extrabold
                bg-gradient-to-br
                from-[rgb(200,110,0)]
                via-[rgb(230,145,40)]
                to-[rgb(190,90,10)]
                bg-clip-text text-transparent">
          Logistik BPBD DIY
        </span>


        </h1>

        <p class="text-white/90 text-lg leading-relaxed mb-10 md:pr-10">
          SALAM TANGGUH - SALAM SIAGA - SIAP UNTUK SELAMAT.
        </p>

       <a href="{{ $loginUrl }}"
   class="inline-flex items-center gap-3
          px-10 py-4 rounded-full font-bold
          bg-gradient-to-br
          from-[rgb(200,110,0)]
          via-[rgb(230,145,40)]
          to-[rgb(190,90,10)]
          text-black/80
          hover:text-white
          shadow-[0_14px_35px_rgba(190,90,10,0.45)]
          hover:-translate-y-1
          transition-all duration-300">
  Mulai Lapor
</a>



      </div>
    </div>

    {{--
        GAMBAR TANGAN (PERBAIKAN UTAMA):
        1. z-40: Agar paling depan.
        2. h-[800px] lg:h-[1000px]: Ukuran sangat besar.
        3. translate-x/y: Mendorong gambar ke kanan bawah hingga keluar area coklat.
        4. max-w-none: Mencegah gambar mengecil otomatis.
    --}}
<div class="absolute bottom-0 right-0 z-40
            h-[480px] lg:h-[580px]
            w-auto max-w-none
            translate-x-[-3%]
            translate-y-[8%]
            pointer-events-none select-none">

  <!-- SHADOW LAYER -->
  <div class="absolute inset-0
              bg-black/40
              blur-[55px]
              scale-[0.85]
              translate-y-[35px]
              animate-shadow-soft">
  </div>

  <!-- IMAGE -->
  <img src="{{ asset('images/icons/bencana1.png') }}"
       class="relative z-10 h-full w-auto
              animate-float-soft"
       alt="Ilustrasi Pelaporan BPBD">
</div>

  </section>

  {{-- ================= FITUR SECTION ================= --}}
  {{--
      PERHATIAN:
      1. z-20: Agar layer ini berada DI BAWAH gambar tangan (yang z-40).
      2. pt-56 lg:pt-64: Padding top yang BESAAR agar teks judul tidak tertutup oleh gambar tangan yang menggantung.
  --}}
<section class="bg-white shadow-inner relative z-20
               pt-8 lg:pt-10 pb-16 -mt-8">
    <div class="mx-auto max-w-6xl px-6">

      <h2 class="text-center tracking-[.15em] font-semibold
           text-[#6B5140] mb-12 mt-3 relative z-10">
      ALUR PELAPORAN BENCANA
      </h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10 -mt-6">
        @foreach ([
          ['new.png','Pengajuan Laporan & Logistik','Pelaporan bencana dan permohonan logistik secara terintegrasi.'],
          ['waktu.png','Monitoring Status Laporan','Pemantauan progres penanganan laporan bencana.'],
          ['deliver.png','Distribusi & Serah Terima Logistik','Pencatatan penyaluran dan serah terima bantuan logistik.']
        ] as $f)

       <div
  class="rounded-xl bg-white p-6
         border border-[#E5DBC9]/60
         shadow-[0_6px_18px_-8px_rgba(0,0,0,0.25)]
         hover:shadow-[0_12px_36px_-6px_rgba(247,154,30,0.55)]
         hover:-translate-y-1.5
         transition-all duration-300 group">



        <div class="mx-auto mb-4 flex items-center justify-center
            group-hover:scale-110 transition-transform">
              <img src="{{ asset('images/icons/'.$f[0]) }}" class="w-10 h-10">
          </div>

          <h3 class="text-center font-bold text-lg text-[#3d2a1d] mb-3">
            {{ $f[1] }}
          </h3>

          <p class="text-center text-[#8A7A6A] leading-relaxed">
            {{ $f[2] }}
          </p>
        </div>

        @endforeach
      </div>
    </div>
  </section>

</div>
<style>
@keyframes float-soft {
  0%,100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-14px);
  }
}

@keyframes shadow-soft {
  0%,100% {
    transform: translateY(35px) scale(0.85);
    opacity: 0.35;
  }
  50% {
    transform: translateY(45px) scale(0.75);
    opacity: 0.25;
  }
}

.animate-float-soft {
  animation: float-soft 10s ease-in-out infinite;
}

.animate-shadow-soft {
  animation: shadow-soft 10s ease-in-out infinite;
}
</style>


</x-layouts.base>
