@extends('layouts.customer')

@section('title', 'Riwayat Booking - Shinta Sport Center')

@section('content')
<!-- Page Header -->
<section class="bg-primary-600 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Riwayat Booking</h1>
                <p class="text-primary-100">{{ $customer->nm_customer }} ({{ $customer->email }})</p>
            </div>
            <a href="{{ route('booking.check') }}" class="text-white hover:text-primary-200">
                ← Kembali
            </a>
        </div>
    </div>
</section>

<!-- Booking List -->
<section class="py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                <div class="card hover:shadow-lg transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-4 mb-3">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $booking->lapangan->nm_lapangan }}
                                </h3>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($booking->status_booking == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status_booking == 'disetujui') bg-green-100 text-green-800
                                    @elseif($booking->status_booking == 'ditolak') bg-red-100 text-red-800
                                    @elseif($booking->status_booking == 'menunggu_pembayaran') bg-blue-100 text-blue-800
                                    @elseif($booking->status_booking == 'main_hari_ini') bg-purple-100 text-purple-800
                                    @endif">
                                    @if($booking->status_booking == 'pending') Menunggu Verifikasi
                                    @elseif($booking->status_booking == 'disetujui') Disetujui
                                    @elseif($booking->status_booking == 'ditolak') Ditolak
                                    @elseif($booking->status_booking == 'menunggu_pembayaran') Menunggu Pembayaran
                                    @elseif($booking->status_booking == 'main_hari_ini') Main Hari Ini
                                    @endif
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">ID Booking:</span>
                                    <p class="font-medium">#{{ $booking->id }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Tanggal Main:</span>
                                    <p class="font-medium">{{ date('d/m/Y', strtotime($booking->tgl_main)) }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Slot Waktu:</span>
                                    <p class="font-medium">{{ $booking->slotWaktu->display_waktu }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Total:</span>
                                    <p class="font-bold text-primary-600">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            
                            @if($booking->catatan)
                            <div class="mt-3 pt-3 border-t">
                                <span class="text-gray-500 text-sm">Catatan:</span>
                                <p class="text-sm text-gray-700">{{ $booking->catatan }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-4 md:mt-0 md:ml-6">
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Dibuat:</p>
                                <p class="text-sm font-medium">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <span class="text-6xl text-gray-300">📝</span>
                <h3 class="text-xl font-semibold text-gray-600 mt-4">Belum ada booking</h3>
                <p class="text-gray-500 mt-2 mb-6">Anda belum pernah melakukan booking</p>
                <a href="{{ route('lapangan') }}" class="btn-primary">
                    Booking Sekarang
                </a>
            </div>
        @endif
    </div>
</section>
@endsection