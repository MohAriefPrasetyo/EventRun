@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Event</h1>
    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nama Event</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal</label>
            <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Lokasi</label>
            <input type="text" name="location" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection