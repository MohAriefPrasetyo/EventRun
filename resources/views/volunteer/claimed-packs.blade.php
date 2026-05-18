@extends('layouts.app')

@section('title', 'Sudah Ambil Race Pack')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Sudah Ambil Race Pack</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar peserta yang sudah mengambil race pack</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('volunteer.pending-packs') }}"
           class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fas fa-box-open"></i> Belum Ambil
        </a>
        <a href="{{ route('volunteer.search') }}"
           class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fas fa-search"></i> Cari Peserta
        </a>
    </div>
</div>

{{-- Summary --}}
<div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 mb-6 flex items-center gap-4">
    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
        <i class="fas fa-check-circle text-green-600"></i>
    </div>
    <div>
        <p class="text-2xl font-bold text-gray-800">{{ $racePacks->total() }}</p>
        <p class="text-sm text-gray-500">Total race pack sudah diserahkan</p>
    </div>
</div>

@if($racePacks->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-12 text-center">
        <i class="fas fa-box text-orange-300 text-5xl mb-4 block"></i>
        <p class="text-gray-600 font-medium">Belum ada race pack yang diserahkan</p>
    </div>
@else
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="min-w-full divide-y divide-orange-50">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Reg</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Diserahkan Oleh</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Ambil</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-orange-50">
            @foreach($racePacks as $pack)
            <tr class="hover:bg-orange-50 transition">
                <td class="px-6 py-4 text-sm font-mono text-gray-500">
                    {{ $pack->registration->getRegistrationNumber() }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-sm font-bold text-orange-600 shrink-0">
                            {{ strtoupper(substr($pack->registration->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $pack->registration->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $pack->registration->user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $pack->registration->ticketCategory->event->name }}
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">
                        {{ $pack->registration->ticketCategory->category_name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($pack->volunteer)
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ strtoupper(substr($pack->volunteer->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-700">{{ $pack->volunteer->name }}</span>
                        </div>
                    @else
                        <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">
                    <i class="fas fa-clock text-orange-300 mr-1"></i>
                    {{ $pack->claimed_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('volunteer.preview', $pack->registration) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">
                        <i class="fas fa-eye"></i> Lihat Tiket
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($racePacks->hasPages())
        <div class="px-6 py-4 border-t border-orange-100">
            {{ $racePacks->links() }}
        </div>
    @endif
</div>
@endif

@endsection
