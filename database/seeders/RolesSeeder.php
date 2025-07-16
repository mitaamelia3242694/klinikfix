<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nama_role' => 'Admin IT'],
            ['nama_role' => 'Admin Pendaftaran'],
            ['nama_role' => 'Dokter'],
            ['nama_role' => 'Perawat'],
            ['nama_role' => 'Apoteker'],
            ['nama_role' => 'Admin Stok Obat'],
        ]);
    }
}
