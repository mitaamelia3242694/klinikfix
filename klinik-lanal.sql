-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Jul 2025 pada 03.59
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik-lanal`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `asal_pendaftaran`
--

CREATE TABLE `asal_pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asal_pendaftaran`
--

INSERT INTO `asal_pendaftaran` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Datang Langsung', '2025-07-10 06:39:45', '2025-07-10 06:39:45'),
(2, 'Rujukan Rumah Sakit', '2025-07-10 06:39:45', '2025-07-10 06:39:45'),
(3, 'Rujukan Puskesmas', '2025-07-10 06:39:45', '2025-07-10 06:39:45'),
(4, 'Telemedicine', '2025-07-10 06:39:45', '2025-07-10 06:39:45'),
(5, 'Kunjungan Homecare', '2025-07-10 06:39:45', '2025-07-10 06:39:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asuransi`
--

CREATE TABLE `asuransi` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_polis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_asuransi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `masa_berlaku_mulai` date NOT NULL,
  `masa_berlaku_akhir` date NOT NULL,
  `status` enum('Aktif','Tidak Aktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asuransi`
--

INSERT INTO `asuransi` (`id`, `nama_perusahaan`, `nomor_polis`, `jenis_asuransi`, `masa_berlaku_mulai`, `masa_berlaku_akhir`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BPJS Kesehatan', 'BPJS123456', 'Umum', '2025-01-01', '2026-01-01', 'Aktif', NULL, NULL),
(2, 'Prudential', 'PRD987654', 'Swasta', '2025-02-01', '2026-02-01', 'Aktif', NULL, NULL),
(3, 'Mandiri InHealth', 'MIH234567', 'Swasta', '2025-03-01', '2026-03-01', 'Aktif', NULL, NULL),
(4, 'AXA Mandiri', 'AXA345678', 'Swasta', '2025-04-01', '2026-04-01', 'Aktif', NULL, NULL),
(5, 'Allianz', 'ALZ456789', 'Swasta', '2025-05-01', '2026-05-01', 'Aktif', NULL, NULL),
(6, 'Jasa Raharja', '123456', 'Umum', '2025-06-14', '2030-06-14', 'Aktif', '2025-06-13 23:12:42', '2025-06-13 23:12:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosa_akhir`
--

CREATE TABLE `diagnosa_akhir` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `diagnosa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `master_diagnosa_id` bigint UNSIGNED DEFAULT NULL,
  `pelayanan_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diagnosa_akhir`
--

INSERT INTO `diagnosa_akhir` (`id`, `pasien_id`, `user_id`, `tanggal`, `diagnosa`, `catatan`, `created_at`, `updated_at`, `master_diagnosa_id`, `pelayanan_id`) VALUES
(1, 1, 3, '2025-06-02', 'Migrain kronis', 'Respon baik terhadap terapi. Lanjutkan pengobatan.', '2025-06-10 23:02:44', '2025-06-25 20:06:29', 5, 3),
(2, 2, 3, '2025-06-05', 'Asma stabil', 'Kondisi membaik, kontrol sebulan kemudian.', '2025-06-10 23:02:44', '2025-06-10 23:02:44', 1, 3),
(3, 3, 3, '2025-06-07', 'Apendisitis pasca operasi', 'Pasca operasi lancar, observasi rawat inap.', '2025-06-10 23:02:44', '2025-06-10 23:02:44', 4, 3),
(4, 4, 3, '2025-06-09', 'Vertigo vestibular', 'Pemberian betahistine efektif.', '2025-06-10 23:02:44', '2025-06-10 23:02:44', 1, 3),
(5, 5, 3, '2025-06-11', 'Dermatitis sembuh', 'Pasien menunjukkan perbaikan setelah pengobatan.', '2025-06-10 23:02:44', '2025-06-10 23:02:44', 1, 3),
(6, 6, 3, '2025-06-14', 'tekanan darah tinggi', 'perbaiki posisi duduk, kurangi begadang', '2025-06-13 22:19:17', '2025-07-15 16:23:48', 1, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `diagnosa_awal`
--

CREATE TABLE `diagnosa_awal` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `diagnosa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('sudah_diperiksa','belum_diperiksa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_diperiksa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `master_diagnosa_id` bigint UNSIGNED DEFAULT NULL,
  `pelayanan_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `diagnosa_awal`
--

INSERT INTO `diagnosa_awal` (`id`, `pasien_id`, `user_id`, `tanggal`, `diagnosa`, `catatan`, `status`, `created_at`, `updated_at`, `master_diagnosa_id`, `pelayanan_id`) VALUES
(1, 1, 4, '2025-06-01', 'Migrain akut', 'Disarankan terapi obat dan istirahat cukup.', 'belum_diperiksa', '2025-06-10 23:00:32', '2025-06-10 23:00:32', 5, 3),
(2, 2, 4, '2025-06-03', 'Asma bronkial ringan', 'Pasien diberikan inhaler dan edukasi lingkungan.', 'belum_diperiksa', '2025-06-10 23:00:32', '2025-06-10 23:00:32', 1, 3),
(3, 3, 4, '2025-06-06', 'Apendisitis akut', 'Pasien dijadwalkan untuk operasi.', 'belum_diperiksa', '2025-06-10 23:00:32', '2025-06-10 23:00:32', 4, 3),
(4, 4, 4, '2025-06-08', 'Vertigo sentral', 'Direkomendasikan MRI jika gejala berlanjut.', 'belum_diperiksa', '2025-06-10 23:00:32', '2025-06-10 23:00:32', 1, 3),
(5, 5, 4, '2025-06-10', 'Dermatitis kontak', 'Berikan antihistamin topikal dan edukasi kebersihan.', 'sudah_diperiksa', '2025-06-10 23:00:32', '2025-07-15 16:42:23', 1, 3),
(6, 6, 4, '2025-06-14', 'skoliosis dan tekanan darah tinggi', 'kurangi begadang dan duduk di kursi terlalu lama', 'sudah_diperiksa', '2025-06-13 22:10:47', '2025-07-15 16:40:41', 1, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Dokter Umum', NULL, NULL),
(2, 'Perawat Pelaksana', NULL, NULL),
(3, 'Kepala Ruangan', NULL, NULL),
(4, 'Apoteker', NULL, '2025-06-29 21:45:40'),
(5, 'Admin Stok Obat', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_diagnosa`
--

CREATE TABLE `master_diagnosa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `master_diagnosa`
--

INSERT INTO `master_diagnosa` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Hipertensi', '2025-07-09 23:58:26', '2025-07-09 23:58:26'),
(2, 'Diabetes Mellitus Tipe 2', '2025-07-09 23:58:26', '2025-07-09 23:58:26'),
(3, 'ISPA (Infeksi Saluran Pernapasan Akut)', '2025-07-09 23:58:26', '2025-07-09 23:58:26'),
(4, 'Gastritis (Radang Lambung)', '2025-07-09 23:58:26', '2025-07-09 23:58:26'),
(5, 'Demam Berdarah Dengue (DBD)', '2025-07-09 23:58:26', '2025-07-09 23:58:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2025_06_09_052638_create_roles_table', 1),
(5, '2025_06_09_053951_create_jabatan_table', 1),
(6, '2025_06_09_054155_create_satuan_obat_table', 1),
(7, '2025_06_09_054241_create_pelayanan_table', 1),
(8, '2025_06_09_054611_create_asuransi_table', 1),
(9, '2025_06_09_054709_create_users_table', 1),
(10, '2025_06_09_055031_create_pegawai_table', 1),
(11, '2025_06_09_055708_create_pasien_table', 1),
(12, '2025_06_09_061749_create_obat_table', 1),
(13, '2025_06_09_061829_create_sediaan_obat_table', 1),
(14, '2025_06_09_061935_create_pengkajian_awal_table', 1),
(15, '2025_06_09_062029_create_diagnosa_awal_table', 1),
(16, '2025_06_09_062056_create_diagnosa_akhir_table', 1),
(17, '2025_06_09_062159_create_tindakan_table', 1),
(18, '2025_06_09_062253_create_resep_table', 1),
(19, '2025_06_09_062439_create_resep_detail_table', 1),
(20, '2025_06_09_062512_create_pengambilan_obat_table', 1),
(21, '2025_06_09_062829_create_rekam_medis_table', 1),
(22, '2025_06_17_135136_add_tanggal_keluar_to_sediaan_obat_table', 2),
(23, '2025_06_17_140517_add_status_to_diagnosa_awal_table', 3),
(24, '2025_06_17_141004_add_status_to_pengkajian_awal_table', 4),
(25, '2025_07_10_062114_create_asal_pendaftaran_table', 5),
(26, '2025_07_10_062227_create_master_diagnosa_table', 6),
(27, '2025_07_10_062413_create_perawat_dokter_table', 7),
(28, '2025_07_10_062544_create_pelayanan_tindakan_table', 8),
(29, '2025_07_10_062657_create_pendaftaran_table', 9),
(30, '2025_07_10_063204_add_pelayanan_to_pengkajian_awal_table', 10),
(31, '2025_07_10_065216_add_master_diagnosa_fields_to_diagnosa_awal', 11),
(32, '2025_07_10_065330_add_master_diagnosa_fields_to_diagnosa_akhir', 12),
(33, '2025_07_10_071818_add_pelayanan_id_to_resep_table', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_obat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_id` bigint UNSIGNED NOT NULL,
  `stok_total` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `satuan_id`, `stok_total`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Paracetamol', 1, 100, 'Obat demam dan nyeri sendi', NULL, '2025-06-13 22:41:41'),
(2, 'Amoxicillin', 2, 80, 'Antibiotik', NULL, NULL),
(3, 'OBH Combi', 3, 50, 'Obat batuk', NULL, NULL),
(4, 'Neurobion', 1, 60, 'Vitamin B', NULL, NULL),
(5, 'Betadine', 5, 70, 'Antiseptik', NULL, NULL),
(6, 'citirizine', 1, 50, 'obat alergi', '2025-06-13 22:40:59', '2025-06-13 22:40:59'),
(7, 'Dopamine', 3, 50, 'dosis tinggi', '2025-06-13 23:19:17', '2025-07-15 15:52:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` bigint UNSIGNED NOT NULL,
  `asuransi_id` bigint UNSIGNED DEFAULT NULL,
  `NIK` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `asuransi_id`, `NIK`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `no_hp`, `tanggal_daftar`, `created_at`, `updated_at`) VALUES
(1, NULL, '3173012345678901', 'Ahmad Fauzi', '1985-05-20', 'L', 'Jl. Kenanga No. 12, Jakarta', '081234111222', '2025-06-01', '2025-06-10 22:55:26', '2025-06-24 16:46:24'),
(2, 1, '3173012345678902', 'Dewi Kartika', '1990-09-15', 'P', 'Jl. Mawar No. 8, Bekasi', '081234222333', '2025-06-03', '2025-06-10 22:55:26', '2025-06-10 22:55:26'),
(3, 2, '3173012345678903', 'Satria Nugroho', '1978-02-10', 'L', 'Jl. Anggrek No. 5, Depok', '081234333444', '2025-06-06', '2025-06-10 22:55:26', '2025-06-10 22:55:26'),
(4, NULL, '3173012345678904', 'Melati Hasanah', '1983-07-01', 'P', 'Jl. Melati No. 9, Tangerang', '081234444555', '2025-06-08', '2025-06-10 22:55:26', '2025-06-10 22:55:26'),
(5, 1, '3173012345678905', 'Andika Surya', '1995-11-22', 'L', 'Jl. Dahlia No. 17, Bogor', '081234555666', '2025-06-10', '2025-06-10 22:55:26', '2025-06-10 22:55:26'),
(6, 2, '3791744798987609', 'santi', '2010-01-09', 'P', 'JL. wijaya kusuma no.4', '098765567889', '2025-06-14', '2025-06-13 22:03:42', '2025-06-13 22:04:05'),
(7, 5, '3791744798987608', 'Feri Aman Saragih', '2000-09-18', 'L', 'Jl batur , Andalas', '085163038258', '2025-06-17', '2025-06-17 06:02:55', '2025-06-17 06:02:55'),
(10, 6, '3791744798987165', 'Joko Widodo', '1987-06-03', 'L', 'jl raya jember', '081234123222', '2025-07-03', '2025-07-02 18:22:40', '2025-07-02 18:22:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint UNSIGNED NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ttl` date NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `str` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `instansi_induk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_berlaku` date DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id`, `nik`, `nip`, `nama_lengkap`, `gelar`, `jenis_kelamin`, `ttl`, `alamat`, `email`, `no_telp`, `str`, `sip`, `jabatan_id`, `instansi_induk`, `tanggal_berlaku`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '3173123456789012', '198765432', 'Dr. Rina Wijaya', 'S.Ked', 'P', '1980-03-12', 'Jl. Melati No. 10, Jakarta', 'rina@klinik.com', '081234567890', 'STR-12345', 'SIP-54321', 1, 'Klinik Harapan Sehat', '2025-06-11', NULL, NULL, NULL),
(2, '3173022233445566', '2001123456', 'Drg. Ahmad Fauzi', 'drg.', 'L', '1979-06-25', 'Jl. Anggrek No. 15, Depok', 'ahmad@klinik.com', '081298765432', 'STR-67890', 'SIP-09876', 2, 'Klinik Harapan Sehat', '2025-06-11', NULL, NULL, NULL),
(3, '3173011122334455', NULL, 'Siti Nurhaliza', 'Ns.', 'P', '1987-11-04', 'Jl. Mawar No. 22, Bekasi', 'siti@klinik.com', '082112345678', 'STR-11223', 'SIP-33445', 3, 'Klinik Harapan Sehat', '2025-06-11', NULL, NULL, NULL),
(4, '3173009988776655', '1991123488', 'Rahmat Pratama', 'S.Farm., Apt.', 'L', '1991-01-15', 'Jl. Cemara No. 8, Tangerang', 'rahmat@klinik.com', '081345678901', 'STR-44556', 'SIP-66778', 4, 'Klinik Harapan Sehat', '2025-06-11', NULL, NULL, NULL),
(5, '3173998877665544', NULL, 'Lisa Permata', '-', 'P', '1995-09-23', 'Jl. Teratai No. 9, Bogor', 'lisa@klinik.com', '081356789012', NULL, NULL, 5, 'Klinik Harapan Sehat', '2025-06-11', NULL, NULL, NULL),
(6, '3829463272828282', '12224', 'Nur Hayati', 'S.I', 'P', '2000-01-14', 'JL. widuri no. 9', NULL, '089977566411', 'STR-551', 'SIP-6655', 4, 'KLINIK SEHAT SEJAHTERA', '2025-06-14', NULL, '2025-06-13 22:53:08', '2025-06-13 22:53:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pelayanan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `biaya` decimal(10,2) NOT NULL,
  `status` enum('Aktif','Nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelayanan`
--

INSERT INTO `pelayanan` (`id`, `nama_pelayanan`, `deskripsi`, `biaya`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pemeriksaan Umum', 'Layanan pemeriksaan kesehatan umum', 50000.00, 'Aktif', NULL, NULL),
(2, 'Konsultasi Dokter Gigi', 'Layanan konsultasi dokter gigi', 75000.00, 'Aktif', NULL, NULL),
(3, 'Laboratorium', 'Layanan pemeriksaan laboratorium', 100000.00, 'Aktif', NULL, NULL),
(4, 'Imunisasi', 'Layanan pemberian vaksin dan imunisasi', 45000.00, 'Aktif', NULL, NULL),
(5, 'Kesehatan Ibu & Anak', 'Layanan untuk ibu hamil dan anak-anak', 65000.00, 'Aktif', NULL, NULL),
(6, 'Cek darah', 'memeriksa tekanan darah pasien', 50000.00, 'Aktif', '2025-06-13 22:05:28', '2025-07-02 00:32:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `jenis_kunjungan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter_id` bigint UNSIGNED NOT NULL,
  `tindakan_id` bigint UNSIGNED DEFAULT NULL,
  `asal_pendaftaran_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perawat_id` bigint UNSIGNED DEFAULT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id`, `pasien_id`, `jenis_kunjungan`, `dokter_id`, `tindakan_id`, `asal_pendaftaran_id`, `status`, `perawat_id`, `keluhan`, `created_at`, `updated_at`) VALUES
(6, 1, 'baru', 3, 6, 1, 'selesai', 8, 'Demam tinggi sejak dua hari lalu.', '2025-07-10 06:50:43', '2025-07-10 06:50:43'),
(7, 2, 'lama', 3, 7, 2, 'selesai', 4, 'Kontrol rutin pasca rawat inap.', '2025-07-10 06:50:43', '2025-07-10 06:50:43'),
(8, 3, 'baru', 3, 8, 3, 'diperiksa', 8, 'Keluhan nyeri di dada kiri.', '2025-07-10 06:50:43', '2025-07-10 06:50:43'),
(9, 4, 'lama', 3, NULL, 4, 'menunggu', NULL, 'Keluhan sakit kepala terus-menerus.', '2025-07-10 06:50:43', '2025-07-10 06:50:43'),
(10, 5, 'baru', 3, 9, 5, 'selesai', 4, 'Pemeriksaan kesehatan umum.', '2025-07-10 06:50:43', '2025-07-10 06:50:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengambilan_obat`
--

CREATE TABLE `pengambilan_obat` (
  `id` bigint UNSIGNED NOT NULL,
  `resep_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal_pengambilan` date NOT NULL,
  `status_checklist` enum('belum','sudah') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengambilan_obat`
--

INSERT INTO `pengambilan_obat` (`id`, `resep_id`, `user_id`, `tanggal_pengambilan`, `status_checklist`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2025-06-02', 'belum', '2025-06-10 23:15:11', '2025-06-10 23:15:11'),
(2, 2, 5, '2025-06-04', 'sudah', '2025-06-10 23:15:11', '2025-06-10 23:15:11'),
(3, 3, 5, '2025-06-06', 'belum', '2025-06-10 23:15:11', '2025-06-10 23:15:11'),
(4, 4, 5, '2025-06-08', 'belum', '2025-06-10 23:15:11', '2025-06-10 23:15:11'),
(5, 5, 5, '2025-06-10', 'belum', '2025-06-10 23:15:11', '2025-06-10 23:15:11'),
(6, 6, 5, '2025-06-14', 'sudah', '2025-06-13 22:39:51', '2025-07-15 15:30:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengkajian_awal`
--

CREATE TABLE `pengkajian_awal` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keluhan_utama` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tekanan_darah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suhu_tubuh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `pelayanan_id` bigint UNSIGNED DEFAULT NULL,
  `diagnosa_awal` text COLLATE utf8mb4_unicode_ci,
  `status` enum('sudah','belum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengkajian_awal`
--

INSERT INTO `pengkajian_awal` (`id`, `pasien_id`, `user_id`, `tanggal`, `keluhan_utama`, `tekanan_darah`, `suhu_tubuh`, `catatan`, `pelayanan_id`, `diagnosa_awal`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 4, '2025-06-01', 'Sakit kepala hebat sejak semalam', '130/85', '37.2', 'Pasien tampak lemah. Disarankan pemeriksaan lanjutan.', 1, NULL, 'belum', '2025-06-10 22:58:36', '2025-06-10 22:58:36'),
(2, 2, 4, '2025-06-03', 'Sesak napas dan batuk kering', '125/80', '36.9', 'Perlu observasi lebih lanjut untuk kemungkinan asma.', 1, NULL, 'belum', '2025-06-10 22:58:36', '2025-06-10 22:58:36'),
(3, 3, 4, '2025-06-06', 'Nyeri tajam di perut kanan bawah', '120/75', '38.0', 'Kemungkinan apendisitis. Rujuk ke bagian bedah.', 1, NULL, 'belum', '2025-06-10 22:58:36', '2025-06-10 22:58:36'),
(4, 4, 4, '2025-06-08', 'Pusing dan mual setiap pagi', '110/70', '36.7', 'Disarankan tes laboratorium darah lengkap.', 1, NULL, 'belum', '2025-06-10 22:58:36', '2025-06-10 22:58:36'),
(5, 5, 4, '2025-06-10', 'Ruam merah dan gatal di tangan', '115/75', '36.8', 'Kemungkinan alergi kontak. Anjurkan hindari sabun baru.', 1, NULL, 'belum', '2025-06-10 22:58:36', '2025-06-10 22:58:36'),
(6, 6, 4, '2025-06-14', 'sakit pinggang', '120', '35', 'kelelahan karena sering lembur', 1, NULL, 'belum', '2025-06-13 22:07:32', '2025-06-25 16:59:12'),
(7, 1, 4, '2025-06-30', 'demam, meriang', '120', '30', 'ini contoh', 1, NULL, 'sudah', '2025-06-30 03:26:10', '2025-07-02 00:47:36'),
(9, 2, 8, '2025-07-08', 'pusing, mual, pegal-pegal', '100', '30', 'demam', 1, 'demam', 'sudah', '2025-07-07 16:15:43', '2025-07-15 16:57:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosa` text COLLATE utf8mb4_unicode_ci,
  `tindakan_id` bigint UNSIGNED DEFAULT NULL,
  `catatan_tambahan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`id`, `pasien_id`, `tanggal_kunjungan`, `keluhan`, `diagnosa`, `tindakan_id`, `catatan_tambahan`, `created_at`, `updated_at`) VALUES
(11, 1, '2025-06-01', 'Demam tinggi selama 3 hari.', 'Demam Berdarah', 6, 'Perlu rawat inap 3 hari.', '2025-06-10 23:46:55', '2025-06-10 23:46:55'),
(12, 2, '2025-06-04', 'Batuk kering dan sesak napas.', 'Asma Bronkial', 7, 'Diresepkan inhaler dan kontrol rutin.', '2025-06-10 23:46:55', '2025-06-10 23:46:55'),
(13, 3, '2025-06-06', 'Nyeri di perut kanan bawah.', 'Apendisitis akut', 8, 'Operasi dijadwalkan segera.', '2025-06-10 23:46:55', '2025-06-10 23:46:55'),
(14, 4, '2025-06-08', 'Sakit kepala dan mual.', 'Migrain', 9, 'Berikan analgesik dan istirahat.', '2025-06-10 23:46:55', '2025-06-10 23:46:55'),
(15, 5, '2025-06-10', 'Ruam kulit dan gatal.', 'Dermatitis kontak', 10, 'Hindari alergen dan gunakan salep.', '2025-06-10 23:46:55', '2025-06-10 23:46:55'),
(16, 6, '2025-06-14', 'sakit pinggang', 'darah tinggi', 6, 'diberikan obat penurun tekanan darah', '2025-06-13 22:32:23', '2025-06-13 22:33:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep`
--

CREATE TABLE `resep` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pelayanan_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `resep`
--

INSERT INTO `resep` (`id`, `pasien_id`, `user_id`, `pelayanan_id`, `tanggal`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, '2025-06-01', 'Paracetamol 500mg, diminum 3x sehari.', '2025-06-10 23:06:00', '2025-06-10 23:06:00'),
(2, 2, 3, 1, '2025-06-03', 'Amoxicillin 500mg, 3x sehari setelah makan.', '2025-06-10 23:06:00', '2025-06-10 23:06:00'),
(3, 3, 3, 1, '2025-06-06', 'Ranitidine 150mg, 2x sehari.', '2025-06-10 23:06:00', '2025-06-10 23:06:00'),
(4, 4, 3, 1, '2025-06-08', 'Ibuprofen 400mg, jika nyeri.', '2025-06-10 23:06:00', '2025-06-10 23:06:00'),
(5, 5, 3, 1, '2025-06-10', 'Salep kortikosteroid, oleskan 2x sehari.', '2025-06-10 23:06:00', '2025-06-10 23:06:00'),
(6, 6, 3, 1, '2025-06-14', 'Amoxillin 100mg,diminum 2x sehari', '2025-06-13 22:27:40', '2025-07-15 15:30:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep_detail`
--

CREATE TABLE `resep_detail` (
  `id` bigint UNSIGNED NOT NULL,
  `resep_id` bigint UNSIGNED NOT NULL,
  `obat_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `dosis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aturan_pakai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `resep_detail`
--

INSERT INTO `resep_detail` (`id`, `resep_id`, `obat_id`, `jumlah`, `dosis`, `aturan_pakai`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 10, '500mg', '3x sehari setelah makan', '2025-06-10 23:08:07', '2025-06-10 23:08:07'),
(2, 2, 2, 15, '500mg', '3x sehari', '2025-06-10 23:08:07', '2025-06-10 23:08:07'),
(3, 3, 3, 10, '150mg', '2x sehari sebelum makan', '2025-06-10 23:08:07', '2025-06-10 23:08:07'),
(4, 4, 4, 5, '400mg', 'Jika nyeri', '2025-06-10 23:08:07', '2025-06-10 23:08:07'),
(5, 5, 5, 1, 'Salep', 'Oles 2x sehari', '2025-06-10 23:08:07', '2025-06-10 23:08:07'),
(32, 6, 2, 15, '100mg', '3x sehari setelah makan', '2025-07-02 17:38:49', '2025-07-02 17:38:49'),
(33, 6, 1, 15, '100mg', '3x sehari setelah makan', '2025-07-02 17:38:49', '2025-07-02 17:38:49'),
(34, 6, 3, 1, '200mg', '3x sehari setelah makan', '2025-07-02 17:38:49', '2025-07-02 17:38:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'Admin IT', NULL, NULL),
(2, 'Admin Pendaftaran', NULL, NULL),
(3, 'Dokter', NULL, NULL),
(4, 'Perawat', NULL, NULL),
(5, 'Apoteker', NULL, NULL),
(6, 'Admin Stok Obat', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan_obat`
--

CREATE TABLE `satuan_obat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `satuan_obat`
--

INSERT INTO `satuan_obat` (`id`, `nama_satuan`, `created_at`, `updated_at`) VALUES
(1, 'Tablet', NULL, NULL),
(2, 'Kapsul', NULL, NULL),
(3, 'Botol', NULL, NULL),
(4, 'Ampul', NULL, NULL),
(5, 'Salep', NULL, NULL),
(6, 'ml', '2025-06-13 22:43:06', '2025-06-25 21:38:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sediaan_obat`
--

CREATE TABLE `sediaan_obat` (
  `id` bigint UNSIGNED NOT NULL,
  `obat_id` bigint UNSIGNED NOT NULL,
  `tanggal_kadaluarsa` date NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sediaan_obat`
--

INSERT INTO `sediaan_obat` (`id`, `obat_id`, `tanggal_kadaluarsa`, `tanggal_masuk`, `tanggal_keluar`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-12-31', '2025-01-01', NULL, 'Batch A1', NULL, NULL),
(2, 2, '2026-08-15', '2025-02-10', NULL, 'Batch B1', NULL, NULL),
(3, 3, '2026-05-10', '2025-03-12', NULL, 'Batch C1', NULL, NULL),
(4, 4, '2026-09-01', '2025-04-22', NULL, 'Batch D1', NULL, NULL),
(5, 5, '2026-11-20', '2025-05-15', NULL, 'Batch E1', NULL, NULL),
(6, 6, '2026-12-24', '2025-06-14', NULL, 'Batch F1', '2025-06-13 22:44:44', '2025-06-13 22:45:04'),
(7, 7, '2026-06-17', '2025-06-17', '2025-07-16', 'dosis tinggi', '2025-06-17 06:48:14', '2025-07-15 15:46:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan`
--

CREATE TABLE `tindakan` (
  `id` bigint UNSIGNED NOT NULL,
  `pasien_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_tindakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` decimal(18,2) NOT NULL DEFAULT '0.00',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tindakan`
--

INSERT INTO `tindakan` (`id`, `pasien_id`, `user_id`, `tanggal`, `jenis_tindakan`, `tarif`, `catatan`, `created_at`, `updated_at`) VALUES
(6, 1, 3, '2025-06-01', 'Pemeriksaan Umum', 50000.00, 'Pasien datang dengan keluhan pusing.', '2025-06-10 23:04:35', '2025-06-10 23:04:35'),
(7, 2, 3, '2025-06-03', 'Pemeriksaan THT', 75000.00, 'Pasien mengalami gangguan pendengaran.', '2025-06-10 23:04:35', '2025-06-10 23:04:35'),
(8, 3, 3, '2025-06-06', 'Tindakan Bedah Minor', 200000.00, 'Tindakan dilakukan di ruang operasi minor.', '2025-06-10 23:04:35', '2025-06-10 23:04:35'),
(9, 4, 3, '2025-06-08', 'Konsultasi Dokter', 30000.00, 'Konsultasi kesehatan umum.', '2025-06-10 23:04:35', '2025-06-10 23:04:35'),
(10, 5, 3, '2025-06-10', 'Pemeriksaan Kulit', 60000.00, 'Pasien mengeluhkan ruam pada tangan.', '2025-06-10 23:04:35', '2025-06-10 23:04:35'),
(11, 6, 3, '2025-06-14', 'pemeriksaan umum', 70000.00, 'pasien datang dengan keluhan sakit pinggang', '2025-06-13 22:22:19', '2025-06-13 22:23:25'),
(12, 1, 3, '2025-07-03', 'pemeriksaan umum', 30000.00, 'cek darah', '2025-07-02 16:57:23', '2025-07-02 16:57:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `nama_lengkap`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'adminit', '$2y$12$C/5BG7EsPn0kidVk4yO9cuTgb18NGwNDG7cZz4o6xgiHdLoRwd4ZK', 1, 'Admin Teknologi', 'adminit@klinik.com', 'aktif', NULL, NULL),
(2, 'pendaftaran1', '$2y$12$AER0bBO8.ETtDF0/ro5Z/O8CsyGNxPCANXfAu./6Hx/Ik9JJgfRxy', 2, 'Petugas Pendaftaran', 'daftar@klinik.com', 'aktif', NULL, NULL),
(3, 'dr_joko', '$2y$12$F4Yx1izWm5LA5fY5HdoRW.ZgIeDNb/9s3J2103x7OshIEzJKsQCay', 3, 'Dr. Joko Santoso', 'joko@klinik.com', 'aktif', NULL, NULL),
(4, 'nurse_ina', '$2y$12$KYSJ/S2CHFaI1I6gZIxam.yeqaeuO4xaaqVmwBtNvxS8Di6EHSOOG', 4, 'Ina Susanti', 'ina@klinik.com', 'aktif', NULL, NULL),
(5, 'apoteker_andi', '$2y$12$C0GIGsHBL0V9bJ7ew0C96OozjFBRFYDHgenk.sOSY1ZEkBbC8uRBW', 5, 'Andi Pratama Putra', 'andi@klinik.com', 'aktif', NULL, '2025-06-13 22:57:34'),
(6, 'admin_stok_obat', '$2y$12$eVwdysVmR.7kvvtBFUcS9OnQlr3Qft1VaS3uKWaw/26jA2Hfy8Cvu', 6, 'Ana Utami', 'ana@klinik.com', 'aktif', NULL, NULL),
(7, 'Agus', '$2y$12$MO067uZXkGzUM2tnln7/Z.hhog0BoRUgb3to8pg0clwsVBqNPj482', 2, 'Agus Hermawan', 'agusst1@gmail.com', 'aktif', '2025-06-13 23:09:13', '2025-07-02 16:20:18'),
(8, 'Alessia', '$2y$12$8IkBjZN5W42jvtri4D7HI.toZycUJYNCowf92Msy4cuixWm37Ytb2', 4, 'Alessia Langelo', 'alessia22@gmail.com', 'aktif', '2025-07-07 16:17:09', '2025-07-07 16:17:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `asal_pendaftaran`
--
ALTER TABLE `asal_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `asuransi`
--
ALTER TABLE `asuransi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `diagnosa_akhir`
--
ALTER TABLE `diagnosa_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnosa_akhir_pasien_id_foreign` (`pasien_id`),
  ADD KEY `diagnosa_akhir_user_id_foreign` (`user_id`),
  ADD KEY `diagnosa_akhir_master_diagnosa_id_foreign` (`master_diagnosa_id`),
  ADD KEY `diagnosa_akhir_pelayanan_id_foreign` (`pelayanan_id`);

--
-- Indeks untuk tabel `diagnosa_awal`
--
ALTER TABLE `diagnosa_awal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diagnosa_awal_pasien_id_foreign` (`pasien_id`),
  ADD KEY `diagnosa_awal_user_id_foreign` (`user_id`),
  ADD KEY `diagnosa_awal_master_diagnosa_id_foreign` (`master_diagnosa_id`),
  ADD KEY `diagnosa_awal_pelayanan_id_foreign` (`pelayanan_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_diagnosa`
--
ALTER TABLE `master_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obat_satuan_id_foreign` (`satuan_id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pasien_nik_unique` (`NIK`),
  ADD KEY `pasien_asuransi_id_foreign` (`asuransi_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawai_nik_unique` (`nik`),
  ADD KEY `pegawai_jabatan_id_foreign` (`jabatan_id`),
  ADD KEY `pegawai_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_pasien_id_foreign` (`pasien_id`),
  ADD KEY `pendaftaran_dokter_id_foreign` (`dokter_id`),
  ADD KEY `pendaftaran_tindakan_id_foreign` (`tindakan_id`),
  ADD KEY `pendaftaran_asal_pendaftaran_id_foreign` (`asal_pendaftaran_id`),
  ADD KEY `pendaftaran_perawat_id_foreign` (`perawat_id`);

--
-- Indeks untuk tabel `pengambilan_obat`
--
ALTER TABLE `pengambilan_obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengambilan_obat_resep_id_foreign` (`resep_id`),
  ADD KEY `pengambilan_obat_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pengkajian_awal`
--
ALTER TABLE `pengkajian_awal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengkajian_awal_pasien_id_foreign` (`pasien_id`),
  ADD KEY `pengkajian_awal_user_id_foreign` (`user_id`),
  ADD KEY `pengkajian_awal_pelayanan_id_foreign` (`pelayanan_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekam_medis_pasien_id_foreign` (`pasien_id`),
  ADD KEY `rekam_medis_tindakan_id_foreign` (`tindakan_id`);

--
-- Indeks untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resep_pasien_id_foreign` (`pasien_id`),
  ADD KEY `resep_user_id_foreign` (`user_id`),
  ADD KEY `resep_pelayanan_id_foreign` (`pelayanan_id`);

--
-- Indeks untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resep_detail_resep_id_foreign` (`resep_id`),
  ADD KEY `resep_detail_obat_id_foreign` (`obat_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `satuan_obat`
--
ALTER TABLE `satuan_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sediaan_obat`
--
ALTER TABLE `sediaan_obat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sediaan_obat_obat_id_foreign` (`obat_id`);

--
-- Indeks untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tindakan_pasien_id_foreign` (`pasien_id`),
  ADD KEY `tindakan_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `asal_pendaftaran`
--
ALTER TABLE `asal_pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `asuransi`
--
ALTER TABLE `asuransi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `diagnosa_akhir`
--
ALTER TABLE `diagnosa_akhir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `diagnosa_awal`
--
ALTER TABLE `diagnosa_awal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `master_diagnosa`
--
ALTER TABLE `master_diagnosa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pengambilan_obat`
--
ALTER TABLE `pengambilan_obat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengkajian_awal`
--
ALTER TABLE `pengkajian_awal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `resep`
--
ALTER TABLE `resep`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `satuan_obat`
--
ALTER TABLE `satuan_obat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `sediaan_obat`
--
ALTER TABLE `sediaan_obat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `diagnosa_akhir`
--
ALTER TABLE `diagnosa_akhir`
  ADD CONSTRAINT `diagnosa_akhir_master_diagnosa_id_foreign` FOREIGN KEY (`master_diagnosa_id`) REFERENCES `master_diagnosa` (`id`),
  ADD CONSTRAINT `diagnosa_akhir_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `diagnosa_akhir_pelayanan_id_foreign` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`),
  ADD CONSTRAINT `diagnosa_akhir_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `diagnosa_awal`
--
ALTER TABLE `diagnosa_awal`
  ADD CONSTRAINT `diagnosa_awal_master_diagnosa_id_foreign` FOREIGN KEY (`master_diagnosa_id`) REFERENCES `master_diagnosa` (`id`),
  ADD CONSTRAINT `diagnosa_awal_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `diagnosa_awal_pelayanan_id_foreign` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`),
  ADD CONSTRAINT `diagnosa_awal_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuan_obat` (`id`);

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `pasien_asuransi_id_foreign` FOREIGN KEY (`asuransi_id`) REFERENCES `asuransi` (`id`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`),
  ADD CONSTRAINT `pegawai_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_asal_pendaftaran_id_foreign` FOREIGN KEY (`asal_pendaftaran_id`) REFERENCES `asal_pendaftaran` (`id`),
  ADD CONSTRAINT `pendaftaran_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pendaftaran_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `pendaftaran_perawat_id_foreign` FOREIGN KEY (`perawat_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pendaftaran_tindakan_id_foreign` FOREIGN KEY (`tindakan_id`) REFERENCES `tindakan` (`id`);

--
-- Ketidakleluasaan untuk tabel `pengambilan_obat`
--
ALTER TABLE `pengambilan_obat`
  ADD CONSTRAINT `pengambilan_obat_resep_id_foreign` FOREIGN KEY (`resep_id`) REFERENCES `resep` (`id`),
  ADD CONSTRAINT `pengambilan_obat_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pengkajian_awal`
--
ALTER TABLE `pengkajian_awal`
  ADD CONSTRAINT `pengkajian_awal_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `pengkajian_awal_pelayanan_id_foreign` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`),
  ADD CONSTRAINT `pengkajian_awal_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `rekam_medis_tindakan_id_foreign` FOREIGN KEY (`tindakan_id`) REFERENCES `tindakan` (`id`);

--
-- Ketidakleluasaan untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `resep_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `resep_pelayanan_id_foreign` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `resep_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  ADD CONSTRAINT `resep_detail_obat_id_foreign` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `resep_detail_resep_id_foreign` FOREIGN KEY (`resep_id`) REFERENCES `resep` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sediaan_obat`
--
ALTER TABLE `sediaan_obat`
  ADD CONSTRAINT `sediaan_obat_obat_id_foreign` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`);

--
-- Ketidakleluasaan untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  ADD CONSTRAINT `tindakan_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`),
  ADD CONSTRAINT `tindakan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
