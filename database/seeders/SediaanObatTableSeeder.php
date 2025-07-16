<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SediaanObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sediaan_obat')->insert([
            ['obat_id' => 1,  'tanggal_kadaluarsa' => '2026-12-31', 'tanggal_masuk' => '2025-01-01', 'keterangan' => 'Batch A1'],
            ['obat_id' => 2,  'tanggal_kadaluarsa' => '2026-08-15', 'tanggal_masuk' => '2025-02-10', 'keterangan' => 'Batch B1'],
            ['obat_id' => 3,  'tanggal_kadaluarsa' => '2026-05-10', 'tanggal_masuk' => '2025-03-12', 'keterangan' => 'Batch C1'],
            ['obat_id' => 4,  'tanggal_kadaluarsa' => '2026-09-01', 'tanggal_masuk' => '2025-04-22', 'keterangan' => 'Batch D1'],
            ['obat_id' => 5,  'tanggal_kadaluarsa' => '2026-11-20', 'tanggal_masuk' => '2025-05-15', 'keterangan' => 'Batch E1'],
        ]);
    }
}
