@extends('layouts.customer')

@section('title', 'Booking Berhasil - Shinta Sport Center')

@section('content')
<section class="py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <span class="text-3xl text-green-600">✓</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Berhasil!</h1>
            <p class="text-gray-600">Terima kasih telah melakukan booking di Shinta Sport Center</p>
        </div>

        <!-- Booking Details -->
        <div class="card mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Booking</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Booking:</span>
                        <span class="font-semibold">#{{ $booking->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold">{{ $booking->customer->nm_customer }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $booking->customer->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. HP:</span>
                        <span class="font-semibold">{{ $booking->customer->no_hp }}</span>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Lapangan:</span>
                        <span class="font-semibold">{{ $booking->lapangan->nm_lapangan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Main:</span>
                        <span class="font-semibold">{{ date('d/m/Y', strtotime($booking->tgl_main)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Slot Waktu:</span>
                        <span class="font-semibold">{{ $booking->slotWaktu->display_waktu }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Bayar:</span>
                        <span class="text-xl font-bold text-primary-600">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Status:</span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                        Menunggu Verifikasi
                    </span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="card bg-blue-50 border-blue-200">
            <h3 class="font-semibold text-blue-800 mb-3">Langkah Selanjutnya:</h3>
            <ol class="list-decimal list-inside space-y-2 text-blue-700">
                <li>Admin akan memverifikasi bukti pembayaran Anda</li>
                <li>Anda akan mendapat konfirmasi melalui email</li>
                <li>Datang 15 menit sebelum waktu bermain</li>
                <li>Tunjukkan email konfirmasi ke petugas</li>
            </ol>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <a href="{{ route('home') }}" 
               class="btn-secondary text-center">
                Kembali ke Home
            </a>
            <a href="{{ route('booking.check') }}" 
               class="btn-primary text-center">
                Cek Status Booking
            </a>
            <a href="{{ route('lapangan') }}" 
               class="btn-primary text-center">
                Booking Lagi
            </a>
        </div>
    </div>
</section>
@endsection