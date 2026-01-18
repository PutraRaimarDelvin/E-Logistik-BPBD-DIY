{{-- resources/views/Pages/dashboard.blade.php --}}
<x-layouts.dashboard-shell :title="'History Laporan | E-Logistik'" active="history">

  {{-- Background abu-abu lembut --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%);"></div>

  {{-- Heading --}}
  <div class="mb-5 text-center">
    <h2 class="text-[35px] font-bold italic text-[#111827] leading-tight">
      Selamat Datang, {{ auth()->user()->name ?? 'User' }} 👋
    </h2>
    <h1 class="text-[30px] font-bold text-[#111827] mt-1">History Laporan</h1>
    <p class="text-sm text-[#4B5563] mt-1">Daftar laporan bencana yang telah di laporkan</p>
  </div>

  {{-- Card tabel --}}
  <div class="mx-auto max-w-5xl rounded-xl overflow-hidden ring-1 ring-white/10
              bg-[#F3F4F6]/80 backdrop-blur shadow-[0_18px_45px_rgba(15,23,42,0.18)]">

    {{-- Header kolom --}}
    <div class="grid grid-cols-[200px_1fr_150px_110px] text-[13px] font-semibold text-white bg-[#1E40AF] px-4 py-2">
      <div>Tanggal Kejadian</div>
      <div>Alamat Kejadian</div>
      <div class="text-center">Bencana</div>
      <div class="text-center">Aksi</div>
    </div>

    {{-- Rows --}}
    <div class="divide-y divide-[#E5E7EB]">
      @forelse ($laporans as $laporan)
        <div class="grid grid-cols-[200px_1fr_150px_110px] items-center px-4 py-3
                    bg-[#F9FAFB] odd:bg-[#FEF5EA] hover:bg-[#FDEFD9] transition">

          {{-- Tanggal Kejadian --}}
          <div class="text-[13px] text-[#111827]">
            {{ optional($laporan->created_at)->format('d M Y, H:i') }}
          </div>

          {{-- Alamat Kejadian (ringkas) --}}
          <div class="text-[13px] text-[#374151]">
            {{ trim(implode(', ', array_filter([
                $laporan->kampung_lingkungan,
                ($laporan->rt || $laporan->rw) ? 'RT '.$laporan->rt.'/RW '.$laporan->rw : null,
                $laporan->kelurahan,
                $laporan->kecamatan,
                $laporan->kabupaten,
            ]))) }}
          </div>

          {{-- Jenis Bencana (gradasi seperti tombol Tambah Baris) --}}
          <div class="flex justify-center">
            <span class="inline-flex px-4 py-1 rounded-full text-xs font-semibold text-[#3d2a1d] shadow-sm"
                  style="background: linear-gradient(90deg,#F8C16A 0%,#F39C3D 55%,#E3852F 100%);">
              {{ $laporan->tujuan ?? '-' }}
            </span>
          </div>

          {{-- Action --}}
          <div class="flex items-center justify-center gap-2">
            {{-- Lihat --}}
            <a href="{{ route('laporan.show', $laporan->id) }}"
               class="inline-flex items-center justify-center px-3 py-1.5 text-[11px] font-medium
                      rounded-full bg-[#e0e7ff] text-[#1E3A8A] hover:bg-[#d4ddff] transition">
              Lihat
            </a>

            {{-- Edit --}}
            <a href="{{ route('laporan.edit', $laporan->id) }}"
               class="inline-flex items-center justify-center px-3 py-1.5 text-[11px] font-medium
                      rounded-full bg-[#FACC15]/90 text-[#92400E] hover:bg-[#FBBF24] transition">
              Edit
            </a>
          </div>
        </div>
      @empty
        <div class="px-4 py-6 text-center text-sm text-[#6B7280] bg-[#F9FAFB]">
          Belum ada laporan yang tersimpan.
        </div>
      @endforelse
    </div>

    {{-- Pagination (kalau pakai paginate) --}}
    @if (method_exists($laporans, 'hasPages') && $laporans->hasPages())
      <div class="px-4 py-3 bg-[#F3F4F6] border-t border-[#E5E7EB]">
        {{ $laporans->links() }}
      </div>
    @endif
  </div>

</x-layouts.dashboard-shell>
