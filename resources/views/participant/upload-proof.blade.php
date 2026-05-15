@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran')

@section('content')

<div class="mb-6">
    <a href="{{ route('participant.registrations.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
        <i class="fas fa-arrow-left"></i> Kembali ke Pendaftaran Saya
    </a>
</div>

<div class="max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-8">

        {{-- Info Registrasi --}}
        <div class="bg-orange-50 rounded-lg p-4 mb-6">
            <p class="text-xs text-orange-600 font-semibold uppercase tracking-wider mb-2">Detail Pendaftaran</p>
            <p class="font-semibold text-gray-800">{{ $registration->ticketCategory->event->name }}</p>
            <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                <span class="flex items-center gap-1">
                    <i class="fas fa-running text-orange-400"></i>
                    {{ $registration->ticketCategory->category_name }}
                </span>
                <span class="flex items-center gap-1">
                    <i class="fas fa-tag text-orange-400"></i>
                    Rp {{ number_format($registration->ticketCategory->price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <h2 class="text-lg font-bold text-gray-800 mb-1">Upload Bukti Pembayaran</h2>
        <p class="text-sm text-gray-500 mb-6">Upload foto atau PDF bukti transfer pembayaran kamu</p>

        <form method="POST" action="{{ route('participant.upload.proof', $registration) }}"
              enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    File Bukti Transfer <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-orange-200 rounded-lg p-6 text-center hover:border-orange-400 transition">
                    <i class="fas fa-cloud-upload-alt text-orange-400 text-3xl mb-2 block"></i>
                    <p class="text-sm text-gray-500 mb-3">JPG, PNG, atau PDF — maks. 2MB</p>
                    <input type="file" name="payment_proof" accept="image/*,application/pdf" required
                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-500 file:text-white hover:file:bg-orange-600 file:cursor-pointer">
                </div>
                @error('payment_proof')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-paper-plane"></i> Kirim Bukti
                </button>
                <a href="{{ route('participant.registrations.index') }}"
                   class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
