<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResepTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('resep')->insert([
            [
                'pasien_id' => 1,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-01'),
                'catatan' => 'Paracetamol 500mg, diminum 3x sehari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-03'),
                'catatan' => 'Amoxicillin 500mg, 3x sehari setelah makan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-06'),
                'catatan' => 'Ranitidine 150mg, 2x sehari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-08'),
                'catatan' => 'Ibuprofen 400mg, jika nyeri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-10'),
                'catatan' => 'Salep kortikosteroid, oleskan 2x sehari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}