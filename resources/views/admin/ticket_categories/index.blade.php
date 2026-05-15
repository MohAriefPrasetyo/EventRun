@extends('layouts.app')

@section('title', 'Kategori Tiket')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Event
    </a>
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kategori Tiket</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $event->name }} &mdash; {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
        </div>
        <a href="{{ route('admin.events.ticket_categories.create', $event) }}"
           class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kuota</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Terisi</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        {{ $cat->category_name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                    Rp {{ number_format($cat->price, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ number_format($cat->quota) }} peserta</td>
                <td class="px-6 py-4">
                    @php
                        $filled = $cat->registrations()->whereNotIn('status', ['cancelled'])->count();
                        $pct = $cat->quota > 0 ? round(($filled / $cat->quota) * 100) : 0;
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="flex-1 bg-gray-200 rounded-full h-1.5 w-24">
                            <div class="h-1.5 rounded-full {{ $pct >= 90 ? 'bg-red-500' : ($pct >= 60 ? 'bg-yellow-500' : 'bg-green-500') }}"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $filled }}/{{ $cat->quota }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.events.ticket_categories.edit', [$event, $cat]) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-orange-700 hover:bg-blue-100 transition">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.events.ticket_categories.destroy', [$event, $cat]) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus kategori {{ $cat->category_name }}?')">
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
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-tags text-4xl mb-3 block"></i>
                    Belum ada kategori. <a href="{{ route('admin.events.ticket_categories.create', $event) }}" class="text-orange-500 hover:underline">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
