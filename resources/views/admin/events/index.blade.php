@extends('layouts.app')

@section('title', 'Kelola Event')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Event</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua event lari yang tersedia</p>
    </div>
    <a href="{{ route('admin.events.create') }}"
       class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
        <i class="fas fa-plus"></i> Tambah Event
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Event</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($events as $event)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-400">{{ $event->id }}</td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $event->name }}</p>
                    @if($event->description)
                        <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $event->description }}</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    <i class="fas fa-calendar text-gray-400 mr-1"></i>
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                    {{ $event->location }}
                </td>
                <td class="px-6 py-4">
                    @if($event->isOpen())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> Selesai
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.events.ticket_categories.index', $event) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-purple-50 text-purple-700 hover:bg-purple-100 transition">
                            <i class="fas fa-tags"></i> Kategori
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus event {{ $event->name }}? Semua data terkait akan ikut terhapus.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-50 text-red-700 hover:bg-red-100 transition">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-calendar-times text-4xl mb-3 block"></i>
                    Belum ada event. <a href="{{ route('admin.events.create') }}" class="text-blue-500 hover:underline">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($events->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $events->links() }}
        </div>
    @endif
</div>

@endsection
