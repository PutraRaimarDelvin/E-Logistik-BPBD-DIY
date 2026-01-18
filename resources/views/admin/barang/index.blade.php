<x-layouts.admin-shell :title="'Daftar Barang | E-Logistik BPBD DIY'" active="barang">

{{-- BACKGROUND --}}
<div class="absolute inset-0 -z-10"
     style="background: radial-gradient(140% 80% at 10% 10%, #F6EBDD 0%, #F1E3D6 45%, #EBDCCF 100%);">
</div>

<div class="max-h-[calc(100vh-100px)] overflow-y-auto px-6 pb-6">

    {{-- HEADER --}}
    <div class="mx-auto max-w-6xl mt-2">
        <h1 class="text-[26px] font-semibold text-[#1F2937]">Daftar Barang</h1>
        <div class="mt-2 h-[2px] w-full rounded-full"
             style="background: linear-gradient(90deg,#E8D6C6 0%,#E8D6C6 60%, transparent 100%);"></div>
    </div>

    {{-- FORM TAMBAH --}}
    <div class="mx-auto mt-5 max-w-6xl rounded-xl border p-5 shadow"
         style="background:linear-gradient(180deg,#FFFDF8 0%,#FBF3EA 100%);">

        <h2 class="text-lg font-semibold mb-3">Tambah Barang Baru</h2>

        <form action="{{ route('admin.barang.store') }}" method="POST"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <input name="kode_barang" placeholder="Kode Barang" required
                   class="rounded border px-3 py-2">
            <input name="nama_barang" placeholder="Nama Barang" required
                   class="rounded border px-3 py-2">
            <input type="number" name="stok" placeholder="Stok" required
                   class="rounded border px-3 py-2">
            <input name="satuan" placeholder="pcs / kg / liter" required
                   class="rounded border px-3 py-2">

            <div class="md:col-span-4 flex justify-end">
                <button class="px-5 py-2 rounded-full text-white"
                        style="background:linear-gradient(90deg,#F8C16A,#F39C3D)">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL --}}
    <div class="mx-auto mt-6 max-w-6xl rounded-xl border p-5 shadow"
         style="background:linear-gradient(180deg,#FFFDF8 0%,#FBF3EA 100%);">

        <h2 class="text-lg font-semibold mb-3">Data Barang</h2>

        {{-- 🔽 TAMBAHAN: CONTAINER SCROLL --}}
<div class="max-h-[420px] overflow-y-auto rounded-lg border">

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-[#F2E7DA]">
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Kode</th>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Stok</th>
                    <th class="border px-3 py-2">Satuan</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($barang as $i => $b)
            <tr class="hover:bg-[#F7EFE5] transition">

                <td class="border px-3 py-2 text-center">{{ $i+1 }}</td>

                <form action="{{ route('admin.barang.update', $b->id) }}" method="POST" class="contents barang-row">
                    @csrf
                    @method('PUT')

                    <td class="border px-3 py-2">
                        <input name="kode_barang" value="{{ $b->kode_barang }}" readonly
                               class="barang-input w-full bg-gray-100 border rounded px-2 py-1">
                    </td>

                    <td class="border px-3 py-2">
                        <input name="nama_barang" value="{{ $b->nama_barang }}" readonly
                               class="barang-input w-full bg-gray-100 border rounded px-2 py-1">
                    </td>

                    <td class="border px-3 py-2">
                        <input type="number" name="stok" value="{{ $b->stok }}" readonly
                               class="barang-input w-20 bg-gray-100 border rounded px-2 py-1">
                    </td>

                    <td class="border px-3 py-2">
                        <input name="satuan" value="{{ $b->satuan }}" readonly
                               class="barang-input w-20 bg-gray-100 border rounded px-2 py-1">
                    </td>

                    <td class="border px-3 py-2">
                        <div class="flex items-center gap-3 justify-center">

                            <button type="button"
                                    onclick="enableEdit(this)"
                                    class="edit-btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded-md text-xs">
                                Edit
                            </button>

                            <button type="submit"
                                    class="save-btn hidden bg-amber-500 hover:bg-amber-600 text-white px-4 py-1.5 rounded-md text-xs">
                                Simpan
                            </button>

                            <button type="button"
                                    onclick="hapusBarang({{ $b->id }}, this)"
                                    class="text-purple-600 hover:text-purple-800 text-xl font-bold">
                                ✕
                            </button>

                        </div>
                    </td>
                </form>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function enableEdit(btn) {
    const row = btn.closest('tr');

    row.querySelectorAll('.barang-input').forEach(i => {
        i.removeAttribute('readonly');
        i.classList.remove('bg-gray-100');
        i.classList.add('bg-white');
    });

    row.querySelector('.edit-btn').classList.add('hidden');
    row.querySelector('.save-btn').classList.remove('hidden');
}

function hapusBarang(id, btn) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data barang ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {

            fetch(`/admin/barang/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.closest('tr').remove();
                    Swal.fire('Berhasil!', data.message, 'success');
                }
            })
            .catch(() => {
                Swal.fire('Gagal!', 'Terjadi kesalahan', 'error');
            });
        }
    });
}
</script>

</x-layouts.admin-shell>
