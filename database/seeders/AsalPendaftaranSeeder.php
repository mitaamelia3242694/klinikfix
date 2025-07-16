<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsalPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asal_pendaftaran')->insert([
            [
                'nama' => 'Datang Langsung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rujukan Rumah Sakit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rujukan Puskesmas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Telemedicine',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kunjungan Homecare',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
