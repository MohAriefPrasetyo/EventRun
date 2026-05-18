<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EventRun - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-orange-50 min-h-screen">

@auth
@php $role = Auth::user()->role; @endphp

{{-- Top Navbar --}}
<nav class="bg-gray-900 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-running text-white text-sm"></i>
                </div>
                <span class="text-lg font-bold tracking-tight">EventRun</span>
            </div>

            {{-- Nav Links --}}
            <div class="flex items-center gap-1">
                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.events.index') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.events*') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-calendar-alt"></i> Kelola Event
                    </a>
                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('admin.payments*') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-credit-card"></i> Verifikasi Pembayaran
                    </a>

                @elseif($role === 'volunteer')
                    <a href="{{ route('volunteer.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('volunteer.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('volunteer.search') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('volunteer.search') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-search"></i> Cari Peserta
                    </a>
                    <a href="{{ route('volunteer.pending-packs') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('volunteer.pending-packs') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-box-open"></i> Belum Ambil Race Pack
                    </a>
                    <a href="{{ route('volunteer.claimed-packs') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('volunteer.claimed-packs') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-check-circle"></i> Sudah Ambil Race Pack
                    </a>

                @else
                    <a href="{{ route('participant.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('participant.dashboard') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('participant.select-event') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('participant.select-event') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-ticket-alt"></i> Daftar Event
                    </a>
                    <a href="{{ route('participant.registrations.index') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm transition
                              {{ request()->routeIs('participant.registrations*') ? 'bg-orange-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        <i class="fas fa-list"></i> Pendaftaran Saya
                    </a>
                @endif
            </div>

            {{-- User & Logout --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-7 h-7 bg-orange-500 rounded-full flex items-center justify-center text-xs font-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-gray-300 hidden md:block">{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm text-gray-300 hover:bg-red-600 hover:text-white transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="hidden md:block">Logout</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

{{-- Main Content --}}
<main class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-times-circle text-red-500"></i> {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="flex items-center gap-3 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-triangle text-yellow-500"></i> {{ session('warning') }}
        </div>
    @endif
    @yield('content')
</main>

@else
{{-- Guest layout --}}
<nav class="bg-white shadow-sm border-b border-orange-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-2 text-orange-500 font-bold text-xl">
        <i class="fas fa-running"></i>
        <span>EventRun</span>
    </div>
</nav>
<main class="min-h-screen flex items-center justify-center py-12 px-4">
    @yield('content')
</main>
@endauth

</body>
</html>
