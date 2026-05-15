@extends('layouts.app')

@section('title', 'Pendaftaran Saya')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Pendaftaran Saya</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar semua registrasi event kamu</p>
    </div>
    <a href="{{ route('participant.select-event') }}"
       class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
        <i class="fas fa-plus"></i> Daftar Event Baru
    </a>
</div>

@if($registrations->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-12 text-center">
        <i class="fas fa-ticket-alt text-orange-300 text-5xl mb-4 block"></i>
        <p class="text-gray-600 font-medium">Belum ada pendaftaran</p>
        <p class="text-gray-400 text-sm mt-1">Yuk daftar event lari pertamamu!</p>
        <a href="{{ route('participant.select-event') }}"
           class="inline-flex items-center gap-2 mt-4 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fas fa-running"></i> Lihat Event
        </a>
    </div>
@else
<div class="space-y-4">
    @foreach($registrations as $reg)
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-2 py-1 rounded">
                        {{ $reg->getRegistrationNumber() }}
                    </span>
                    {{-- Status Badge --}}
                    @if($reg->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full font-medium">
                            <i class="fas fa-clock"></i> Menunggu Upload Bukti
                        </span>
                    @elseif($reg->status == 'waiting_verification')
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full font-medium">
                            <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                        </span>
                    @elseif($reg->status == 'verified')
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                            <i class="fas fa-check-circle"></i> Lunas — E-Ticket Siap
                        </span>
                    @elseif($reg->status == 'claimed')
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">
                            <i class="fas fa-box-open"></i> Race Pack Sudah Diambil
                        </span>
                    @endif
                </div>

                <h3 class="font-semibold text-gray-800">{{ $reg->ticketCategory->event->name }}</h3>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-running text-orange-400"></i>
                        {{ $reg->ticketCategory->category_name }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-orange-400"></i>
                        {{ \Carbon\Carbon::parse($reg->ticketCategory->event->date)->format('d M Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-map-marker-alt text-orange-400"></i>
                        {{ $reg->ticketCategory->event->location }}
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                @if($reg->status == 'pending')
                    <a href="{{ route('participant.upload.form', $reg) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition">
                        <i class="fas fa-upload"></i> Upload Bukti
                    </a>
                    <form action="{{ route('participant.cancel', $reg) }}" method="POST" class="inline"
                          onsubmit="return confirm('Batalkan pendaftaran ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium rounded-lg transition">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </form>
                @elseif($reg->status == 'verified')
                    <a href="{{ route('participant.download-ticket', $reg) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition">
                        <i class="fas fa-download"></i> Download E-Ticket
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
