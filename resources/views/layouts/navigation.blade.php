<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    {{ __('Dashboard') }}
</x-nav-link>

@if(Auth::user()->role === 'admin')
    <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.index')">
        {{ __('Admin Panel Laporan') }}
    </x-nav-link>
@endif