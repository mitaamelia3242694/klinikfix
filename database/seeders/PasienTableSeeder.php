<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PasienTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pasien')->insert([
            [
                'asuransi_id' => null,
                'NIK' => '3173012345678901',
                'nama' => 'Ahmad Fauzi',
                'tanggal_lahir' => '1985-05-20',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kenanga No. 12, Jakarta',
                'no_hp' => '081234111222',
                'tanggal_daftar' => Carbon::parse('2025-06-01'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asuransi_id' => 1,
                'NIK' => '3173012345678902',
                'nama' => 'Dewi Kartika',
                'tanggal_lahir' => '1990-09-15',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Mawar No. 8, Bekasi',
                'no_hp' => '081234222333',
                'tanggal_daftar' => Carbon::parse('2025-06-03'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asuransi_id' => 2,
                'NIK' => '3173012345678903',
                'nama' => 'Satria Nugroho',
                'tanggal_lahir' => '1978-02-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Anggrek No. 5, Depok',
                'no_hp' => '081234333444',
                'tanggal_daftar' => Carbon::parse('2025-06-06'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asuransi_id' => null,
                'NIK' => '3173012345678904',
                'nama' => 'Melati Hasanah',
                'tanggal_lahir' => '1983-07-01',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Melati No. 9, Tangerang',
                'no_hp' => '081234444555',
                'tanggal_daftar' => Carbon::parse('2025-06-08'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asuransi_id' => 1,
                'NIK' => '3173012345678905',
                'nama' => 'Andika Surya',
                'tanggal_lahir' => '1995-11-22',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Dahlia No. 17, Bogor',
                'no_hp' => '081234555666',
                'tanggal_daftar' => Carbon::parse('2025-06-10'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}