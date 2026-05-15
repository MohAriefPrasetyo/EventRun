@use(Illuminate\Support\Facades\Storage)
@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Verifikasi Pembayaran</h1>
    <table class="min-w-full">
        <thead><tr><th>Peserta</th><th>Event</th><th>Kategori</th><th>Bukti</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($registrations as $reg)
            <tr>
                <td class="py-2">{{ $reg->user->name }}</td>
                <td>{{ $reg->ticketCategory->event->name }}</td>
                <td>{{ $reg->ticketCategory->category_name }}</td>
                <td>
                    @if($reg->payment_proof)
                        <a href="{{ Storage::url($reg->payment_proof) }}" target="_blank" class="text-blue-500 underline">Lihat Bukti</a>
                    @else
                        <span class="text-gray-400 text-sm">Tidak ada</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.payments.approve', $reg) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Setuju</button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $reg) }}" method="POST" class="inline">
                        @csrf
                        <input type="text" name="reason" placeholder="Alasan" class="border rounded px-2 py-1">
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Tolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $registrations->links() }}
</div>
@endsection