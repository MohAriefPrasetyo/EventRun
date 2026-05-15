@extends('layouts.app')

@section('title', 'Pilih Event')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Pilih Event Lari</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($events as $event)
            <div class="border rounded p-4">
                <h2 class="text-xl font-semibold">{{ $event->name }}</h2>
                <p>📅 {{ $event->date }} | 📍 {{ $event->location }}</p>
                <a href="{{ route('participant.select-category', $event) }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded">Pilih</a>
            </div>
        @endforeach
    </div>
</div>
@endsection