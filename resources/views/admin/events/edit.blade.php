@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Event</h1>
    <form method="POST" action="{{ route('admin.events.update', $event) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Nama Event</label>
            <input type="text" name="name" value="{{ old('name', $event->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal</label>
            <input type="date" name="date" value="{{ old('date', $event->date) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $event->description) }}</textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection