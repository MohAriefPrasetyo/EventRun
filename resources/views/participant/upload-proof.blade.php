@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Upload Bukti Transfer</h1>
    <form method="POST" action="{{ route('participant.upload.proof', $registration) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Foto/PDF Bukti Transfer</label>
            <input type="file" name="payment_proof" accept="image/*,application/pdf" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim</button>
    </form>
</div>
@endsection