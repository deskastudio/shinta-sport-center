<?php
namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            [
                'kd_customer' => 'CST001',
                'nm_customer' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'no_hp' => '08123456789',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'username' => 'budi123',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
            [
                'kd_customer' => 'CST002',
                'nm_customer' => 'Siti Rahma',
                'email' => 'siti@gmail.com',
                'no_hp' => '08198765432',
                'alamat' => 'Jl. Sudirman No. 456, Bandung',
                'username' => 'siti456',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
            [
                'kd_customer' => 'CST003',
                'nm_customer' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'no_hp' => '08111222333',
                'alamat' => 'Jl. Gatot Subroto No. 789, Surabaya',
                'username' => 'ahmad789',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
            [
                'kd_customer' => 'CST004',
                'nm_customer' => 'Deska',
                'email' => 'deska@gmail.com',
                'no_hp' => '08192817263',
                'alamat' => 'Jl. Asia Afrika No. 101, Bekasi',
                'username' => 'deska123',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
            [
                'kd_customer' => 'CST005',
                'nm_customer' => 'Esgegg',
                'email' => 'dimas@gmail.com',
                'no_hp' => '08192728721',
                'alamat' => 'Jl. Kemerdekaan No. 202, Tangerang',
                'username' => 'dimas',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
            [
                'kd_customer' => 'CST006',
                'nm_customer' => '5757rdyrdh',
                'email' => 'superadmin@travedia.com',
                'no_hp' => '080678567966',
                'alamat' => 'Jl. Raya Serpong No. 303, Serpong',
                'username' => 'superadmin@travedia.com',
                'password' => bcrypt('password'),
                'status' => 'aktif'
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}