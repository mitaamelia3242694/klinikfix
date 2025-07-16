<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TindakanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tindakan')->insert([
            [
                'pasien_id' => 1,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-01'),
                'jenis_tindakan' => 'Pemeriksaan Umum',
                'tarif' => 50000,
                'catatan' => 'Pasien datang dengan keluhan pusing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-03'),
                'jenis_tindakan' => 'Pemeriksaan THT',
                'tarif' => 75000,
                'catatan' => 'Pasien mengalami gangguan pendengaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-06'),
                'jenis_tindakan' => 'Tindakan Bedah Minor',
                'tarif' => 200000,
                'catatan' => 'Tindakan dilakukan di ruang operasi minor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-08'),
                'jenis_tindakan' => 'Konsultasi Dokter',
                'tarif' => 30000,
                'catatan' => 'Konsultasi kesehatan umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-10'),
                'jenis_tindakan' => 'Pemeriksaan Kulit',
                'tarif' => 60000,
                'catatan' => 'Pasien mengeluhkan ruam pada tangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
