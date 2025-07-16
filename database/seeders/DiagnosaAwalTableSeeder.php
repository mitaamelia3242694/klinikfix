<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiagnosaAwalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('diagnosa_awal')->insert([
            [
                'pasien_id' => 1,
                'user_id' => 4, // pastikan user dengan ID ini ada
                'tanggal' => Carbon::parse('2025-06-01'),
                'diagnosa' => 'Migrain akut',
                'catatan' => 'Disarankan terapi obat dan istirahat cukup.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-03'),
                'diagnosa' => 'Asma bronkial ringan',
                'catatan' => 'Pasien diberikan inhaler dan edukasi lingkungan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-06'),
                'diagnosa' => 'Apendisitis akut',
                'catatan' => 'Pasien dijadwalkan untuk operasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-08'),
                'diagnosa' => 'Vertigo sentral',
                'catatan' => 'Direkomendasikan MRI jika gejala berlanjut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-10'),
                'diagnosa' => 'Dermatitis kontak',
                'catatan' => 'Berikan antihistamin topikal dan edukasi kebersihan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}