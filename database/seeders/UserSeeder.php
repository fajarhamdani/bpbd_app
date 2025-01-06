<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dev-Start',
            'email' => 'Dev-start@gmail.com',
            'password' => bcrypt('Nobody-@9T'),
            'remember_token' => Str::random(10), // Pastikan ini menggunakan Str::random()
            'role_id' => 1, // Sesuaikan dengan role_id yang ada
            'bidang_id' => 1, // Sesuaikan dengan bidang_id yang ada
        ]);

        User::create([
            'name' => 'abc',
            'email' => 'ktm@gmail.com',
            'password' => bcrypt('Nobody-@9T'),
            'remember_token' => Str::random(10), // Pastikan ini menggunakan Str::random()
            'role_id' => 2, // Sesuaikan dengan role_id yang ada
            'bidang_id' => 1, // Sesuaikan dengan bidang_id yang ada
        ]);

        User::create([
            'name' => 'testuser',
            'email' => 'usertest@gmail.com',
            'password' => bcrypt('Nobody-@9T'),
            'remember_token' => Str::random(10), // Pastikan ini menggunakan Str::random()
            'role_id' => 2, // Sesuaikan dengan role_id yang ada
            'bidang_id' => 1, // Sesuaikan dengan bidang_id yang ada
        ]);

        User::create([
            'name' => 'bobby',
            'email' => 'bobby@gmail.com',
            'password' => bcrypt('Nobody-@9T'),
            'remember_token' => Str::random(10), // Pastikan ini menggunakan Str::random()
            'role_id' => 2, // Sesuaikan dengan role_id yang ada
            'bidang_id' => 1, // Sesuaikan dengan bidang_id yang ada
        ]);

        User::create([
            'name' => 'kevin',
            'email' => 'kevin@gmail.com',
            'password' => bcrypt('Nobody-@9T'),
            'remember_token' => Str::random(10), // Pastikan ini menggunakan Str::random()
            'role_id' => 1, // Sesuaikan dengan role_id yang ada
            'bidang_id' => 1, // Sesuaikan dengan bidang_id yang ada
        ]);
        
    }
}
