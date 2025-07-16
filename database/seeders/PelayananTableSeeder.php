<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PelayananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelayanan')->insert([
            ['nama_pelayanan' => 'Pemeriksaan Umum', 'deskripsi' => 'Layanan pemeriksaan kesehatan umum', 'biaya' => 50000, 'status' => 'Aktif'],
            ['nama_pelayanan' => 'Konsultasi Dokter Gigi', 'deskripsi' => 'Layanan konsultasi dokter gigi', 'biaya' => 75000, 'status' => 'Aktif'],
            ['nama_pelayanan' => 'Laboratorium', 'deskripsi' => 'Layanan pemeriksaan laboratorium', 'biaya' => 100000, 'status' => 'Aktif'],
            ['nama_pelayanan' => 'Imunisasi', 'deskripsi' => 'Layanan pemberian vaksin dan imunisasi', 'biaya' => 45000, 'status' => 'Aktif'],
            ['nama_pelayanan' => 'Kesehatan Ibu & Anak', 'deskripsi' => 'Layanan untuk ibu hamil dan anak-anak', 'biaya' => 65000, 'status' => 'Aktif'],
        ]);
    }
}
