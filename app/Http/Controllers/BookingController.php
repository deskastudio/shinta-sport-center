<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\SlotWaktu;
use App\Models\Customer;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create($kd_lapangan)
    {
        $lapangan = Lapangan::findOrFail($kd_lapangan);
        $slots = SlotWaktu::where('status', 'aktif')->orderBy('jam_mulai')->get();
        
        return view('customer.booking', compact('lapangan', 'slots'));
    }

    // Method untuk cek ketersediaan slot via AJAX
    public function checkSlotAvailability(Request $request)
    {
        $kd_lapangan = $request->kd_lapangan;
        $tgl_main = $request->tgl_main;
        
        if (!$kd_lapangan || !$tgl_main) {
            return response()->json(['error' => 'Parameter tidak lengkap'], 400);
        }

        // Get booked slots for the selected date and lapangan
        $bookedSlots = Booking::where('kd_lapangan', $kd_lapangan)
            ->where('tgl_main', $tgl_main)
            ->whereIn('status_booking', ['pending', 'disetujui', 'menunggu_pembayaran', 'main_hari_ini'])
            ->pluck('kd_slot')
            ->toArray();

        // Check for past slots if date is today
        $pastSlots = [];
        $selectedDate = Carbon::parse($tgl_main);
        $today = Carbon::today();
        
        if ($selectedDate->isSameDay($today)) {
            $currentTime = Carbon::now()->format('H:i:s');
            
            // Get slots that have already started (jam_mulai <= current time)
            // Slot dianggap terlewat jika jam mulainya sudah lewat
            $pastSlots = SlotWaktu::where('jam_mulai', '<=', $currentTime)
                ->pluck('kd_slot')
                ->toArray();
        }

        return response()->json([
            'booked_slots' => $bookedSlots,
            'past_slots' => $pastSlots,
            'current_time' => Carbon::now()->format('H:i'),
            'is_today' => $selectedDate->isSameDay($today),
            'debug_current_time' => Carbon::now()->format('H:i:s') // untuk debugging
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_customer' => 'required|string|max:50',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'kd_lapangan' => 'required|exists:lapangans,kd_lapangan',
            'kd_slot' => 'required|exists:slot_waktus,kd_slot',
            'tgl_main' => 'required|date|after_or_equal:today',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if slot has passed today
        if ($request->tgl_main == date('Y-m-d')) {
            $slot = SlotWaktu::find($request->kd_slot);
            $currentTime = Carbon::now()->format('H:i:s');
            
            if ($slot && $slot->jam_mulai <= $currentTime) {
                return back()->with('error', 'Maaf, slot waktu yang dipilih sudah terlewat. Saat ini pukul ' . Carbon::now()->format('H:i'))
                            ->withInput();
            }
        }

        // Double check if slot is available (server-side validation)
        $isBooked = Booking::where('kd_lapangan', $request->kd_lapangan)
            ->where('kd_slot', $request->kd_slot)
            ->where('tgl_main', $request->tgl_main)
            ->whereIn('status_booking', ['pending', 'disetujui', 'menunggu_pembayaran', 'main_hari_ini'])
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Maaf, slot waktu yang dipilih sudah tidak tersedia.')
                        ->withInput();
        }

        // Create or find customer
        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            $customerCount = Customer::count() + 1;
            $customer = Customer::create([
                'kd_customer' => 'CST' . str_pad($customerCount, 3, '0', STR_PAD_LEFT),
                'nm_customer' => $request->nm_customer,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'username' => $request->email,
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ]);
        }

        // Get lapangan price
        $lapangan = Lapangan::find($request->kd_lapangan);

        // Handle file upload
        $buktiPath = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiPath = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        // Create booking
        $booking = Booking::create([
            'kd_customer' => $customer->kd_customer,
            'kd_lapangan' => $request->kd_lapangan,
            'kd_slot' => $request->kd_slot,
            'tgl_booking' => now()->toDateString(),
            'tgl_main' => $request->tgl_main,
            'total_harga' => $lapangan->harga_per_jam,
            'status_booking' => 'pending',
            'metode_bayar' => 'transfer_bank',
            'bukti_bayar' => $buktiPath,
            'catatan' => $request->catatan ?? 'Booking dari website'
        ]);

        return redirect()->route('booking.success', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Menunggu konfirmasi admin.');
    }

    public function success($id)
    {
        $booking = Booking::with(['customer', 'lapangan', 'slotWaktu'])->findOrFail($id);
        return view('customer.booking-success', compact('booking'));
    }

    public function check()
    {
        return view('customer.check-booking');
    }

    public function checkResult(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        
        if (!$customer) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $bookings = Booking::with(['lapangan', 'slotWaktu'])
            ->where('kd_customer', $customer->kd_customer)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.booking-list', compact('bookings', 'customer'));
    }
}