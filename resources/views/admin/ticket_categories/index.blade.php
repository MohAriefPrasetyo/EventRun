@extends('layouts.app')

@section('title', 'Kategori Tiket - '.$event->name)

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Kategori Tiket: {{ $event->name }}</h1>
        <a href="{{ route('admin.events.ticket_categories.create', $event) }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah Kategori</a>
    </div>
    <table class="min-w-full">
        <thead>
            <tr><th>Kategori</th><th>Harga</th><th>Kuota</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td class="py-2">{{ $cat->category_name }}</td>
                <td>Rp {{ number_format($cat->price) }}</td>
                <td>{{ $cat->quota }}</td>
                <td>
                    <a href="{{ route('admin.events.ticket_categories.edit', [$event, $cat]) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('admin.events.ticket_categories.destroy', [$event, $cat]) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.events.index') }}" class="mt-4 inline-block text-gray-600">← Kembali ke Event</a>
</div>
@endsection