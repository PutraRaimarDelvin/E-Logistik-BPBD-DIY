<x-layouts.dashboard-shell :title="'History Laporan | E-Logistik'" active="history">

    {{-- Background lembut --}}
    <div class="absolute inset-0 -z-10"
         style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%);">
    </div>

    <div class="max-w-6xl mx-auto mt-3 space-y-3">

        {{-- JUDUL --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold italic text-[#111827]">
                Selamat Datang, {{ auth()->user()->name ?? 'User' }} 👋
            </h1>

            <div class="mt-3 text-left">
                <h2 class="text-lg font-semibold text-[#111827]">
                    History Laporan
                </h2>
                <p class="text-sm text-[#4B5563]">
                    Daftar laporan bencana yang telah dilaporkan
                </p>
            </div>
        </div>

        {{-- CARD TABEL --}}
        <div class="mt-2 rounded-2xl border border-[#eadfce] bg-white shadow-[0_18px_40px_rgba(0,0,0,0.16)] overflow-hidden">

            {{-- HEADER (TIDAK SCROLL) --}}
            <div class="grid grid-cols-[0.8fr_1fr_0.6fr_0.5fr_0.4fr]
                px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white
                bg-gradient-to-r from-[#003366] via-[#0055A5] to-[#003366]">

                <div class="text-center">Tanggal</div>
                <div class="text-center">Alamat</div>
                <div class="text-center">Bencana</div>
                <div class="text-center">Status</div>
                <div class="text-center">Aksi</div>
            </div>

            {{-- ISI TABEL (SCROLL) --}}
            <div class="max-h-[420px] overflow-y-auto">

                @forelse($laporans as $laporan)
                <div class="grid grid-cols-[0.8fr_1fr_0.6fr_0.5fr_0.4fr]
                    px-4 py-2.5 text-sm
                    {{ $loop->odd ? 'bg-white' : 'bg-[#F9FAFB]' }}
                    hover:bg-[#D8E9FF] transition border-b">

                    {{-- TANGGAL --}}
                    <div class="flex items-center pl-16 text-[#111827]">
                        {{ $laporan->created_at?->format('d M Y, H:i') ?? '-' }}
                    </div>

                    {{-- ALAMAT --}}
                    <div class="flex items-center pl-6 text-[#374151]">
                        @php
                            $alamat = array_filter([
                                $laporan->rt && $laporan->rw ? 'RT '.$laporan->rt.'/RW '.$laporan->rw : null,
                                $laporan->desa,
                                $laporan->kecamatan,
                                $laporan->kabupaten,
                            ]);
                        @endphp
                        {{ implode(', ', $alamat) }}
                    </div>

                    {{-- BENCANA --}}
                   <div class="flex items-center justify-center">
                        <span class="inline-flex items-center justify-center
                            rounded-full
                            bg-gradient-to-r from-[#F59E0B] to-[#F97316]
                            px-4 py-1.5 text-xs font-semibold text-white
                            shadow-md">
                            {{ $laporan->jenis_bencana ?? '-' }}
                        </span>
                    </div>


                    {{-- STATUS --}}
                    <div class="flex items-center justify-center">
                        @php
                            $warna = match($laporan->status_validasi) {
                                'Menunggu'  => 'bg-yellow-400 text-gray-900',
                                'Disetujui' => 'bg-green-500 text-white',
                                'Ditolak'   => 'bg-red-500 text-white',
                                default     => 'bg-gray-300 text-gray-700',
                            };
                        @endphp

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                            {{ $laporan->status_validasi }}
                        </span>
                    </div>

                    {{-- AKSI --}}
                    <div class="flex items-center justify-center gap-4">

                        {{-- LIHAT --}}
                        <a href="{{ route('laporan.show', $laporan->id) }}"
                           class="text-[#1D4ED8] hover:text-[#0B3EA8] text-lg">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        {{-- EDIT --}}
                        @if($laporan->status_validasi === 'Disetujui')
                            <span class="text-gray-400 cursor-not-allowed text-lg">
                                <i class="fa-solid fa-pen"></i>
                            </span>
                        @else
                            <a href="{{ route('laporan.edit', $laporan->id) }}"
                               class="text-[#EAB308] hover:text-[#CA8A04] text-lg">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        @endif

                        {{-- DELETE --}}
                        <form id="delete-form-{{ $laporan->id }}"
                              action="{{ route('laporan.destroy', $laporan->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    data-id="{{ $laporan->id }}"
                                    class="btn-delete-laporan text-[#DC2626] hover:text-[#B91C1C] text-lg">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </div>
                @empty
                <div class="px-4 py-6 text-center text-sm text-gray-500">
                    Belum ada data laporan.
                </div>
                @endforelse

            </div>
        </div>

       {{-- PAGINATION (BACK & NEXT) --}}
@if($laporans->hasPages())
<div class="mt-4 flex items-center justify-between">

    {{-- BACK --}}
    @if ($laporans->onFirstPage())
        <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            ‹ Back
        </span>
    @else
        <a href="{{ $laporans->previousPageUrl() }}"
           class="px-4 py-2 rounded-lg bg-blue-700 text-white hover:bg-blue-800 transition">
            ‹ Back
        </a>
    @endif

    {{-- NEXT --}}
    @if ($laporans->hasMorePages())
        <a href="{{ $laporans->nextPageUrl() }}"
           class="px-4 py-2 rounded-lg bg-blue-700 text-white hover:bg-blue-800 transition">
            Next ›
        </a>
    @else
        <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            Next ›
        </span>

</div>
@endif


        </div>
        @endif

    </div>

    {{-- SWEETALERT DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-delete-laporan').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;

                    Swal.fire({
                        title: 'Hapus laporan?',
                        text: 'Data tidak bisa dikembalikan',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                    }).then(result => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                });
            });
        });
    </script>



</x-layouts.dashboard-shell>
