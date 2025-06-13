<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kd_customer',
        'kd_lapangan', 
        'kd_slot',
        'tgl_booking',
        'tgl_main',
        'total_harga',
        'status_booking',
        'metode_bayar',
        'bukti_bayar',
        'catatan'
    ];

    // Relasi dengan Customer, Lapangan, dan SlotWaktu
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kd_customer');
    }

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'kd_lapangan');
    }

    public function slotWaktu()
    {
        return $this->belongsTo(SlotWaktu::class, 'kd_slot');
    }
}