@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-calendar-alt text-orange-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Total Event</p>
            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Event::count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 flex items-center gap-4">
        <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-clock text-yellow-600"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Menunggu Verifikasi</p>
            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Registration::where('status','waiting_verification')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 flex items-center gap-4">
        <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-check-circle text-green-600"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Sudah Verified</p>
            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Registration::where('status','verified')->count() }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-users text-orange-500"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">Total Peserta</p>
            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Registration::whereIn('status',['verified','claimed'])->count() }}</p>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    <a href="{{ route('admin.events.index') }}"
       class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md hover:border-orange-300 transition group flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-500 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-orange-600 transition">
            <i class="fas fa-calendar-alt text-white"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800">Kelola Event</h3>
            <p class="text-xs text-gray-500 mt-0.5">Tambah, edit, dan hapus event lari</p>
        </div>
        <i class="fas fa-arrow-right text-gray-300 group-hover:text-orange-500 transition"></i>
    </a>
    <a href="{{ route('admin.payments.index') }}"
       class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:shadow-md hover:border-orange-300 transition group flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-500 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-orange-600 transition">
            <i class="fas fa-credit-card text-white"></i>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800">Verifikasi Pembayaran</h3>
            <p class="text-xs text-gray-500 mt-0.5">Setujui atau tolak bukti pembayaran</p>
        </div>
        <i class="fas fa-arrow-right text-gray-300 group-hover:text-orange-500 transition"></i>
    </a>
</div>

{{-- Bottom Section --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Daftar Peserta --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-orange-100">
            <h3 class="font-semibold text-gray-800">Daftar Peserta</h3>
            <a href="{{ route('admin.payments.index') }}" class="text-xs text-orange-500 hover:underline">Lihat semua →</a>
        </div>
        <table class="min-w-full divide-y divide-orange-50">
            <thead class="bg-orange-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse(\App\Models\Registration::with(['user','ticketCategory.event'])->latest()->take(10)->get() as $reg)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-xs font-bold text-orange-600 shrink-0">
                                {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $reg->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $reg->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $reg->ticketCategory->event->name }}</td>
                    <td class="px-6 py-3">
                        <span class="text-xs px-2.5 py-1 rounded-full bg-orange-100 text-orange-700 font-medium">
                            {{ $reg->ticketCategory->category_name }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            @if($reg->status === 'pending') bg-gray-100 text-gray-600
                            @elseif($reg->status === 'waiting_verification') bg-yellow-100 text-yellow-700
                            @elseif($reg->status === 'verified') bg-green-100 text-green-700
                            @else bg-orange-100 text-orange-700 @endif">
                            @if($reg->status === 'pending') Pending
                            @elseif($reg->status === 'waiting_verification') Menunggu Verifikasi
                            @elseif($reg->status === 'verified') Verified
                            @else Claimed @endif
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada pendaftaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Daftar Event --}}
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-orange-100">
            <h3 class="font-semibold text-gray-800">Daftar Event</h3>
            <a href="{{ route('admin.events.index') }}" class="text-xs text-orange-500 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-orange-50">
            @forelse(\App\Models\Event::orderBy('date')->take(6)->get() as $event)
            <div class="px-6 py-4 hover:bg-orange-50 transition">
                <p class="text-sm font-medium text-gray-800">{{ $event->name }}</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                <p class="text-xs text-gray-400 mt-0.5"><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->location }}</p>
                <span class="inline-block mt-2 text-xs px-2 py-0.5 rounded-full
                    @if($event->isOpen()) bg-green-100 text-green-700 @else bg-gray-100 text-gray-500 @endif">
                    {{ $event->isOpen() ? 'Aktif' : 'Selesai' }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada event</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
