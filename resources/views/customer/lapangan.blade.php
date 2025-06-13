@extends('layouts.customer')

@section('title', 'Lapangan - Shinta Sport Center')

@section('content')
<!-- Page Header -->
<section class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Lapangan Badminton</h1>
        <p class="text-xl text-primary-100">Pilih lapangan terbaik untuk pengalaman bermain yang sempurna</p>
    </div>
</section>

<!-- Lapangan List -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($lapangans as $lapangan)
            <div class="card hover:shadow-lg transition-shadow">
                <!-- Lapangan Image -->
                <div class="mb-6">
                    @if($lapangan->foto)
                        <img src="{{ asset('storage/' . $lapangan->foto) }}" 
                             alt="{{ $lapangan->nm_lapangan }}" 
                             class="w-full h-48 object-cover rounded-lg">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <span class="text-4xl text-primary-600">🏸</span>
                                <p class="text-primary-700 font-semibold mt-2">{{ $lapangan->nm_lapangan }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Lapangan Info -->
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $lapangan->nm_lapangan }}</h3>
                    <div class="flex items-center mb-2">
                        <span class="bg-primary-100 text-primary-800 px-2 py-1 rounded-full text-sm font-medium">
                            {{ $lapangan->jenis_lapangan }}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">{{ $lapangan->deskripsi }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-primary-600">
                            Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-500 text-sm">/jam</span>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="pt-4 border-t">
                    <a href="{{ route('booking.create', $lapangan->kd_lapangan) }}" 
                       class="w-full bg-primary-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors block">
                        Booking Sekarang
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if($lapangans->isEmpty())
        <div class="text-center py-12">
            <span class="text-6xl text-gray-300">🏸</span>
            <h3 class="text-xl font-semibold text-gray-600 mt-4">Belum ada lapangan tersedia</h3>
            <p class="text-gray-500 mt-2">Silakan cek kembali nanti</p>
        </div>
        @endif
    </div>
</section>
@endsection