<?php
namespace Database\Seeders;

use App\Models\SlotWaktu;
use Illuminate\Database\Seeder;

class SlotWaktuSeeder extends Seeder
{
    public function run()
    {
        $slots = [
            ['kd_slot' => 'S01', 'jam_mulai' => '10:00', 'jam_selesai' => '11:00', 'display_waktu' => '10:00 - 11:00'],
            ['kd_slot' => 'S02', 'jam_mulai' => '11:00', 'jam_selesai' => '12:00', 'display_waktu' => '11:00 - 12:00'],
            ['kd_slot' => 'S03', 'jam_mulai' => '12:00', 'jam_selesai' => '13:00', 'display_waktu' => '12:00 - 13:00'],
            ['kd_slot' => 'S04', 'jam_mulai' => '13:00', 'jam_selesai' => '14:00', 'display_waktu' => '13:00 - 14:00'],
            ['kd_slot' => 'S05', 'jam_mulai' => '14:00', 'jam_selesai' => '15:00', 'display_waktu' => '14:00 - 15:00'],
            ['kd_slot' => 'S06', 'jam_mulai' => '15:00', 'jam_selesai' => '16:00', 'display_waktu' => '15:00 - 16:00'],
            ['kd_slot' => 'S07', 'jam_mulai' => '16:00', 'jam_selesai' => '17:00', 'display_waktu' => '16:00 - 17:00'],
            ['kd_slot' => 'S08', 'jam_mulai' => '17:00', 'jam_selesai' => '18:00', 'display_waktu' => '17:00 - 18:00'],
            ['kd_slot' => 'S09', 'jam_mulai' => '18:00', 'jam_selesai' => '19:00', 'display_waktu' => '18:00 - 19:00'],
            ['kd_slot' => 'S10', 'jam_mulai' => '19:00', 'jam_selesai' => '20:00', 'display_waktu' => '19:00 - 20:00'],
            ['kd_slot' => 'S11', 'jam_mulai' => '20:00', 'jam_selesai' => '21:00', 'display_waktu' => '20:00 - 21:00'],
            ['kd_slot' => 'S12', 'jam_mulai' => '21:00', 'jam_selesai' => '22:00', 'display_waktu' => '21:00 - 22:00'],
            ['kd_slot' => 'S13', 'jam_mulai' => '22:00', 'jam_selesai' => '23:00', 'display_waktu' => '22:00 - 23:00'],
            ['kd_slot' => 'S14', 'jam_mulai' => '23:00', 'jam_selesai' => '24:00', 'display_waktu' => '23:00 - 24:00'],
        ];

        foreach ($slots as $slot) {
            SlotWaktu::create([
                'kd_slot' => $slot['kd_slot'],
                'jam_mulai' => $slot['jam_mulai'],
                'jam_selesai' => $slot['jam_selesai'],
                'display_waktu' => $slot['display_waktu'],
                'status' => 'aktif'
            ]);
        }
    }
}