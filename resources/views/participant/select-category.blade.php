@extends('layouts.app')

@section('title', 'Pilih Kategori - '.$event->name)

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Pilih Kategori untuk {{ $event->name }}</h1>
    <form method="POST" action="{{ route('participant.checkout') }}">
        @csrf
        <input type="hidden" name="ticket_category_id" id="selected_category">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($categories as $cat)
            <div class="border rounded p-4 cursor-pointer hover:bg-gray-50" onclick="document.getElementById('selected_category').value = {{ $cat->id }}; this.classList.add('bg-blue-100')">
                <h3 class="text-lg font-bold">{{ $cat->category_name }}</h3>
                <p>Harga: Rp {{ number_format($cat->price) }}</p>
                <p>Sisa kuota: {{ $cat->getAvailableQuota() ?? $cat->quota - $cat->registrations->count() }}</p>
            </div>
            @endforeach
        </div>
        <button type="submit" class="mt-4 bg-green-500 text-white px-6 py-2 rounded">Daftar Sekarang</button>
    </form>
</div>
@endsection