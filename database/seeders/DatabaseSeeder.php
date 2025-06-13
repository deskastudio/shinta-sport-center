<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LapanganSeeder::class,
            SlotWaktuSeeder::class,
            CustomerSeeder::class,
            BookingSeeder::class,
        ]);
    }
}