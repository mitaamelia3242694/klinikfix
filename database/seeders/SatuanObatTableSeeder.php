<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SatuanObatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('satuan_obat')->insert([
            ['nama_satuan' => 'Tablet'],
            ['nama_satuan' => 'Kapsul'],
            ['nama_satuan' => 'Botol'],
            ['nama_satuan' => 'Ampul'],
            ['nama_satuan' => 'Salep'],
        ]);
    }
}
