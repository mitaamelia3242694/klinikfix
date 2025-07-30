<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Apoteker\ResepController;
use App\Http\Controllers\Dokter\RekamMedisController;
use App\Http\Controllers\AdminIT\DashboardITController;
use App\Http\Controllers\AdminIT\DataJabatanController;
use App\Http\Controllers\AdminIT\DataPegawaiController;
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Dokter\PenerbitanResepController;
use App\Http\Controllers\Perawat\DataKajianAwalController;
use App\Http\Controllers\AdminStokObat\SatuanObatController;
use App\Http\Controllers\Apoteker\PengambilanObatController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Perawat\DataDiagnosaAwalController;
use App\Http\Controllers\AdminIT\ManajemenPenggunaController;
use App\Http\Controllers\Dokter\PencatatanDiagnosaController;
use App\Http\Controllers\Dokter\PencatatanTindakanController;
use App\Http\Controllers\Perawat\ManajemenTindakanController;
use App\Http\Controllers\AdminPendaftaran\DashboardController;
use App\Http\Controllers\AdminPendaftaran\PelayananController;
use App\Http\Controllers\Apoteker\DashboardApotekerController;
use App\Http\Controllers\AdminPendaftaran\DataPasienController;
use App\Http\Controllers\AdminStokObat\ManajemenObatController;
use App\Http\Controllers\AdminPendaftaran\DataAsuransiController;
use App\Http\Controllers\AdminStokObat\KetersediaanObatController;
use App\Http\Controllers\AdminPendaftaran\MasterDiagnosaController;
use App\Http\Controllers\AdminStokObat\DashboardStokObatController;
use App\Http\Controllers\AdminPendaftaran\DataPendaftaranController;
use App\Http\Controllers\AdminPendaftaran\RiwayatKunjunganController;
use App\Http\Controllers\AdminPendaftaran\DataAsalPendaftaranController;



Route::get('/', [LoginController::class, 'showlogin'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:Admin IT'])->group(function () {
    // Admin IT Pages
    Route::get('/dashboard-it', [DashboardITController::class, 'index'])->name('dashboard-it.index');

    // Data Pegawai
    Route::get('/data-pegawai', [DataPegawaiController::class, 'index'])->name('data-pegawai.index');
    Route::get('/data-pegawai/create', [DataPegawaiController::class, 'create'])->name('data-pegawai.create');
    Route::post('/data-pegawai', [DataPegawaiController::class, 'store'])->name('data-pegawai.store');
    Route::get('/data-pegawai/{id}', [DataPegawaiController::class, 'show'])->name('data-pegawai.show');
    Route::get('/data-pegawai/{id}/edit', [DataPegawaiController::class, 'edit'])->name('data-pegawai.edit');
    Route::put('/data-pegawai/{id}', [DataPegawaiController::class, 'update'])->name('data-pegawai.update');
    Route::delete('/data-pegawai/{id}', [DataPegawaiController::class, 'destroy'])->name('data-pegawai.destroy');

    // Manajemen Pengguna
    Route::get('/manajemen-pengguna', [ManajemenPenggunaController::class, 'index'])->name('manajemen-pengguna.index');
    Route::get('/manajemen-pengguna/create', [ManajemenPenggunaController::class, 'create'])->name('manajemen-pengguna.create');
    Route::post('/manajemen-pengguna', [ManajemenPenggunaController::class, 'store'])->name('manajemen-pengguna.store');
    Route::get('/manajemen-pengguna/{id}', [ManajemenPenggunaController::class, 'show'])->name('manajemen-pengguna.show');
    Route::get('/manajemen-pengguna/{id}/edit', [ManajemenPenggunaController::class, 'edit'])->name('manajemen-pengguna.edit');
    Route::put('/manajemen-pengguna/{id}', [ManajemenPenggunaController::class, 'update'])->name('manajemen-pengguna.update');
    Route::delete('/manajemen-pengguna/{id}', [ManajemenPenggunaController::class, 'destroy'])->name('manajemen-pengguna.destroy');


    // Data Jabatan
    Route::get('/data-jabatan', [DataJabatanController::class, 'index'])->name('data-jabatan.index');
    Route::post('/data-jabatan', [DataJabatanController::class, 'store'])->name('data-jabatan.store');
    Route::get('/data-jabatan/{id}/edit', [DataJabatanController::class, 'edit'])->name('data-jabatan.edit');
    Route::put('/data-jabatan/{id}', [DataJabatanController::class, 'update'])->name('data-jabatan.update');
    Route::delete('/data-jabatan/{id}', [DataJabatanController::class, 'destroy'])->name('data-jabatan.destroy');
});

Route::middleware(['auth', 'role:Admin Pendaftaran'])->group(function () {
    // Admin Pendaftaran Pages
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Data Pasien
    Route::get('/data-pasien', [DataPasienController::class, 'index'])->name('data-pasien.index');
    Route::get('/data-pasien/create', [DataPasienController::class, 'create'])->name('data-pasien.create');
    Route::post('/data-pasien/store', [DataPasienController::class, 'store'])->name('data-pasien.store');
    Route::get('/data-pasien/{id}', [DataPasienController::class, 'show'])->name('data-pasien.show');
    Route::get('/data-pasien/{id}/edit', [DataPasienController::class, 'edit'])->name('data-pasien.edit');
    Route::put('/data-pasien/{id}', [DataPasienController::class, 'update'])->name('data-pasien.update');
    Route::delete('/data-pasien/{id}', [DataPasienController::class, 'destroy'])->name('data-pasien.destroy');
    Route::get('/pasien/{id}/riwayat-ajax', [DataPasienController::class, 'riwayatAjax'])->name('data-pasien.riwayat-ajax');

    // Data Pendaftaran
    Route::get('/data-pendaftaran', [DataPendaftaranController::class, 'index'])->name('data-pendaftaran.index');
    Route::get('/data-pendaftaran/create', [DataPendaftaranController::class, 'create'])->name('data-pendaftaran.create');
    Route::post('/data-pendaftaran/store', [DataPendaftaranController::class, 'store'])->name('data-pendaftaran.store');
    Route::get('/data-pendaftaran/{id}', [DataPendaftaranController::class, 'show'])->name('data-pendaftaran.show');
    Route::get('/data-pendaftaran/{id}/edit', [DataPendaftaranController::class, 'edit'])->name('data-pendaftaran.edit');
    Route::put('/data-pendaftaran/{id}', [DataPendaftaranController::class, 'update'])->name('data-pendaftaran.update');
    Route::delete('/data-pendaftaran/{id}', [DataPendaftaranController::class, 'destroy'])->name('data-pendaftaran.destroy');

    // Data Riwayat Kunjungan
    Route::get('/riwayat-kunjungan', [RiwayatKunjunganController::class, 'index'])->name('data-riwayat-kunjungan.index');

    // Data Asal Pendaftaran
    Route::get('/data-asal-pendaftaran', [DataAsalPendaftaranController::class, 'index'])->name('data-asal-pendaftaran.index');
    Route::get('/data-asal-pendaftaran/create', [DataAsalPendaftaranController::class, 'create'])->name('data-asal-pendaftaran.create');
    Route::post('/data-asal-pendaftaran/store', [DataAsalPendaftaranController::class, 'store'])->name('data-asal-pendaftaran.store');
    Route::get('/data-asal-pendaftaran/{id}', [DataAsalPendaftaranController::class, 'show'])->name('data-asal-pendaftaran.show');
    Route::get('/data-asal-pendaftaran/{id}/edit', [DataAsalPendaftaranController::class, 'edit'])->name('data-asal-pendaftaran.edit');
    Route::put('/data-asal-pendaftaran/{id}', [DataAsalPendaftaranController::class, 'update'])->name('data-asal-pendaftaran.update');
    Route::delete('/data-asal-pendaftaran/{id}', [DataAsalPendaftaranController::class, 'destroy'])->name('data-asal-pendaftaran.destroy');

    // Data Pelayanan
    Route::get('/data-pelayanan', [PelayananController::class, 'index'])->name('data-pelayanan.index');
    Route::get('/data-pelayanan/create', [PelayananController::class, 'create'])->name('data-pelayanan.create');
    Route::post('/data-pelayanan/store', [PelayananController::class, 'store'])->name('data-pelayanan.store');
    Route::get('/data-pelayanan/{id}', [PelayananController::class, 'show'])->name('data-pelayanan.show');
    Route::get('/data-pelayanan/{id}/edit', [PelayananController::class, 'edit'])->name('data-pelayanan.edit');
    Route::put('/data-pelayanan/{id}', [PelayananController::class, 'update'])->name('data-pelayanan.update');
    Route::delete('/data-pelayanan/{id}', [PelayananController::class, 'destroy'])->name('data-pelayanan.destroy');

    // Data Asuransi
    Route::get('/data-asuransi', [DataAsuransiController::class, 'index'])->name('data-asuransi.index');
    Route::get('/data-asuransi/create', [DataAsuransiController::class, 'create'])->name('data-asuransi.create');
    Route::post('/data-asuransi/store', [DataAsuransiController::class, 'store'])->name('data-asuransi.store');
    Route::get('/data-asuransi/{id}', [DataAsuransiController::class, 'show'])->name('data-asuransi.show');
    Route::get('/data-asuransi/{id}/edit', [DataAsuransiController::class, 'edit'])->name('data-asuransi.edit');
    Route::put('/data-asuransi/{id}', [DataAsuransiController::class, 'update'])->name('data-asuransi.update');
    Route::delete('/data-asuransi/{id}', [DataAsuransiController::class, 'destroy'])->name('data-asuransi.destroy');

    // Master Diagnosa
    Route::get('/master-diagnosa', [MasterDiagnosaController::class, 'index'])->name('master-diagnosa.index');
    Route::post('/master-diagnosa', [MasterDiagnosaController::class, 'store'])->name('master-diagnosa.store');
    Route::get('/master-diagnosa/{id}/edit', [MasterDiagnosaController::class, 'edit'])->name('master-diagnosa.edit');
    Route::put('/master-diagnosa/{id}', [MasterDiagnosaController::class, 'update'])->name('master-diagnosa.update');
    Route::delete('/master-diagnosa/{id}', [MasterDiagnosaController::class, 'destroy'])->name('master-diagnosa.destroy');
});


Route::middleware(['auth', 'role:Perawat'])->group(function () {
    // Perawat Pages
    Route::get('/dashboard-perawat', [DashboardPerawatController::class, 'index'])->name('dashboard-perawat.index');

    // Data Kajian Awal
    Route::get('/data-kajian-awal', [DataKajianAwalController::class, 'index'])->name('data-kajian-awal.index');
    Route::get('/data-kajian-awal/create', [DataKajianAwalController::class, 'create'])->name('data-kajian-awal.create');
    Route::post('/data-kajian-awal/store', [DataKajianAwalController::class, 'store'])->name('data-kajian-awal.store');
    Route::get('/data-kajian-awal/{id}', [DataKajianAwalController::class, 'show'])->name('data-kajian-awal.show');
    Route::get('/data-kajian-awal/{id}/edit', [DataKajianAwalController::class, 'edit'])->name('data-kajian-awal.edit');
    Route::put('/data-kajian-awal/{id}', [DataKajianAwalController::class, 'update'])->name('data-kajian-awal.update');
    Route::delete('/data-kajian-awal/{id}', [DataKajianAwalController::class, 'destroy'])->name('data-kajian-awal.destroy');

    // Data Diagnosa Awal
    Route::get('/data-diagnosa-awal', [DataDiagnosaAwalController::class, 'index'])->name('data-diagnosa-awal.index');
    Route::get('/data-diagnosa-awal/create', [DataDiagnosaAwalController::class, 'create'])->name('data-diagnosa-awal.create');
    Route::post('/data-diagnosa-awal/store', [DataDiagnosaAwalController::class, 'store'])->name('data-diagnosa-awal.store');
    Route::get('/data-diagnosa-awal/{id}', [DataDiagnosaAwalController::class, 'show'])->name('data-diagnosa-awal.show');
    Route::get('/data-diagnosa-awal/{id}/edit', [DataDiagnosaAwalController::class, 'edit'])->name('data-diagnosa-awal.edit');
    Route::put('/data-diagnosa-awal/{id}', [DataDiagnosaAwalController::class, 'update'])->name('data-diagnosa-awal.update');
    Route::delete('/data-diagnosa-awal/{id}', [DataDiagnosaAwalController::class, 'destroy'])->name('data-diagnosa-awal.destroy');

    // Manajemen Tindakan
    Route::get('/manajemen-tindakan', [ManajemenTindakanController::class, 'index'])->name('manajemen-tindakan.index');
    Route::get('/manajemen-tindakan/create', [ManajemenTindakanController::class, 'create'])->name('manajemen-tindakan.create');
    Route::post('/manajemen-tindakan/store', [ManajemenTindakanController::class, 'store'])->name('manajemen-tindakan.store');
    Route::get('/manajemen-tindakan/{id}', [ManajemenTindakanController::class, 'show'])->name('manajemen-tindakan.show');
    Route::get('/manajemen-tindakan/{id}/edit', [ManajemenTindakanController::class, 'edit'])->name('manajemen-tindakan.edit');
    Route::put('/manajemen-tindakan/{id}', [ManajemenTindakanController::class, 'update'])->name('manajemen-tindakan.update');
    Route::delete('/manajemen-tindakan/{id}', [ManajemenTindakanController::class, 'destroy'])->name('manajemen-tindakan.destroy');
});


Route::middleware(['auth', 'role:Dokter'])->group(function () {
    // Dokter Pages
    Route::get('/dashboard-dokter', [DashboardDokterController::class, 'index'])->name('dashboard-dokter.index');

    // Pencatatan Diagnosa
    Route::get('/pencatatan-diagnosa', [PencatatanDiagnosaController::class, 'index'])->name('pencatatan-diagnosa.index');
    Route::get('/pencatatan-diagnosa/create', [PencatatanDiagnosaController::class, 'create'])->name('pencatatan-diagnosa.create');
    Route::post('/pencatatan-diagnosa/store', [PencatatanDiagnosaController::class, 'store'])->name('pencatatan-diagnosa.store');
    Route::get('/pencatatan-diagnosa/{id}', [PencatatanDiagnosaController::class, 'show'])->name('pencatatan-diagnosa.show');
    Route::get('/pencatatan-diagnosa/{id}/edit', [PencatatanDiagnosaController::class, 'edit'])->name('pencatatan-diagnosa.edit');
    Route::put('/pencatatan-diagnosa/{id}', [PencatatanDiagnosaController::class, 'update'])->name('pencatatan-diagnosa.update');
    Route::delete('/pencatatan-diagnosa/{id}', [PencatatanDiagnosaController::class, 'destroy'])->name('pencatatan-diagnosa.destroy');

    // Pencatatan Tindakan
    Route::get('/pencatatan-tindakan', [PencatatanTindakanController::class, 'index'])->name('pencatatan-tindakan.index');
    Route::get('/pencatatan-tindakan/create', [PencatatanTindakanController::class, 'create'])->name('pencatatan-tindakan.create');
    Route::post('/pencatatan-tindakan/store', [PencatatanTindakanController::class, 'store'])->name('pencatatan-tindakan.store');
    Route::get('/pencatatan-tindakan/{id}', [PencatatanTindakanController::class, 'show'])->name('pencatatan-tindakan.show');
    Route::get('/pencatatan-tindakan/{id}/edit', [PencatatanTindakanController::class, 'edit'])->name('pencatatan-tindakan.edit');
    Route::put('/pencatatan-tindakan/{id}', [PencatatanTindakanController::class, 'update'])->name('pencatatan-tindakan.update');
    Route::delete('/pencatatan-tindakan/{id}', [PencatatanTindakanController::class, 'destroy'])->name('pencatatan-tindakan.destroy');

    // Penerbitan Resep
    Route::get('/penerbitan-resep', [PenerbitanResepController::class, 'index'])->name('penerbitan-resep.index');
    Route::get('/penerbitan-resep/create', [PenerbitanResepController::class, 'create'])->name('penerbitan-resep.create');
    Route::post('/penerbitan-resep/store', [PenerbitanResepController::class, 'store'])->name('penerbitan-resep.store');
    Route::get('/penerbitan-resep/{id}', [PenerbitanResepController::class, 'show'])->name('penerbitan-resep.show');
    Route::get('/penerbitan-resep/{id}/edit', [PenerbitanResepController::class, 'edit'])->name('penerbitan-resep.edit');
    Route::put('/penerbitan-resep/{id}', [PenerbitanResepController::class, 'update'])->name('penerbitan-resep.update');
    Route::delete('/penerbitan-resep/{id}', [PenerbitanResepController::class, 'destroy'])->name('penerbitan-resep.destroy');

    // Rekam Medis
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam-medis.index');
    Route::get('/rekam-medis/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis/store', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{id}', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::get('/rekam-medis/{id}/edit', [RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}', [RekamMedisController::class, 'update'])->name('rekam-medis.update');
    Route::delete('/rekam-medis/{id}', [RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');
});


Route::middleware(['auth', 'role:Apoteker'])->group(function () {
    // Apoteker Pages
    Route::get('/dashboard-apoteker', [DashboardApotekerController::class, 'index'])->name('dashboard-apoteker.index');

    // Data Resep
    Route::get('/data-resep', [ResepController::class, 'index'])->name('data-resep.index');
    Route::get('/data-resep/create', [ResepController::class, 'create'])->name('data-resep.create');
    Route::post('/data-resep', [ResepController::class, 'store'])->name('data-resep.store');
    Route::get('/data-resep/{id}', [ResepController::class, 'show'])->name('data-resep.show');
    Route::get('/data-resep/{id}/edit', [ResepController::class, 'edit'])->name('data-resep.edit');
    Route::put('/data-resep/{id}', [ResepController::class, 'update'])->name('data-resep.update');
    Route::delete('/data-resep/{id}', [ResepController::class, 'destroy'])->name('data-resep.destroy');

    // Data Pengambilan Obat
    Route::get('/pengambilan-obat', [PengambilanObatController::class, 'index'])->name('pengambilan-obat.index');
    Route::get('/pengambilan-obat/create', [PengambilanObatController::class, 'create'])->name('pengambilan-obat.create');
    Route::post('/pengambilan-obat', [PengambilanObatController::class, 'store'])->name('pengambilan-obat.store');
    Route::get('/pengambilan-obat/{id}', [PengambilanObatController::class, 'show'])->name('pengambilan-obat.show');
    Route::get('/pengambilan-obat/{id}/edit', [PengambilanObatController::class, 'edit'])->name('pengambilan-obat.edit');
    Route::put('/pengambilan-obat/{id}', [PengambilanObatController::class, 'update'])->name('pengambilan-obat.update');
    Route::delete('/pengambilan-obat/{id}', [PengambilanObatController::class, 'destroy'])->name('pengambilan-obat.destroy');

      // Data Pengambilan Obat
    Route::get('/pengambilan-obat-pasien', [PengambilanObatController::class, 'index_obat_pasien'])->name('pengambilan-obat-pasien.index');
    Route::get('/pengambilan-obat-pasien/create', [PengambilanObatController::class, 'create'])->name('pengambilan-obat-pasien.create');
    Route::post('/pengambilan-obat-pasien', [PengambilanObatController::class, 'store'])->name('pengambilan-obat-pasien.store');
    Route::get('/pengambilan-obat-pasien/{id}', [PengambilanObatController::class, 'show'])->name('pengambilan-obat-pasien.show');
    Route::get('/pengambilan-obat-pasien/{id}/edit', [PengambilanObatController::class, 'edit_obat_pasien'])->name('pengambilan-obat-pasien.edit');
    Route::put('/pengambilan-obat-pasien/{id}', [PengambilanObatController::class, 'update_obat_pasien'])->name('pengambilan-obat-pasien.update');
    Route::delete('/pengambilan-obat-pasien/{id}', [PengambilanObatController::class, 'destroy'])->name('pengambilan-obat-pasien.destroy');
});



Route::middleware(['auth', 'role:Admin Stok Obat'])->group(function () {
    // Admin Stok Obat || Start Pages
    Route::get('/dashboard-stokobat', [DashboardStokObatController::class, 'index'])->name('dashboard-stokobat.index');

    // Manajemen Data Obat
    Route::get('/menejemen-obat', [ManajemenObatController::class, 'index'])->name('menejemen-obat.index');
    Route::get('/menejemen-obat/create', [ManajemenObatController::class, 'create'])->name('menejemen-obat.create');
    Route::post('/menejemen-obat', [ManajemenObatController::class, 'store'])->name('menejemen-obat.store');
    Route::get('/menejemen-obat/{id}', [ManajemenObatController::class, 'show'])->name('menejemen-obat.show');
    Route::get('/menejemen-obat/{id}/edit', [ManajemenObatController::class, 'edit'])->name('menejemen-obat.edit');
    Route::put('/menejemen-obat/{id}', [ManajemenObatController::class, 'update'])->name('menejemen-obat.update');
    Route::delete('/menejemen-obat/{id}', [ManajemenObatController::class, 'destroy'])->name('menejemen-obat.destroy');

    // Satuan Obat
    Route::get('/satuan-obat', [SatuanObatController::class, 'index'])->name('satuan-obat.index');
    Route::post('/satuan-obat', [SatuanObatController::class, 'store'])->name('satuan-obat.store');
    Route::get('/satuan-obat/{id}', [SatuanObatController::class, 'show'])->name('satuan-obat.show');
    Route::get('/satuan-obat/{id}/edit', [SatuanObatController::class, 'edit'])->name('satuan-obat.edit');
    Route::put('/satuan-obat/{id}', [SatuanObatController::class, 'update'])->name('satuan-obat.update');
    Route::delete('/satuan-obat/{id}', [SatuanObatController::class, 'destroy'])->name('satuan-obat.destroy');

    // Ketersediaan Obat
    Route::get('/kesediaan-obat', [KetersediaanObatController::class, 'index'])->name('kesediaan-obat.index');
    Route::post('/kesediaan-obat', [KetersediaanObatController::class, 'store'])->name('kesediaan-obat.store');
    Route::get('/kesediaan-obat/{id}', [KetersediaanObatController::class, 'show'])->name('kesediaan-obat.show');
    Route::get('/kesediaan-obat/{id}/edit', [KetersediaanObatController::class, 'edit'])->name('kesediaan-obat.edit');
    Route::put('/kesediaan-obat/{id}', [KetersediaanObatController::class, 'update'])->name('kesediaan-obat.update');
    Route::delete('/kesediaan-obat/{id}', [KetersediaanObatController::class, 'destroy'])->name('kesediaan-obat.destroy');
    // Admin Stok Obat || End Pages
});
