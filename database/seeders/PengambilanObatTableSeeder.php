<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengambilanObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengambilan_obat')->insert([
            [
                'resep_id' => 1,
                'user_id' => 5, // ID apoteker atau user pengelola obat
                'tanggal_pengambilan' => Carbon::parse('2025-06-02'),
                'status_checklist' => 'Lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 2,
                'user_id' => 5,
                'tanggal_pengambilan' => Carbon::parse('2025-06-04'),
                'status_checklist' => 'Tidak Lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 3,
                'user_id' => 5,
                'tanggal_pengambilan' => Carbon::parse('2025-06-06'),
                'status_checklist' => 'Lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 4,
                'user_id' => 5,
                'tanggal_pengambilan' => Carbon::parse('2025-06-08'),
                'status_checklist' => 'Lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 5,
                'user_id' => 5,
                'tanggal_pengambilan' => Carbon::parse('2025-06-10'),
                'status_checklist' => 'Lengkap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
