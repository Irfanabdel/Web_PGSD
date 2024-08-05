<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Menggunakan fasilitas DB dari facade
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'guru',
                'email' => 'guru@gmail.com',
                'role' => 'guru',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'siswa A',
                'email' => 'siswaA@gmail.com',
                'role' => 'siswa',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'kepsek',
                'email' => 'kepsek@gmail.com',
                'role' => 'kepsek', 
                'password' => Hash::make('12345678'),
            ]
        ]);
        DB::table('komen')->insert([
            [
                'title' => 'Forum Diskusi Bersama',
            ],
           
        ]);
        
    }
}
