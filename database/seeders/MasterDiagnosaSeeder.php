<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterDiagnosaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('master_diagnosa')->insert([
            [
                'nama' => 'Hipertensi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Diabetes Mellitus Tipe 2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'ISPA (Infeksi Saluran Pernapasan Akut)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Gastritis (Radang Lambung)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Demam Berdarah Dengue (DBD)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
