<x-layouts.admin-shell :title="'Pengaturan Profil Admin | E-Logistik'" active="profile">

    {{-- Background --}}
    <div class="absolute inset-0 -z-10"
         style="background: radial-gradient(circle at 10% 10%, #F6EBDD, #EBDCCF);">
    </div>

    <div class="max-w-4xl mx-auto mt-6 max-h-[calc(100vh-120px)] overflow-y-auto pr-3 pb-10">

        {{-- HEADER TITLE --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#1F2937]">Pengaturan Profil Admin</h1>
            <p class="text-sm text-[#4B5563] mt-1">
                Ubah informasi akun dan kata sandi Anda
            </p>
        </div>

        {{-- ---------------- CARD PROFIL ---------------- --}}
        <div class="bg-white shadow-xl border border-[#eadfce] rounded-2xl p-8 mb-10 
                    hover:shadow-2xl transition-all duration-300">

            <h2 class="text-xl font-bold text-[#1F2937] mb-1">Data Profil</h2>
            <p class="text-sm text-gray-500 mb-6">Perbarui nama dan email Anda.</p>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama</label>
                    <input type="text" name="name"
                           class="mt-1 w-full rounded-lg border border-[#dadada] p-3 text-gray-700
                                  focus:ring-2 focus:ring-[#f39c3d] focus:border-[#f39c3d]"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email"
                           class="mt-1 w-full rounded-lg border border-[#dadada] p-3 text-gray-700
                                  focus:ring-2 focus:ring-[#f39c3d] focus:border-[#f39c3d]"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Save Button --}}
                <button type="submit"
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[#F8B84E] to-[#F39C3D]
                               text-white font-semibold shadow-md hover:shadow-lg 
                               hover:scale-[1.03] transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>


         {{-- ---------------- CARD PASSWORD ---------------- --}}
        <div class="bg-white shadow-xl border border-[#eadfce] rounded-2xl p-8 
                    hover:shadow-2xl transition-all duration-300">

            <h2 class="text-xl font-bold text-[#1F2937] mb-1">Ganti Kata Sandi</h2>
            <p class="text-sm text-gray-500 mb-6">
                Gunakan kata sandi kuat untuk menjaga keamanan akun.
            </p>

           <form method="POST" action="{{ route('admin.profile.password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')


                {{-- Current Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password Lama</label>
                    <input type="password" name="current_password"
                           class="mt-1 w-full rounded-lg border border-[#dadada] p-3 text-gray-700
                                  focus:ring-2 focus:ring-[#f39c3d] focus:border-[#f39c3d]">
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password Baru</label>
                    <input type="password" name="password"
                           class="mt-1 w-full rounded-lg border border-[#dadada] p-3 text-gray-700
                                  focus:ring-2 focus:ring-[#f39c3d] focus:border-[#f39c3d]">
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="mt-1 w-full rounded-lg border border-[#dadada] p-3 text-gray-700
                                  focus:ring-2 focus:ring-[#f39c3d] focus:border-[#f39c3d]">
                </div>

                {{-- Save Button --}}
                <button type="submit"
                        class="px-6 py-2 rounded-full bg-gradient-to-r from-[#F8B84E] to-[#F39C3D]
                               text-white font-semibold shadow-md hover:shadow-lg 
                               hover:scale-[1.03] transition">
                    Update Password
                </button>
            </form>
        </div>

        {{-- ----- KEMBALI --}}
        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.laporan.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2 rounded-full
                      bg-gray-200 text-gray-700 text-sm font-medium
                      hover:bg-gray-300 hover:scale-[1.03] transition">
                ← Kembali
            </a>
        </div>

    </div>

</x-layouts.admin-shell>
