<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PegawaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'nik' => '3173123456789012',
                'nip' => '198765432',
                'nama_lengkap' => 'Dr. Rina Wijaya',
                'gelar' => 'S.Ked',
                'jenis_kelamin' => 'P',
                'ttl' => '1980-03-12',
                'alamat' => 'Jl. Melati No. 10, Jakarta',
                'email' => 'rina@klinik.com',
                'no_telp' => '081234567890',
                'str' => 'STR-12345',
                'sip' => 'SIP-54321',
                'jabatan_id' => 1,
                'instansi_induk' => 'Klinik Harapan Sehat',
                'tanggal_berlaku' => now(),
            ],
            [
                'nik' => '3173022233445566',
                'nip' => '2001123456',
                'nama_lengkap' => 'Drg. Ahmad Fauzi',
                'gelar' => 'drg.',
                'jenis_kelamin' => 'L',
                'ttl' => '1979-06-25',
                'alamat' => 'Jl. Anggrek No. 15, Depok',
                'email' => 'ahmad@klinik.com',
                'no_telp' => '081298765432',
                'str' => 'STR-67890',
                'sip' => 'SIP-09876',
                'jabatan_id' => 2,
                'instansi_induk' => 'Klinik Harapan Sehat',
                'tanggal_berlaku' => now(),
            ],
            [
                'nik' => '3173011122334455',
                'nip' => null,
                'nama_lengkap' => 'Siti Nurhaliza',
                'gelar' => 'Ns.',
                'jenis_kelamin' => 'P',
                'ttl' => '1987-11-04',
                'alamat' => 'Jl. Mawar No. 22, Bekasi',
                'email' => 'siti@klinik.com',
                'no_telp' => '082112345678',
                'str' => 'STR-11223',
                'sip' => 'SIP-33445',
                'jabatan_id' => 3,
                'instansi_induk' => 'Klinik Harapan Sehat',
                'tanggal_berlaku' => now(),
            ],
            [
                'nik' => '3173009988776655',
                'nip' => '1991123488',
                'nama_lengkap' => 'Rahmat Pratama',
                'gelar' => 'S.Farm., Apt.',
                'jenis_kelamin' => 'L',
                'ttl' => '1991-01-15',
                'alamat' => 'Jl. Cemara No. 8, Tangerang',
                'email' => 'rahmat@klinik.com',
                'no_telp' => '081345678901',
                'str' => 'STR-44556',
                'sip' => 'SIP-66778',
                'jabatan_id' => 4,
                'instansi_induk' => 'Klinik Harapan Sehat',
                'tanggal_berlaku' => now(),
            ],
            [
                'nik' => '3173998877665544',
                'nip' => null,
                'nama_lengkap' => 'Lisa Permata',
                'gelar' => '-',
                'jenis_kelamin' => 'P',
                'ttl' => '1995-09-23',
                'alamat' => 'Jl. Teratai No. 9, Bogor',
                'email' => 'lisa@klinik.com',
                'no_telp' => '081356789012',
                'str' => null,
                'sip' => null,
                'jabatan_id' => 5,
                'instansi_induk' => 'Klinik Harapan Sehat',
                'tanggal_berlaku' => now(),
            ],
        ]);
    }
}
