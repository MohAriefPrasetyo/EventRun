@extends('layouts.app')

@section('title', 'Dashboard Volunteer')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard Volunteer</h1>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda bertugas di lapangan.</p>
    <div class="mt-6">
        <a href="{{ route('volunteer.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Cari Peserta</a>
        <a href="{{ route('volunteer.pending-packs') }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">Daftar Belum Diambil</a>
    </div>
</div>
@endsection