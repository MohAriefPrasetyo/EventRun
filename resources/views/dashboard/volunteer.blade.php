@extends('layouts.app')

@section('title', 'Dashboard Volunteer')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h1 class="text-xl font-bold text-gray-800 mb-1">Dashboard Volunteer</h1>
        <p class="text-gray-500 text-sm">Selamat datang, {{ Auth::user()->name }}. Anda bertugas di lapangan.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Cari Peserta</h2>
        <form method="GET" action="{{ route('volunteer.search') }}">
            <div class="flex gap-2">
                <input type="text" name="q"
                       placeholder="Ketik nama, email, atau nomor registrasi..."
                       class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </div>
        </form>
        <p class="text-xs text-gray-400 mt-2">Kosongkan dan klik Cari untuk melihat semua peserta verified.</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('volunteer.search') }}"
           class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:border-orange-300 hover:shadow-md transition group flex items-center gap-4">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center group-hover:bg-orange-600 transition">
                <i class="fas fa-users text-white text-sm"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Semua Peserta Verified</p>
                <p class="text-xs text-gray-400 mt-0.5">Lihat daftar lengkap</p>
            </div>
        </a>
        <a href="{{ route('volunteer.pending-packs') }}"
           class="bg-white rounded-xl shadow-sm border border-orange-100 p-5 hover:border-orange-300 hover:shadow-md transition group flex items-center gap-4">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center group-hover:bg-orange-600 transition">
                <i class="fas fa-box-open text-white text-sm"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Belum Ambil Race Pack</p>
                <p class="text-xs text-gray-400 mt-0.5">Peserta yang belum klaim</p>
            </div>
        </a>
    </div>

</div>
@endsection
