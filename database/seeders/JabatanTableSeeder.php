<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('jabatan')->insert([
            ['nama_jabatan' => 'Dokter Umum'],
            ['nama_jabatan' => 'Perawat Pelaksana'],
            ['nama_jabatan' => 'Kepala Ruangan'],
            ['nama_jabatan' => 'Apoteker'],
            ['nama_jabatan' => 'Admin Stok Obat'],
        ]);
    }
}
