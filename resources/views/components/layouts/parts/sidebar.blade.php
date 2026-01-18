@props(['active' => 'history'])

<aside class="bg-black/20 backdrop-blur-sm border-r border-white/10 p-4">
  <div class="flex items-center gap-2 mb-6">
    <img src="/logo-bpbd.png" class="w-6 h-6" alt="logo">
    <div class="text-sm">E-Logistik</div>
  </div>

  <nav class="space-y-1 text-sm">
    <a href="{{ route('dashboard') }}"
       class="block px-3 py-2 rounded-md {{ $active==='history' ? 'bg-white/10' : 'hover:bg-white/10' }}">
       History Laporan
    </a>
    <a href="#"
       class="block px-3 py-2 rounded-md {{ $active==='form' ? 'bg-white/10' : 'hover:bg-white/10' }}">
       Form Laporan
    </a>
  </nav>

  <form method="POST" action="{{ route('logout') }}" class="mt-8">
    @csrf
    <button class="text-xs text-white/70 hover:text-white">Logout</button>
  </form>
</aside>
