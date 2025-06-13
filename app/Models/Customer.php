<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'kd_customer';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_customer',
        'nm_customer',
        'email',
        'no_hp',
        'alamat',
        'username',
        'password',
        'status'
    ];

    protected $hidden = ['password'];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kd_customer');
    }
}