<x-layouts.admin-shell :title="'Manajemen User | E-Logistik Admin'" active="users">

  {{-- Background lembut --}}
  <div class="absolute inset-0 -z-10"
       style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%)"></div>

  <div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">
   {{-- Judul --}}
<div class="mx-auto max-w-6xl mt-3 text-center">
  <h1 class="text-2xl font-bold italic text-[#111827]">
    Manajemen User
  </h1>
  <p class="text-sm text-[#4B5563] text-left">
    Daftar pengguna dan status akses sistem
  </p>
</div>

    {{-- CARD TABLE --}}
    <div class="mx-auto mt-4 max-w-6xl overflow-hidden rounded-2xl shadow-[0_18px_40px_rgba(0,0,0,0.16)]">

      {{-- HEADER --}}
      <div class="grid grid-cols-[1.2fr_1.5fr_1fr_1fr] px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white
                  bg-gradient-to-r from-[#003366] via-[#0055A5] to-[#003366]">
        <div>Nama</div>
        <div>Email</div>
        <div>Status</div>
        <div class="text-center">Aksi</div>
      </div>

      {{-- ================== TAMBAHAN START ================== --}}
      {{-- wrapper scroll khusus ISI USER --}}
      <div class="max-h-[360px] overflow-y-auto">
      {{-- ================== TAMBAHAN END ==================== --}}

      {{-- ISI --}}
      @forelse ($users as $user)
        <div class="grid grid-cols-[1.2fr_1.5fr_1fr_1fr] px-4 py-2.5 text-sm leading-snug 
                    bg-white hover:bg-[#D8E9FF] transition-colors border-b border-[#e5e7eb]">

          {{-- Nama --}}
          <div class="text-[#111827] font-medium">{{ $user->name }}</div>

          {{-- Email --}}
          <div class="text-[#374151]">{{ $user->email }}</div>

          {{-- Status --}}
          <div>
            @if ($user->is_admin)
              <span class="inline-flex items-center justify-center rounded-full 
                           bg-gradient-to-r from-[#34D399] to-[#059669]
                           px-4 py-1 text-xs font-semibold text-black shadow-md">
                Admin
              </span>
            @else
              <span class="inline-flex items-center justify-center rounded-full 
                           bg-gradient-to-r from-[#F8B84E] to-[#F39C3D]
                           px-4 py-1 text-xs font-semibold text-black shadow-md">
                User Biasa
              </span>
            @endif
          </div>

          {{-- Aksi --}}
          <div class="flex items-center justify-center">
            <form id="toggle-form-{{ $user->id }}" 
                  action="{{ route('admin.users.toggleAdmin', $user->id) }}" 
                  method="POST">
              @csrf
              @if ($user->is_admin)
                <button type="button"
                        class="btn-toggle text-red-600 hover:text-red-800 font-semibold text-sm transition"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-action="turunkan">
                  Turunkan
                </button>
              @else
                <button type="button"
                        class="btn-toggle text-[#E74C3C] hover:text-[#003366] font-semibold text-sm transition"
                        data-id="{{ $user->id }}"
                        data-name="{{ $user->name }}"
                        data-action="jadikan">
                  Jadikan Admin
                </button>
              @endif
            </form>
          </div>
        </div>
      @empty
        <div class="px-4 py-6 text-center text-sm text-[#6B7280] bg-white">
          Belum ada data pengguna.
        </div>
      @endforelse

      {{-- ================== TAMBAHAN START ================== --}}
      </div>
      {{-- ================== TAMBAHAN END ==================== --}}

    </div>
  </div>

  {{-- SweetAlert --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".btn-toggle").forEach((btn) => {
      btn.addEventListener("click", function () {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const action = this.dataset.action;

        let title = "";
        let confirmBtn = "";
        let icon = "";

        if (action === "jadikan") {
          title = `Jadikan <b>${name}</b> sebagai Admin?`;
          confirmBtn = "Ya, Jadikan Admin";
          icon = "question";
        } else {
          title = `Turunkan <b>${name}</b> menjadi User Biasa?`;
          confirmBtn = "Ya, Turunkan";
          icon = "warning";
        }

        Swal.fire({
          title: title,
          html: "Tindakan ini akan mengubah hak akses pengguna.",
          icon: icon,
          showCancelButton: true,
          confirmButtonText: confirmBtn,
          cancelButtonText: "Batal",
          reverseButtons: true,
          background: "#fffaf4",
          color: "#1F2937",
          confirmButtonColor: action === "jadikan" ? "#0055A5" : "#D92D20",
          cancelButtonColor: "#9CA3AF",
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById(`toggle-form-${id}`).submit();
          }
        });
      });
    });
  });
  </script>

</x-layouts.admin-shell>
