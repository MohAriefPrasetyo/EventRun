@extends('layouts.app')

@section('title', 'Pilih Event')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Pilih Event Lari</h2>
    <p class="text-sm text-gray-500 mt-1">Pilih event yang ingin kamu ikuti</p>
</div>

@if($events->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-12 text-center">
        <i class="fas fa-calendar-times text-orange-300 text-5xl mb-4 block"></i>
        <p class="text-gray-600 font-medium">Belum ada event yang tersedia</p>
        <p class="text-gray-400 text-sm mt-1">Pantau terus untuk event berikutnya</p>
    </div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($events as $event)
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 hover:shadow-md hover:border-orange-300 transition overflow-hidden">
        <div class="bg-orange-500 px-6 py-4">
            <h3 class="text-white font-bold text-lg leading-tight">{{ $event->name }}</h3>
        </div>
        <div class="p-6">
            <div class="space-y-2 mb-4">
                <p class="text-sm text-gray-600 flex items-center gap-2">
                    <i class="fas fa-calendar text-orange-400 w-4"></i>
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                </p>
                <p class="text-sm text-gray-600 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-orange-400 w-4"></i>
                    {{ $event->location }}
                </p>
                @if($event->description)
                <p class="text-sm text-gray-400 flex items-start gap-2 mt-3">
                    <i class="fas fa-info-circle text-orange-300 w-4 mt-0.5"></i>
                    {{ Str::limit($event->description, 80) }}
                </p>
                @endif
            </div>
            <a href="{{ route('participant.select-category', $event) }}"
               class="w-full flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
                <i class="fas fa-ticket-alt"></i> Pilih Kategori
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
