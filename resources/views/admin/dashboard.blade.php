<x-layouts.admin-shell :title="'Dashboard | E-Logistik Admin'" active="dashboard">

  {{-- ================= BACKGROUND ================= --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%)">
  </div>

  <div class="max-w-6xl mx-auto mt-4 space-y-8">

    {{-- ================= CARD RINGKASAN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- LEFT CARD --}}
      <div class="rounded-2xl bg-gradient-to-r from-[#003366] via-[#0055A5] to-[#003366]
                  shadow-[0_18px_40px_rgba(0,0,0,0.25)] p-5 text-white">

        <h2 class="text-sm font-semibold mb-4">Ringkasan Laporan</h2>

        <div class="flex items-center justify-between bg-white/10 rounded-xl px-4 py-3 mb-4">
          <span class="text-sm">Total Laporan</span>
          <span class="text-xl font-bold">{{ $totalLaporan }}</span>
        </div>

        <div class="grid grid-cols-3 gap-3 text-center text-sm">
          <div class="rounded-xl bg-yellow-400 text-black py-3 shadow-md">
            <p class="font-medium">Menunggu</p>
            <p class="text-xl font-bold">{{ $totalMenunggu }}</p>
          </div>
          <div class="rounded-xl bg-green-500 py-3 shadow-md">
            <p class="font-medium">Disetujui</p>
            <p class="text-xl font-bold">{{ $totalDisetujui }}</p>
          </div>
          <div class="rounded-xl bg-red-500 py-3 shadow-md">
            <p class="font-medium">Ditolak</p>
            <p class="text-xl font-bold">{{ $totalDitolak }}</p>
          </div>
        </div>
      </div>

      {{-- RIGHT CARD --}}
      <div class="rounded-2xl bg-gradient-to-r from-[#003366] via-[#0055A5] to-[#003366]
                  shadow-[0_18px_40px_rgba(0,0,0,0.25)]
                  p-5 text-white flex flex-col items-center justify-center">

        <div class="w-12 h-12 rounded-full bg-[#F8B84E]
                    flex items-center justify-center shadow-md mb-3">
          <i class="fa-solid fa-users text-black text-lg"></i>
        </div>

        <p class="text-sm text-center">Total User Pernah Melapor</p>
        <p class="text-4xl font-bold mt-2">{{ $totalUserMelapor }}</p>
        <p class="text-xs text-white/70 mt-1">Berdasarkan seluruh laporan masuk</p>
      </div>
    </div>

    {{-- ================= CARD GRAFIK ================= --}}
    <div class="bg-white rounded-2xl shadow-lg p-6">

      {{-- JUDUL + FILTER --}}
      <div class="flex items-start justify-between mb-4">
        <div>
          <h2 class="text-lg font-semibold text-[#111827]">
            Grafik Laporan Bulanan per Kabupaten (DIY)
          </h2>
          <p class="text-sm text-gray-500">
            Data laporan berdasarkan bulan dan wilayah
          </p>
        </div>

        {{-- FILTER TAHUN --}}
        <form method="GET">
          <select name="year"
            onchange="this.form.submit()"
            class="px-3 py-1.5 rounded-lg border border-gray-300
                   text-sm shadow-sm focus:ring-2 focus:ring-orange-400">
            @foreach($years as $y)
              <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                {{ $y }}
              </option>
            @endforeach
          </select>
        </form>
      </div>

      {{-- CANVAS --}}
      <div class="relative h-[280px]">
        <canvas id="laporanChart"></canvas>
      </div>
    </div>

  </div>

  {{-- ================= CHART JS ================= --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('laporanChart');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($months),
        datasets: [
          @foreach($chartData as $kab => $values)
          {
            label: '{{ $kab }}',
            data: @json($values),
            stack: 'laporan'
          },
          @endforeach
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom' },
          tooltip: {
            callbacks: {
              label: ctx => ctx.dataset.label + ': ' + ctx.raw + '%'
            }
          }
        },
        scales: {
          x: { stacked: true },
          y: {
            stacked: true,
            max: 100,
            ticks: {
              callback: val => val + '%'
            }
          }
        }
      }
    });
  </script>

</x-layouts.admin-shell>
