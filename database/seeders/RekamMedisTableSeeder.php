<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RekamMedisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rekam_medis')->insert([
            [
                'pasien_id' => 1,
                'tanggal_kunjungan' => Carbon::parse('2025-06-01'),
                'keluhan' => 'Demam tinggi selama 3 hari.',
                'diagnosa' => 'Demam Berdarah',
                'tindakan_id' => 6,
                'catatan_tambahan' => 'Perlu rawat inap 3 hari.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'tanggal_kunjungan' => Carbon::parse('2025-06-04'),
                'keluhan' => 'Batuk kering dan sesak napas.',
                'diagnosa' => 'Asma Bronkial',
                'tindakan_id' => 7,
                'catatan_tambahan' => 'Diresepkan inhaler dan kontrol rutin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'tanggal_kunjungan' => Carbon::parse('2025-06-06'),
                'keluhan' => 'Nyeri di perut kanan bawah.',
                'diagnosa' => 'Apendisitis akut',
                'tindakan_id' => 8,
                'catatan_tambahan' => 'Operasi dijadwalkan segera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'tanggal_kunjungan' => Carbon::parse('2025-06-08'),
                'keluhan' => 'Sakit kepala dan mual.',
                'diagnosa' => 'Migrain',
                'tindakan_id' => 9,
                'catatan_tambahan' => 'Berikan analgesik dan istirahat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'tanggal_kunjungan' => Carbon::parse('2025-06-10'),
                'keluhan' => 'Ruam kulit dan gatal.',
                'diagnosa' => 'Dermatitis kontak',
                'tindakan_id' => 10,
                'catatan_tambahan' => 'Hindari alergen dan gunakan salep.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
