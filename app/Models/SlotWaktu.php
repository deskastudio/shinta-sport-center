<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SlotWaktu extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_slot';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_slot',
        'jam_mulai',
        'jam_selesai', 
        'display_waktu',
        'status'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kd_slot');
    }

    // Helper method to check if slot has passed today
    public function hasPassedToday()
    {
        $currentTime = Carbon::now()->format('H:i:s');
        // Slot dianggap terlewat jika jam mulainya sudah lewat
        return $this->jam_mulai <= $currentTime;
    }

    // Helper method to check if slot is available for a specific date and lapangan
    public function isAvailableFor($kd_lapangan, $tgl_main)
    {
        // Check if slot is already booked
        $isBooked = Booking::where('kd_lapangan', $kd_lapangan)
            ->where('kd_slot', $this->kd_slot)
            ->where('tgl_main', $tgl_main)
            ->whereIn('status_booking', ['pending', 'disetujui', 'menunggu_pembayaran', 'main_hari_ini'])
            ->exists();

        if ($isBooked) {
            return false;
        }

        // Check if slot has passed (only for today)
        $selectedDate = Carbon::parse($tgl_main);
        $today = Carbon::today();
        
        if ($selectedDate->isSameDay($today) && $this->hasPassedToday()) {
            return false;
        }

        return true;
    }
}