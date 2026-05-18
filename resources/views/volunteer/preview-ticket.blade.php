@extends('layouts.app')

@section('title', 'Preview E-Ticket')

@section('content')

<div class="mb-6">
    <a href="javascript:history.back()" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
        <i class="fas fa-arrow-left"></i> Kembali ke Hasil Pencarian
    </a>
</div>

<div class="max-w-2xl mx-auto">

    {{-- Status Banner --}}
    @if($registration->racePack)
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-xl mb-5">
            <i class="fas fa-check-circle text-green-500 text-lg"></i>
            <div>
                <p class="font-semibold text-sm">Race pack sudah diambil</p>
                <p class="text-xs text-green-600">Diambil pada {{ $registration->racePack->claimed_at->format('d M Y, H:i') }} oleh volunteer</p>
            </div>
        </div>
    @else
        <div class="flex items-center gap-3 bg-orange-50 border border-orange-200 text-orange-800 px-5 py-3 rounded-xl mb-5">
            <i class="fas fa-box-open text-orange-500 text-lg"></i>
            <p class="font-semibold text-sm">Race pack belum diambil — siap diserahkan</p>
        </div>
    @endif

    {{-- E-Ticket Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden">

        {{-- Header Tiket --}}
        <div class="bg-gray-900 px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-running text-white"></i>
                </div>
                <div>
                    <p class="text-white font-bold text-lg leading-tight">EventRun</p>
                    <p class="text-gray-400 text-xs">E-Ticket Resmi</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-orange-400 font-mono font-bold text-lg">{{ $registration->getRegistrationNumber() }}</p>
                <p class="text-gray-400 text-xs mt-0.5">Nomor Registrasi</p>
            </div>
        </div>

        {{-- Garis putus-putus --}}
        <div class="flex items-center px-8 py-0">
            <div class="w-6 h-6 bg-orange-50 rounded-full -ml-11 border border-orange-100"></div>
            <div class="flex-1 border-t-2 border-dashed border-orange-100 mx-2"></div>
            <div class="w-6 h-6 bg-orange-50 rounded-full -mr-11 border border-orange-100"></div>
        </div>

        {{-- Info Peserta --}}
        <div class="px-8 py-6">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nama Peserta</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $registration->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $registration->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Kategori</p>
                    <span class="inline-block bg-orange-500 text-white font-bold text-xl px-4 py-1 rounded-lg">
                        {{ $registration->ticketCategory->category_name }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">
                        <i class="fas fa-calendar mr-1 text-orange-400"></i> Tanggal Event
                    </p>
                    <p class="font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($registration->ticketCategory->event->date)->format('d M Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">
                        <i class="fas fa-map-marker-alt mr-1 text-orange-400"></i> Lokasi
                    </p>
                    <p class="font-semibold text-gray-800">{{ $registration->ticketCategory->event->location }}</p>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">
                    <i class="fas fa-flag mr-1 text-orange-400"></i> Nama Event
                </p>
                <p class="font-semibold text-gray-800">{{ $registration->ticketCategory->event->name }}</p>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">
                        <i class="fas fa-check-circle mr-1 text-orange-400"></i> Status Pembayaran
                    </p>
                    <span class="inline-flex items-center gap-1.5 text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                        <i class="fas fa-check-circle"></i> Lunas & Terverifikasi
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">
                        <i class="fas fa-clock mr-1 text-orange-400"></i> Verified Pada
                    </p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $registration->verified_at ? $registration->verified_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer Aksi --}}
        @if(!$registration->racePack)
        <div class="px-8 py-5 bg-orange-50 border-t border-orange-100 flex items-center justify-between gap-4">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle text-orange-400 mr-1"></i>
                Pastikan data peserta sesuai sebelum menyerahkan race pack
            </p>
            <form action="{{ route('volunteer.confirm', $registration) }}" method="POST"
                  onsubmit="return confirm('Konfirmasi serah terima race pack untuk {{ $registration->user->name }}?')">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition whitespace-nowrap">
                    <i class="fas fa-box-open"></i> Serahkan Race Pack
                </button>
            </form>
        </div>
        @else
        <div class="px-8 py-5 bg-green-50 border-t border-green-100 text-center">
            <p class="text-sm text-green-700 font-medium">
                <i class="fas fa-check-circle mr-1"></i>
                Race pack sudah diserahkan — tidak ada aksi yang diperlukan
            </p>
        </div>
        @endif

    </div>
</div>

@endsection
