@extends('layouts.app')

@section('title', 'Peserta Belum Ambil Race Pack')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Peserta Lunas Belum Ambil Race Pack</h1>
    <table class="min-w-full">
        <thead><tr><th>Nama</th><th>Event</th><th>Kategori</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($registrations as $reg)
            <tr>
                <td class="py-2">{{ $reg->user->name }}</td>
                <td>{{ $reg->ticketCategory->event->name }}</td>
                <td>{{ $reg->ticketCategory->category_name }}</td>
                <td>
                    <form action="{{ route('volunteer.confirm', $reg) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Konfirmasi</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $registrations->links() }}
</div>
@endsection