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
                'name' => 'Guru',
                'email' => 'guru@gmail.com',
                'role' => 'guru',
                'password' => Hash::make('12345678'),
                'token' => 'GURU123456TOKEN', //Token tetap guru
                'school_name' => 'SD Mekar Arum',
            ],
           
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@gmail.com',
                'role' => 'kepsek', 
                'password' => Hash::make('12345678'),
                'token' => 'KEPSEK28456TOKEN', //Memberikan Nilai Null
                'school_name' => 'SD Mekar Arum',
            ]
        ]);      
    }
}
