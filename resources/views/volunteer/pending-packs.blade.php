@extends('layouts.app')

@section('title', 'Belum Ambil Race Pack')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Belum Ambil Race Pack</h2>
        <p class="text-sm text-gray-500 mt-1">Peserta yang sudah verified namun belum mengambil race pack</p>
    </div>
    <a href="{{ route('volunteer.search') }}"
       class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
        <i class="fas fa-search"></i> Cari Peserta
    </a>
</div>

@if($registrations->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-12 text-center">
        <i class="fas fa-box-open text-orange-300 text-5xl mb-4 block"></i>
        <p class="text-gray-600 font-medium">Semua race pack sudah diambil</p>
        <p class="text-gray-400 text-sm mt-1">Tidak ada peserta yang menunggu pengambilan race pack</p>
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
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Verified Pada</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-orange-50">
            @foreach($registrations as $reg)
            <tr class="hover:bg-orange-50 transition">
                <td class="px-6 py-4 text-sm font-mono text-gray-500">{{ $reg->getRegistrationNumber() }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center text-sm font-bold text-orange-600 shrink-0">
                            {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $reg->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $reg->user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $reg->ticketCategory->event->name }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full font-medium">
                        {{ $reg->ticketCategory->category_name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs text-gray-400">
                    {{ $reg->verified_at ? $reg->verified_at->format('d M Y H:i') : '-' }}
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('volunteer.preview', $reg) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition">
                            <i class="fas fa-eye"></i> Lihat Tiket
                        </a>
                        <form action="{{ route('volunteer.confirm', $reg) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi serah terima race pack untuk {{ $reg->user->name }}?')">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition">
                                <i class="fas fa-box-open"></i> Serahkan
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($registrations->hasPages())
        <div class="px-6 py-4 border-t border-orange-100">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endif

@endsection
