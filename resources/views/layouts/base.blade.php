<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'E-Logistik BPBD DIY' }}</title>

    @vite('resources/css/app.css')
</head>

<body class="min-h-screen overflow-hidden antialiased font-sans">

    {{-- SLOT KONTEN --}}
    {{ $slot }}

    {{-- Admin shortcut (opsional) --}}
    @auth
        @if(auth()->user()->is_admin)
            <div class="fixed bottom-4 right-4 z-50">
                <a href="{{ route('admin.laporan.index') }}"
                   class="bg-orange-500 hover:bg-orange-600
                          text-white px-4 py-2 rounded-md shadow">
                    Admin Panel
                </a>
            </div>
        @endif
    @endauth

    {{-- SWEETALERT (GLOBAL, WAJIB) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPT DARI HALAMAN --}}
    @stack('scripts')

</body>
</html>
