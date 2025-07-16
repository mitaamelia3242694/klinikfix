<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AsuransiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('asuransi')->insert([
            ['nama_perusahaan' => 'BPJS Kesehatan', 'nomor_polis' => 'BPJS123456', 'jenis_asuransi' => 'Umum', 'masa_berlaku_mulai' => '2025-01-01', 'masa_berlaku_akhir' => '2026-01-01', 'status' => 'Aktif'],
            ['nama_perusahaan' => 'Prudential', 'nomor_polis' => 'PRD987654', 'jenis_asuransi' => 'Swasta', 'masa_berlaku_mulai' => '2025-02-01', 'masa_berlaku_akhir' => '2026-02-01', 'status' => 'Aktif'],
            ['nama_perusahaan' => 'Mandiri InHealth', 'nomor_polis' => 'MIH234567', 'jenis_asuransi' => 'Swasta', 'masa_berlaku_mulai' => '2025-03-01', 'masa_berlaku_akhir' => '2026-03-01', 'status' => 'Aktif'],
            ['nama_perusahaan' => 'AXA Mandiri', 'nomor_polis' => 'AXA345678', 'jenis_asuransi' => 'Swasta', 'masa_berlaku_mulai' => '2025-04-01', 'masa_berlaku_akhir' => '2026-04-01', 'status' => 'Aktif'],
            ['nama_perusahaan' => 'Allianz', 'nomor_polis' => 'ALZ456789', 'jenis_asuransi' => 'Swasta', 'masa_berlaku_mulai' => '2025-05-01', 'masa_berlaku_akhir' => '2026-05-01', 'status' => 'Aktif'],
        ]);
    }
}
