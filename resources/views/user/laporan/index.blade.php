@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Laporan Saya</h1>

    <a href="{{ route('laporan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Laporan</a>

    <table class="table-auto w-full mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $lap)
            <tr>
                <td>{{ $lap->judul }}</td>
                <td>{{ ucfirst($lap->status) }}</td>
                <td><a href="{{ route('laporan.show', $lap->id_laporan) }}" class="text-blue-600">Lihat</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
