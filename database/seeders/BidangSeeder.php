<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bidang;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bidang::create([
            'name' => 'sekretariat',
        ]);

        Bidang::create([
            'name' => 'Bidang Pencegahan & Kesiapsiagaan',
        ]);

        Bidang::create([
            'name' => 'Bidang Kedaruratan & Logistik',
        ]);

        Bidang::create([
            'name' => 'Bidang Rehabilitasi & Rekonstruksi',
        ]);

        Bidang::create([
            'name' => 'Pusdalops',
        ]);
    }
}
