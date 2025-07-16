<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResepDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('resep_detail')->insert([
            [
                'resep_id' => 1,
                'obat_id' => 1,
                'jumlah' => 10,
                'dosis' => '500mg',
                'aturan_pakai' => '3x sehari setelah makan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 2,
                'obat_id' => 2,
                'jumlah' => 15,
                'dosis' => '500mg',
                'aturan_pakai' => '3x sehari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 3,
                'obat_id' => 3,
                'jumlah' => 10,
                'dosis' => '150mg',
                'aturan_pakai' => '2x sehari sebelum makan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 4,
                'obat_id' => 4,
                'jumlah' => 5,
                'dosis' => '400mg',
                'aturan_pakai' => 'Jika nyeri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'resep_id' => 5,
                'obat_id' => 5,
                'jumlah' => 1,
                'dosis' => 'Salep',
                'aturan_pakai' => 'Oles 2x sehari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
