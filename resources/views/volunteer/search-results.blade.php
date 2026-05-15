@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Hasil untuk: {{ $keyword }}</h1>
    @foreach($registrations as $reg)
        <div class="border p-4 mb-4 rounded">
            <p><strong>Nama:</strong> {{ $reg->user->name }}</p>
            <p><strong>Event:</strong> {{ $reg->ticketCategory->event->name }} - {{ $reg->ticketCategory->category_name }}</p>
            <p><strong>Status:</strong> {{ $reg->status }}</p>
            @if($reg->status == 'verified' && !$reg->racePack)
                <form action="{{ route('volunteer.confirm', $reg) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Konfirmasi Serah Terima Race Pack</button>
                </form>
            @elseif($reg->racePack)
                <p class="text-green-600">✓ Race pack sudah diambil pada {{ $reg->racePack->claimed_at }}</p>
            @endif
        </div>
    @endforeach
    <a href="{{ route('volunteer.dashboard') }}" class="text-blue-500">← Kembali</a>
</div>
@endsection