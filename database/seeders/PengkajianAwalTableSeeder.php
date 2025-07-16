<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PengkajianAwalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengkajian_awal')->insert([
            [
                'pasien_id' => 1,
                'user_id' => 4, // pastikan user dengan id 3 ada
                'tanggal' => Carbon::parse('2025-06-01'),
                'keluhan_utama' => 'Sakit kepala hebat sejak semalam',
                'tekanan_darah' => '130/85',
                'suhu_tubuh' => '37.2',
                'catatan' => 'Pasien tampak lemah. Disarankan pemeriksaan lanjutan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-03'),
                'keluhan_utama' => 'Sesak napas dan batuk kering',
                'tekanan_darah' => '125/80',
                'suhu_tubuh' => '36.9',
                'catatan' => 'Perlu observasi lebih lanjut untuk kemungkinan asma.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-06'),
                'keluhan_utama' => 'Nyeri tajam di perut kanan bawah',
                'tekanan_darah' => '120/75',
                'suhu_tubuh' => '38.0',
                'catatan' => 'Kemungkinan apendisitis. Rujuk ke bagian bedah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-08'),
                'keluhan_utama' => 'Pusing dan mual setiap pagi',
                'tekanan_darah' => '110/70',
                'suhu_tubuh' => '36.7',
                'catatan' => 'Disarankan tes laboratorium darah lengkap.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'user_id' => 4,
                'tanggal' => Carbon::parse('2025-06-10'),
                'keluhan_utama' => 'Ruam merah dan gatal di tangan',
                'tekanan_darah' => '115/75',
                'suhu_tubuh' => '36.8',
                'catatan' => 'Kemungkinan alergi kontak. Anjurkan hindari sabun baru.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}