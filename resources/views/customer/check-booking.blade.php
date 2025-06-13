@extends('layouts.customer')

@section('title', 'Cek Booking - Shinta Sport Center')

@section('content')
<!-- Page Header -->
<section class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Cek Status Booking</h1>
        <p class="text-xl text-primary-100">Masukkan email untuk melihat riwayat booking Anda</p>
    </div>
</section>

<!-- Check Form -->
<section class="py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-4">
                    <span class="text-2xl text-primary-600">📧</span>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Cek Booking Anda</h2>
            </div>
            
            <form action="{{ route('booking.check.result') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="Masukkan email Anda"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" 
                        class="w-full btn-primary">
                    Cek Booking
                </button>
            </form>
        </div>
    </div>
</section>
@endsection