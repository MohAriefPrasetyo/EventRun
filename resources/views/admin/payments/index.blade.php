@use(Illuminate\Support\Facades\Storage)
@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Verifikasi Pembayaran</h2>
    <p class="text-sm text-gray-500 mt-1">Daftar peserta yang menunggu konfirmasi pembayaran</p>
</div>

@if($registrations->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <i class="fas fa-check-circle text-green-400 text-5xl mb-4 block"></i>
        <p class="text-gray-600 font-medium">Semua pembayaran sudah diverifikasi</p>
        <p class="text-gray-400 text-sm mt-1">Tidak ada pembayaran yang menunggu konfirmasi</p>
    </div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Event & Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti Bayar</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($registrations as $reg)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800 text-sm">{{ $reg->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $reg->user->email }}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-800">{{ $reg->ticketCategory->event->name }}</p>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 bg-blue-100 text-orange-700 rounded-full">
                        {{ $reg->ticketCategory->category_name }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($reg->payment_proof)
                        <a href="{{ Storage::url($reg->payment_proof) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-sm text-orange-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-image"></i> Lihat Bukti
                        </a>
                    @else
                        <span class="text-xs text-gray-400 italic">Tidak ada file</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $reg->updated_at->format('d M Y H:i') }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <form action="{{ route('admin.payments.approve', $reg) }}" method="POST"
                              onsubmit="return confirm('Setujui pembayaran {{ $reg->user->name }}?')">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.payments.reject', $reg) }}" method="POST" class="flex items-center gap-2"
                              onsubmit="return confirm('Tolak pembayaran {{ $reg->user->name }}?')">
                            @csrf
                            <input type="text" name="reason" placeholder="Alasan penolakan..."
                                   class="border border-gray-300 rounded-lg px-3 py-1.5 text-xs w-40 focus:outline-none focus:ring-2 focus:ring-red-300">
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($registrations->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $registrations->links() }}
        </div>
    @endif
</div>
@endif

@endsection
