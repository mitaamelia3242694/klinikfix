<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiagnosaAkhirTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diagnosa_akhir')->insert([
            [
                'pasien_id' => 1,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-02'),
                'diagnosa' => 'Migrain kronis',
                'catatan' => 'Respon baik terhadap terapi. Lanjutkan pengobatan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 2,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-05'),
                'diagnosa' => 'Asma stabil',
                'catatan' => 'Kondisi membaik, kontrol sebulan kemudian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 3,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-07'),
                'diagnosa' => 'Apendisitis pasca operasi',
                'catatan' => 'Pasca operasi lancar, observasi rawat inap.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 4,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-09'),
                'diagnosa' => 'Vertigo vestibular',
                'catatan' => 'Pemberian betahistine efektif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pasien_id' => 5,
                'user_id' => 3,
                'tanggal' => Carbon::parse('2025-06-11'),
                'diagnosa' => 'Dermatitis sembuh',
                'catatan' => 'Pasien menunjukkan perbaikan setelah pengobatan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}