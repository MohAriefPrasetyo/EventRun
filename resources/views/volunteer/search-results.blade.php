@extends('layouts.app')

@section('title', 'Cari Peserta')

@section('content')

{{-- Search Bar --}}
<div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6 mb-6">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Cari Peserta</h2>
    <form method="GET" action="{{ route('volunteer.search') }}">
        <div class="flex gap-3">
            <input type="text" name="q" value="{{ $keyword }}"
                   placeholder="Nama, email, atau nomor registrasi (REG-000001)"
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                <i class="fas fa-search mr-1"></i> Cari
            </button>
        </div>
    </form>
</div>

{{-- Result Info --}}
@if($keyword === '')
    <p class="text-sm text-gray-500 mb-4">Menampilkan semua peserta yang sudah verified:</p>
@elseif($registrations->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-10 text-center">
        <i class="fas fa-search text-orange-300 text-4xl mb-3 block"></i>
        <p class="text-gray-600 font-medium">Tidak ada hasil untuk "<strong>{{ $keyword }}</strong>"</p>
        <p class="text-gray-400 text-sm mt-1">Coba cari dengan nama, email, atau nomor registrasi lain</p>
    </div>
@else
    <p class="text-sm text-gray-500 mb-4">Ditemukan <strong class="text-orange-600">{{ $registrations->count() }}</strong> hasil untuk "<strong>{{ $keyword }}</strong>":</p>
@endif

{{-- Results --}}
@if($registrations->isNotEmpty())
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="min-w-full divide-y divide-orange-50">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Reg</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event & Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Race Pack</th>
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
                <td class="px-6 py-4">
                    <p class="text-sm text-gray-800">{{ $reg->ticketCategory->event->name }}</p>
                    <span class="inline-block mt-1 text-xs px-2.5 py-0.5 bg-orange-100 text-orange-700 rounded-full font-medium">
                        {{ $reg->ticketCategory->category_name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($reg->racePack)
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-medium">
                            <i class="fas fa-check-circle"></i> Sudah diambil
                        </span>
                        <p class="text-xs text-gray-400 mt-1">{{ $reg->racePack->claimed_at->format('d M Y H:i') }}</p>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full font-medium">
                            <i class="fas fa-clock"></i> Belum diambil
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    @if(!$reg->racePack)
                        <form action="{{ route('volunteer.confirm', $reg) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi serah terima race pack untuk {{ $reg->user->name }}?')">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition">
                                <i class="fas fa-box-open"></i> Serahkan Race Pack
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-gray-400">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
