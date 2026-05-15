@extends('layouts.app')

@section('title', 'Volunteer Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Cari Peserta</h1>
    <form method="GET" action="{{ route('volunteer.search') }}">
        <div class="flex gap-2">
            <input type="text" name="q" placeholder="Nama atau Nomor Registrasi" class="flex-1 border rounded px-3 py-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
        </div>
    </form>
</div>
@endsection