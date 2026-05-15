@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>
    <form method="POST" action="{{ route('admin.events.ticket_categories.update', [$event, $ticketCategory]) }}">
        @csrf @method('PUT')
        <div class="mb-4"><label>Nama Kategori</label><input type="text" name="category_name" value="{{ old('category_name', $ticketCategory->category_name) }}" class="w-full border rounded px-3 py-2" required></div>
        <div class="mb-4"><label>Harga (Rp)</label><input type="number" name="price" value="{{ old('price', $ticketCategory->price) }}" class="w-full border rounded px-3 py-2" required></div>
        <div class="mb-4"><label>Kuota</label><input type="number" name="quota" value="{{ old('quota', $ticketCategory->quota) }}" class="w-full border rounded px-3 py-2" required></div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection