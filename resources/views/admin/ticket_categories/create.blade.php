@extends('layouts.app')

@section('title', 'Tambah Kategori Tiket')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.events.ticket_categories.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
        <i class="fas fa-arrow-left"></i> Kembali ke Kategori
    </a>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-lg font-bold text-gray-800 mb-1">Tambah Kategori Tiket</h2>
        <p class="text-sm text-gray-500 mb-6">{{ $event->name }}</p>

        <form method="POST" action="{{ route('admin.events.ticket_categories.store', $event) }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="category_name" value="{{ old('category_name') }}"
                       placeholder="Contoh: 5K, 10K, Half Marathon"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('category_name') border-red-400 @enderror">
                @error('category_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           placeholder="150000" min="0"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('price') border-red-400 @enderror">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kuota <span class="text-red-500">*</span></label>
                    <input type="number" name="quota" value="{{ old('quota') }}"
                           placeholder="100" min="1"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('quota') border-red-400 @enderror">
                    @error('quota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
                <a href="{{ route('admin.events.ticket_categories.index', $event) }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
