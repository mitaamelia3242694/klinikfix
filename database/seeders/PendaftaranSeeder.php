<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('pendaftaran')->insert([
            [
                'pasien_id' => 1,
                'jenis_kunjungan' => 'baru',
                'dokter_id' => 3, // misalnya user ID 2 adalah dokter
                'tindakan_id' => 6, // misalnya tindakan ID 1 adalah "Pemeriksaan Umum"
                'asal_pendaftaran_id' => 1, // Datang Langsung
                'status' => 'selesai',
                'perawat_id' => 8, // misalnya user ID 3 adalah perawat
                'keluhan' => 'Demam tinggi sejak dua hari lalu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'jenis_kunjungan' => 'lama',
                'dokter_id' => 3,
                'tindakan_id' => 7, // misalnya tindakan ID 2 adalah "Konsultasi Gizi"
                'asal_pendaftaran_id' => 2, // Rujukan Rumah Sakit
                'status' => 'selesai',
                'perawat_id' => 4,
                'keluhan' => 'Kontrol rutin pasca rawat inap.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'jenis_kunjungan' => 'baru',
                'dokter_id' => 3,
                'tindakan_id' => 8,
                'asal_pendaftaran_id' => 3,
                'status' => 'diperiksa',
                'perawat_id' => 8,
                'keluhan' => 'Keluhan nyeri di dada kiri.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'jenis_kunjungan' => 'lama',
                'dokter_id' => 3,
                'tindakan_id' => null,
                'asal_pendaftaran_id' => 4,
                'status' => 'menunggu',
                'perawat_id' => null,
                'keluhan' => 'Keluhan sakit kepala terus-menerus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'jenis_kunjungan' => 'baru',
                'dokter_id' => 3,
                'tindakan_id' => 9,
                'asal_pendaftaran_id' => 5,
                'status' => 'selesai',
                'perawat_id' => 4,
                'keluhan' => 'Pemeriksaan kesehatan umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
