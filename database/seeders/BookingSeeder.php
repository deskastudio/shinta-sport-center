<?php
namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $bookings = [
            [
                'kd_customer' => 'CST004',
                'kd_lapangan' => 'LP002',
                'kd_slot' => 'S02',
                'tgl_booking' => '2025-06-13',
                'tgl_main' => '2025-06-13',
                'total_harga' => 45000,
                'status_booking' => 'disetujui',
                'metode_bayar' => 'transfer_bank',
                'catatan' => 'Booking untuk latihan rutin'
            ],
            [
                'kd_customer' => 'CST004',
                'kd_lapangan' => 'LP002',
                'kd_slot' => 'S03',
                'tgl_booking' => '2025-06-13',
                'tgl_main' => '2025-06-13',
                'total_harga' => 45000,
                'status_booking' => 'ditolak',
                'metode_bayar' => 'transfer_bank',
                'catatan' => 'Slot tidak tersedia'
            ],
            [
                'kd_customer' => 'CST004',
                'kd_lapangan' => 'LP001',
                'kd_slot' => 'S03',
                'tgl_booking' => '2025-06-12',
                'tgl_main' => '2025-06-12',
                'total_harga' => 45000,
                'status_booking' => 'pending',
                'metode_bayar' => null,
                'catatan' => 'Menunggu konfirmasi'
            ],
            [
                'kd_customer' => 'CST005',
                'kd_lapangan' => 'LP001',
                'kd_slot' => 'S01',
                'tgl_booking' => '2025-06-11',
                'tgl_main' => '2025-06-11',
                'total_harga' => 45000,
                'status_booking' => 'menunggu_pembayaran',
                'metode_bayar' => 'transfer_bank',
                'catatan' => 'Booking sudah dikonfirmasi'
            ],
            [
                'kd_customer' => 'CST005',
                'kd_lapangan' => 'LP003',
                'kd_slot' => 'S09',
                'tgl_booking' => '2025-06-11',
                'tgl_main' => '2025-06-11',
                'total_harga' => 45000,
                'status_booking' => 'ditolak',
                'metode_bayar' => null,
                'catatan' => 'Pembayaran tidak valid'
            ],
            [
                'kd_customer' => 'CST006',
                'kd_lapangan' => 'LP003',
                'kd_slot' => 'S01',
                'tgl_booking' => '2025-06-11',
                'tgl_main' => '2025-06-11',
                'total_harga' => 45000,
                'status_booking' => 'menunggu_pembayaran',
                'metode_bayar' => 'e_wallet',
                'catatan' => 'Via OVO'
            ],
            [
                'kd_customer' => 'CST002',
                'kd_lapangan' => 'LP001',
                'kd_slot' => 'S02',
                'tgl_booking' => '2025-06-11',
                'tgl_main' => '2025-06-11',
                'total_harga' => 45000,
                'status_booking' => 'pending',
                'metode_bayar' => null,
                'catatan' => 'Booking baru'
            ],
            [
                'kd_customer' => 'CST002',
                'kd_lapangan' => 'LP001',
                'kd_slot' => 'S02',
                'tgl_booking' => '2025-06-11',
                'tgl_main' => '2025-06-11',
                'total_harga' => 45000,
                'status_booking' => 'pending',
                'metode_bayar' => null,
                'catatan' => 'Duplicate booking test'
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}