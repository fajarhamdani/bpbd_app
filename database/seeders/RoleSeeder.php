<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan insert batch untuk efisiensi
        Role::insert([
            ['name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'User', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
