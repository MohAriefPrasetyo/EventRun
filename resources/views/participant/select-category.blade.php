@extends('layouts.app')

@section('title', 'Pilih Kategori')

@section('content')

<div class="mb-6">
    <a href="{{ route('participant.select-event') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Event
    </a>
    <h2 class="text-xl font-bold text-gray-800">Pilih Kategori</h2>
    <p class="text-sm text-gray-500 mt-1">
        <i class="fas fa-calendar text-orange-400 mr-1"></i>{{ $event->name }} &mdash;
        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
    </p>
</div>

<form method="POST" action="{{ route('participant.checkout') }}">
    @csrf
    <input type="hidden" name="ticket_category_id" id="selected_category">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        @foreach($categories as $cat)
        @php $available = $cat->getAvailableQuota(); @endphp
        <div onclick="selectCategory({{ $cat->id }}, this)"
             class="category-card bg-white rounded-xl shadow-sm border-2 border-orange-100 p-6 cursor-pointer hover:border-orange-400 hover:shadow-md transition {{ $available <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
             data-id="{{ $cat->id }}">
            <div class="flex items-center justify-between mb-4">
                <span class="text-2xl font-bold text-orange-500">{{ $cat->category_name }}</span>
                <div class="w-6 h-6 rounded-full border-2 border-orange-300 flex items-center justify-center check-icon">
                    <i class="fas fa-check text-white text-xs hidden"></i>
                </div>
            </div>
            <p class="text-xl font-bold text-gray-800 mb-3">Rp {{ number_format($cat->price, 0, ',', '.') }}</p>
            <div class="space-y-1">
                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                    <i class="fas fa-users text-orange-300"></i>
                    Kuota: {{ number_format($cat->quota) }} peserta
                </p>
                <p class="text-xs flex items-center gap-1.5 {{ $available > 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-{{ $available > 0 ? 'check-circle' : 'times-circle' }}"></i>
                    {{ $available > 0 ? "Sisa $available slot" : 'Kuota penuh' }}
                </p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 flex items-center justify-between">
        <p class="text-sm text-gray-500" id="selected-info">
            <i class="fas fa-hand-pointer text-orange-400 mr-1"></i> Pilih kategori di atas
        </p>
        <button type="submit" id="submit-btn" disabled
                class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
            <i class="fas fa-shopping-cart"></i> Daftar Sekarang
        </button>
    </div>
</form>

<script>
function selectCategory(id, el) {
    // Reset semua card
    document.querySelectorAll('.category-card').forEach(c => {
        c.classList.remove('border-orange-500', 'bg-orange-50');
        c.classList.add('border-orange-100');
        c.querySelector('.check-icon').classList.remove('bg-orange-500', 'border-orange-500');
        c.querySelector('.check-icon i').classList.add('hidden');
    });

    // Aktifkan yang dipilih
    el.classList.add('border-orange-500', 'bg-orange-50');
    el.classList.remove('border-orange-100');
    el.querySelector('.check-icon').classList.add('bg-orange-500', 'border-orange-500');
    el.querySelector('.check-icon i').classList.remove('hidden');

    document.getElementById('selected_category').value = id;
    document.getElementById('submit-btn').disabled = false;

    const name = el.querySelector('span').textContent;
    document.getElementById('selected-info').innerHTML =
        '<i class="fas fa-check-circle text-orange-500 mr-1"></i> Kategori <strong>' + name + '</strong> dipilih';
}
</script>

@endsection
