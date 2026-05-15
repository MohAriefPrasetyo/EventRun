@extends('layouts.app')

@section('title', 'Volunteer Dashboard')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-1">Dashboard Volunteer</h1>
        <p class="text-gray-500">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    {{-- Form Cari Peserta --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Cari Peserta</h2>
        <form method="GET" action="{{ route('volunteer.search') }}">
            <div class="flex gap-2">
                <input type="text" name="q"
                       placeholder="Ketik nama, email, atau nomor registrasi..."
                       class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-medium">
                    Cari
                </button>
            </div>
        </form>
        <p class="text-sm text-gray-400 mt-2">Kosongkan dan klik Cari untuk melihat semua peserta verified.</p>
    </div>

    {{-- Shortcut --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Aksi Cepat</h2>
        <div class="flex gap-4">
            <a href="{{ route('volunteer.search') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Semua Peserta Verified
            </a>
            <a href="{{ route('volunteer.pending-packs') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Belum Ambil Race Pack
            </a>
        </div>
    </div>

</div>
@endsection
