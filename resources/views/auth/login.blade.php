@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-running text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">EventRun</h1>
        <p class="text-gray-500 text-sm mt-1">Masuk ke akun Anda</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="email"
                       placeholder="nama@email.com"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:text-orange-600">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg transition text-sm">
                Masuk
            </button>
        </form>

        @if (Route::has('register'))
        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 font-medium">Daftar sekarang</a>
        </p>
        @endif
    </div>
</div>
@endsection
