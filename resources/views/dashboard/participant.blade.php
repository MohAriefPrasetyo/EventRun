@extends('layouts.app')

@section('title', 'Dashboard Peserta')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Peserta</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Ikuti event lari favoritmu.</p>
    <div class="mt-6">
        <a href="{{ route('participant.select-event') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Daftar Event Baru</a>
        <a href="{{ route('participant.registrations.index') }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">Lihat Pendaftaranku</a>
    </div>
</div>
@endsection