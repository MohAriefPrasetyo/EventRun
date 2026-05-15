@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Cari Peserta</h1>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('volunteer.search') }}" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="q" value="{{ $keyword }}"
                   placeholder="Nama, email, atau nomor registrasi (REG-000001)"
                   class="flex-1 border rounded px-3 py-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </div>
    </form>

    @if($keyword === '')
        <p class="text-gray-500 mb-4">Menampilkan semua peserta yang sudah verified:</p>
    @elseif($registrations->isEmpty())
        <p class="text-red-500">Tidak ada peserta verified yang cocok dengan "<strong>{{ $keyword }}</strong>".</p>
    @else
        <p class="text-gray-600 mb-4">Ditemukan {{ $registrations->count() }} hasil untuk "<strong>{{ $keyword }}</strong>":</p>
    @endif

    @foreach($registrations as $reg)
        <div class="border p-4 mb-4 rounded">
            <p><strong>No. Registrasi:</strong> {{ $reg->getRegistrationNumber() }}</p>
            <p><strong>Nama:</strong> {{ $reg->user->name }}</p>
            <p><strong>Email:</strong> {{ $reg->user->email }}</p>
            <p><strong>Event:</strong> {{ $reg->ticketCategory->event->name }} — {{ $reg->ticketCategory->category_name }}</p>
            <p><strong>Status:</strong>
                @if($reg->racePack)
                    <span class="text-green-600 font-semibold">✓ Race pack sudah diambil</span>
                @else
                    <span class="text-blue-600 font-semibold">Verified — belum ambil race pack</span>
                @endif
            </p>
            @if(!$reg->racePack)
                <form action="{{ route('volunteer.confirm', $reg) }}" method="POST" class="mt-2"
                      onsubmit="return confirm('Konfirmasi serah terima race pack untuk {{ $reg->user->name }}?')">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Konfirmasi Serah Terima Race Pack
                    </button>
                </form>
            @else
                <p class="text-gray-500 text-sm mt-2">Diambil pada: {{ $reg->racePack->claimed_at->format('d M Y H:i') }}</p>
            @endif
        </div>
    @endforeach

    <a href="{{ route('volunteer.dashboard') }}" class="text-blue-500 mt-4 inline-block">← Kembali ke Dashboard</a>
</div>
@endsection
