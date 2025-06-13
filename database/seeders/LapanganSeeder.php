<?php
namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run()
    {
        $lapangans = [
            [
                'kd_lapangan' => 'LP001',
                'nm_lapangan' => 'Lapangan Badminton 1',
                'jenis_lapangan' => 'Indoor',
                'harga_per_jam' => 45000,
                'status' => 'tersedia',
                'deskripsi' => 'Lapangan indoor dengan lantai kayu berkualitas tinggi dan pencahayaan LED'
            ],
            [
                'kd_lapangan' => 'LP002',
                'nm_lapangan' => 'Lapangan Badminton 2',
                'jenis_lapangan' => 'Indoor',
                'harga_per_jam' => 45000,
                'status' => 'tersedia',
                'deskripsi' => 'Lapangan indoor dengan AC dan sound system untuk kenyamanan bermain'
            ],
            [
                'kd_lapangan' => 'LP003',
                'nm_lapangan' => 'Lapangan Badminton 3',
                'jenis_lapangan' => 'Indoor',
                'harga_per_jam' => 45000,
                'status' => 'tersedia',
                'deskripsi' => 'Lapangan indoor premium dengan fasilitas lengkap dan area istirahat'
            ],
        ];

        foreach ($lapangans as $lapangan) {
            Lapangan::create($lapangan);
        }
    }
}