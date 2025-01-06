<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data pegawai yang akan dimasukkan
        $data = [
            [
                'name' => 'John Doe',
                'nip' => '123456789012345678',
                'bidang_id' => 1, // Pastikan ini sesuai dengan ID bidang yang ada
            ],
            [
                'name' => 'Jane Smith',
                'nip' => '234567890123456789',
                'bidang_id' => 2,
            ],
            [
                'name' => 'Alice Johnson',
                'nip' => '345678901234567890',
                'bidang_id' => 3,
            ],
            [
                'name' => 'Bob Brown',
                'nip' => '456789012345678901',
                'bidang_id' => 1,
            ],
            [
                'name' => 'Charlie Davis',
                'nip' => '567890123456789012',
                'bidang_id' => 2,
            ],
            // Tambahkan pegawai lainnya sesuai kebutuhan
        ];

        // Menyisipkan data ke dalam tabel pegawai
        DB::table('pegawai')->insert($data);
    }
}
