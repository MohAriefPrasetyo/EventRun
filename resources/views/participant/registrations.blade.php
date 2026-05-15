@extends('layouts.app')

@section('title', 'Pendaftaran Saya')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Pendaftaran Saya</h1>
    @foreach($registrations as $reg)
        <div class="border p-4 mb-4 rounded">
            <p><strong>Event:</strong> {{ $reg->ticketCategory->event->name }} - {{ $reg->ticketCategory->category_name }}</p>
            <p><strong>Status:</strong> 
                @if($reg->status == 'pending') Menunggu upload bukti
                @elseif($reg->status == 'waiting_verification') Menunggu verifikasi admin
                @elseif($reg->status == 'verified') Lunas - E-Ticket siap
                @elseif($reg->status == 'claimed') Race pack sudah diambil
                @endif
            </p>
            @if($reg->status == 'pending')
                <a href="{{ route('participant.upload.form', $reg) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Upload Bukti</a>
                <form action="{{ route('participant.cancel', $reg) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Batal?')">Batal</button>
                </form>
            @elseif($reg->status == 'verified')
                <a href="{{ route('participant.download-ticket', $reg) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Download E-Ticket</a>
            @endif
        </div>
    @endforeach
</div>
@endsection