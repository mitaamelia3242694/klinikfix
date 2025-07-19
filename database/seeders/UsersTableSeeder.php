<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'adminit',
                'password' => Hash::make('admin123'),
                'role_id' => 1, // Admin IT
                'nama_lengkap' => 'Admin Teknologi',
                'email' => 'adminit@klinik.com',
                'status' => 'aktif',
            ],
            [
                'username' => 'pendaftaran1',
                'password' => Hash::make('pendaftaran123'),
                'role_id' => 2, // Admin Pendaftaran
                'nama_lengkap' => 'Petugas Pendaftaran',
                'email' => 'daftar@klinik.com',
                'status' => 'aktif',
            ],
            [
                'username' => 'dr_joko',
                'password' => Hash::make('dokter123'),
                'role_id' => 3, // Dokter
                'nama_lengkap' => 'Dr. Joko Santoso',
                'email' => 'joko@klinik.com',
                'status' => 'aktif',
            ],
            [
                'username' => 'nurse_ina',
                'password' => Hash::make('perawat123'),
                'role_id' => 4, // Perawat
                'nama_lengkap' => 'Ina Susanti',
                'email' => 'ina@klinik.com',
                'status' => 'aktif',
            ],
            [
                'username' => 'apoteker_andi',
                'password' => Hash::make('apoteker123'),
                'role_id' => 5, // Apoteker
                'nama_lengkap' => 'Andi Pratama',
                'email' => 'andi@klinik.comandi@klinik.com',
                'status' => 'aktif',
            ],

            [
                'username' => 'admin_stok_obat',
                'password' => Hash::make('admin1234'),
                'role_id' => 6, // Apoteker
                'nama_lengkap' => 'Ana Utami',
                'email' => 'ana@klinik.com',
                'status' => 'aktif',
            ],
        ]);
    }
}
