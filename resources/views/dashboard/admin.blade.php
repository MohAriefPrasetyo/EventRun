@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda memiliki akses penuh.</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="bg-blue-100 p-4 rounded">
            <h3 class="font-bold">Kelola Event</h3>
            <a href="{{ route('admin.events.index') }}" class="text-blue-600">Go &rarr;</a>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <h3 class="font-bold">Verifikasi Pembayaran</h3>
            <a href="{{ route('admin.payments.index') }}" class="text-green-600">Go &rarr;</a>
        </div>
    </div>
</div>
@endsection