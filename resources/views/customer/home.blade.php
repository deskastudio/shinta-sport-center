@extends('layouts.customer')

@section('title', 'Home - Shinta Sport Center')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Shinta Sport Center
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-primary-100">
                Lapangan Badminton Premium dengan Fasilitas Terbaik
            </p>
            <div class="space-x-4">
                <a href="{{ route('lapangan') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Lihat Lapangan
                </a>
                <a href="{{ route('booking.check') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors">
                    Cek Booking
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="card">
                <div class="text-3xl text-primary-600 mb-4">🏸</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $totalLapangan }}</h3>
                <p class="text-gray-600">Lapangan Tersedia</p>
            </div>
            <div class="card">
                <div class="text-3xl text-primary-600 mb-4">⏰</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $totalSlot }}</h3>
                <p class="text-gray-600">Slot Waktu</p>
            </div>
            <div class="card">
                <div class="text-3xl text-primary-600 mb-4">👥</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $totalBooking }}+</h3>
                <p class="text-gray-600">Customer Booking</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
            Mengapa Memilih Shinta Sport Center?
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-primary-600">🏢</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Lapangan Indoor</h3>
                <p class="text-gray-600 text-sm">Lapangan indoor ber-AC dengan lantai kayu berkualitas tinggi</p>
            </div>
            <div class="text-center">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-primary-600">💡</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Pencahayaan LED</h3>
                <p class="text-gray-600 text-sm">Pencahayaan LED yang terang dan tidak menyilaukan</p>
            </div>
            <div class="text-center">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-primary-600">🎵</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Sound System</h3>
                <p class="text-gray-600 text-sm">Sound system berkualitas untuk pengalaman bermain yang lebih seru</p>
            </div>
            <div class="text-center">
                <div class="bg-primary-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl text-primary-600">🅿️</span>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Parkir Luas</h3>
                <p class="text-gray-600 text-sm">Area parkir yang luas dan aman untuk kendaraan Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-primary-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap untuk Bermain?</h2>
        <p class="text-xl mb-8 text-primary-100">
            Booking lapangan sekarang dan nikmati pengalaman bermain badminton terbaik!
        </p>
        <a href="{{ route('lapangan') }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            Booking Sekarang
        </a>
    </div>
</section>
@endsection