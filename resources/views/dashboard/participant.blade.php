@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')

{{-- Welcome --}}
<div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center text-white text-xl font-bold shrink-0">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-500 text-sm">Ikuti event lari favoritmu dan raih pencapaian baru.</p>
        </div>
    </div>
</div>

{{-- Stats --}}
@php
    $regs = Auth::user()->registrations()->with('ticketCategory.event')->latest()->get();
    $pending   = $regs->where('status', 'pending')->count();
    $waiting   = $regs->where('status', 'waiting_verification')->count();
    $verified  = $regs->where('status', 'verified')->count();
    $claimed   = $regs->where('status', 'claimed')->count();
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4 text-center">
        <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-clock text-gray-500 text-sm"></i>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $pending }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Belum Upload</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4 text-center">
        <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-hourglass-half text-yellow-600 text-sm"></i>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $waiting }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Menunggu Verifikasi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4 text-center">
        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-check-circle text-green-600 text-sm"></i>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $verified }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Verified</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4 text-center">
        <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2">
            <i class="fas fa-box-open text-orange-500 text-sm"></i>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ $claimed }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Race Pack Diambil</p>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <a href="{{ route('participant.select-event') }}"
       class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:border-orange-300 hover:shadow-md transition group flex items-center gap-4">
        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center group-hover:bg-orange-600 transition shrink-0">
            <i class="fas fa-ticket-alt text-white text-sm"></i>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Daftar Event Baru</p>
            <p class="text-xs text-gray-400 mt-0.5">Pilih event dan kategori</p>
        </div>
    </a>
    <a href="{{ route('participant.registrations.index') }}"
       class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:border-orange-300 hover:shadow-md transition group flex items-center gap-4">
        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center group-hover:bg-orange-600 transition shrink-0">
            <i class="fas fa-list text-white text-sm"></i>
        </div>
        <div>
            <p class="font-semibold text-gray-800 text-sm">Pendaftaran Saya</p>
            <p class="text-xs text-gray-400 mt-0.5">Lihat status dan e-ticket</p>
        </div>
    </a>
</div>

{{-- Daftar Pendaftaran Terbaru --}}
@if($regs->isNotEmpty())
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-orange-100">
        <h3 class="font-semibold text-gray-800">Pendaftaran Saya</h3>
        <a href="{{ route('participant.registrations.index') }}" class="text-xs text-orange-500 hover:underline flex items-center gap-1">
            Lihat semua <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="divide-y divide-orange-50">
        @foreach($regs->take(5) as $reg)
        <div class="px-6 py-4 flex items-center justify-between gap-4 hover:bg-orange-50 transition">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $reg->ticketCategory->event->name }}</p>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <i class="fas fa-running text-orange-300"></i>
                        {{ $reg->ticketCategory->category_name }}
                    </span>
                    <span class="text-xs text-gray-400 flex items-center gap-1">
                        <i class="fas fa-calendar text-orange-300"></i>
                        {{ \Carbon\Carbon::parse($reg->ticketCategory->event->date)->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-xs px-2.5 py-1 rounded-full font-medium
                    @if($reg->status === 'pending') bg-gray-100 text-gray-600
                    @elseif($reg->status === 'waiting_verification') bg-yellow-100 text-yellow-700
                    @elseif($reg->status === 'verified') bg-green-100 text-green-700
                    @else bg-orange-100 text-orange-700 @endif">
                    @if($reg->status === 'pending') <i class="fas fa-clock mr-1"></i>Pending
                    @elseif($reg->status === 'waiting_verification') <i class="fas fa-hourglass-half mr-1"></i>Menunggu
                    @elseif($reg->status === 'verified') <i class="fas fa-check-circle mr-1"></i>Verified
                    @else <i class="fas fa-box-open mr-1"></i>Claimed @endif
                </span>
                @if($reg->status === 'pending')
                    <a href="{{ route('participant.upload.form', $reg) }}"
                       class="text-xs text-orange-500 hover:text-orange-700 font-medium">
                        Upload <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @elseif($reg->status === 'verified')
                    <a href="{{ route('participant.download-ticket', $reg) }}"
                       class="text-xs text-orange-500 hover:text-orange-700 font-medium">
                        Download <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
