<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\SlotWaktu;
use App\Models\Booking;

class CustomerController extends Controller
{
    public function index()
    {
        $totalLapangan = Lapangan::where('status', 'tersedia')->count();
        $totalSlot = SlotWaktu::where('status', 'aktif')->count();
        $totalBooking = Booking::count();
        
        return view('customer.home', compact('totalLapangan', 'totalSlot', 'totalBooking'));
    }

    public function lapangan()
    {
        $lapangans = Lapangan::where('status', 'tersedia')->get();
        return view('customer.lapangan', compact('lapangans'));
    }
}