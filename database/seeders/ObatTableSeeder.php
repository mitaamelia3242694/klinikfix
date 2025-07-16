<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('obat')->insert([
            ['nama_obat' => 'Paracetamol', 'satuan_id' => 1, 'stok_total' => 100, 'keterangan' => 'Obat demam dan nyeri'],
            ['nama_obat' => 'Amoxicillin', 'satuan_id' => 2, 'stok_total' => 80, 'keterangan' => 'Antibiotik'],
            ['nama_obat' => 'OBH Combi', 'satuan_id' => 3, 'stok_total' => 50, 'keterangan' => 'Obat batuk'],
            ['nama_obat' => 'Neurobion', 'satuan_id' => 1, 'stok_total' => 60, 'keterangan' => 'Vitamin B'],
            ['nama_obat' => 'Betadine', 'satuan_id' => 5, 'stok_total' => 70, 'keterangan' => 'Antiseptik'],
        ]);
    }
}
