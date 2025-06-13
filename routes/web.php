<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [CustomerController::class, 'index'])->name('home');
Route::get('/lapangan', [CustomerController::class, 'lapangan'])->name('lapangan');
Route::get('/booking/{kd_lapangan}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking-success/{id}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/cek-booking', [BookingController::class, 'check'])->name('booking.check');
Route::post('/cek-booking', [BookingController::class, 'checkResult'])->name('booking.check.result');

// AJAX route untuk cek slot availability
Route::post('/check-slot-availability', [BookingController::class, 'checkSlotAvailability'])->name('booking.check.slots');