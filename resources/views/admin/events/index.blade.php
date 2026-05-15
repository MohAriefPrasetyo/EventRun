@extends('layouts.app')

@section('title', 'Daftar Event')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Event</h1>
        <a href="{{ route('admin.events.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Event</a>
    </div>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nama</th>
                <th class="py-2 px-4 border-b">Tanggal</th>
                <th class="py-2 px-4 border-b">Lokasi</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td class="py-2 px-4 border-b">{{ $event->id }}</td>
                <td class="py-2 px-4 border-b">{{ $event->name }}</td>
                <td class="py-2 px-4 border-b">{{ $event->date }}</td>
                <td class="py-2 px-4 border-b">{{ $event->location }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block ml-2">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                    <a href="{{ route('admin.events.ticket_categories.index', $event) }}" class="text-green-500 ml-2">Kategori</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection