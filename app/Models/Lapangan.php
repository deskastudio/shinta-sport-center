<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_lapangan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_lapangan',
        'nm_lapangan', 
        'jenis_lapangan',
        'harga_per_jam',
        'status',
        'deskripsi',
        'foto'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kd_lapangan');
    }
}