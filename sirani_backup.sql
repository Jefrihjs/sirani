-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sirani
CREATE DATABASE IF NOT EXISTS `sirani` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sirani`;

-- Dumping structure for table sirani.aktivitas_harian
CREATE TABLE IF NOT EXISTS `aktivitas_harian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','diajukan','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `atasan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aktivitas_harian_atasan_id_foreign` (`atasan_id`),
  KEY `aktivitas_harian_user_id_tanggal_index` (`user_id`,`tanggal`),
  CONSTRAINT `aktivitas_harian_atasan_id_foreign` FOREIGN KEY (`atasan_id`) REFERENCES `users` (`id`),
  CONSTRAINT `aktivitas_harian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.aktivitas_harian: ~0 rows (approximately)
DELETE FROM `aktivitas_harian`;

-- Dumping structure for table sirani.asn_profiles
CREATE TABLE IF NOT EXISTS `asn_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_jabatan` enum('Struktural','Fungsional','Pelaksana') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_kerja` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_teknis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan_ruang` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_kepegawaian` enum('PNS','PPPK') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atasan_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asn_profiles_user_id_unique` (`user_id`),
  KEY `asn_profiles_atasan_id_foreign` (`atasan_id`),
  CONSTRAINT `asn_profiles_atasan_id_foreign` FOREIGN KEY (`atasan_id`) REFERENCES `users` (`id`),
  CONSTRAINT `asn_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.asn_profiles: ~2 rows (approximately)
DELETE FROM `asn_profiles`;
INSERT INTO `asn_profiles` (`id`, `user_id`, `jabatan`, `jenis_jabatan`, `unit_kerja`, `unit_teknis`, `golongan_ruang`, `status_kepegawaian`, `atasan_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Pranata Komputer Muda', 'Fungsional', 'Dinas Komunikasi Informatika Statistik dan Persandian', 'Bidang Aptika', 'Penata / IIIc', 'PNS', 2, '2026-02-03 21:45:39', '2026-02-11 06:47:41'),
	(2, 4, 'Pranata Komputer Ahli Muda', 'Fungsional', 'Dinas Komunikasi Informatika Statistik dan persandian', 'Aptika', 'Penata / IIIc', 'PNS', 2, '2026-02-11 20:23:59', '2026-02-11 22:51:57'),
	(3, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-13 20:27:52', '2026-02-13 20:27:52');

-- Dumping structure for table sirani.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table sirani.laporan_foto
CREATE TABLE IF NOT EXISTS `laporan_foto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `laporan_kegiatan_id` bigint unsigned NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_foto_laporan_kegiatan_id_foreign` (`laporan_kegiatan_id`),
  CONSTRAINT `laporan_foto_laporan_kegiatan_id_foreign` FOREIGN KEY (`laporan_kegiatan_id`) REFERENCES `laporan_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.laporan_foto: ~0 rows (approximately)
DELETE FROM `laporan_foto`;

-- Dumping structure for table sirani.laporan_kegiatan
CREATE TABLE IF NOT EXISTS `laporan_kegiatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `master_kegiatan_id` bigint unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `durasi_menit` int NOT NULL DEFAULT '0',
  `tempat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_kegiatan_master_kegiatan_id_foreign` (`master_kegiatan_id`),
  KEY `laporan_kegiatan_user_id_foreign` (`user_id`),
  CONSTRAINT `laporan_kegiatan_master_kegiatan_id_foreign` FOREIGN KEY (`master_kegiatan_id`) REFERENCES `master_kegiatan` (`id`),
  CONSTRAINT `laporan_kegiatan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.laporan_kegiatan: ~9 rows (approximately)
DELETE FROM `laporan_kegiatan`;
INSERT INTO `laporan_kegiatan` (`id`, `user_id`, `master_kegiatan_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `durasi_menit`, `tempat`, `uraian`, `foto`, `created_at`, `updated_at`) VALUES
	(8, 1, 11, '2026-02-12', '08:05:00', '16:00:00', 475, 'Diskominfo', 'Pengembangan dan penyempurnaan aplikasi SIRANI berbasis Laravel yang mencakup finalisasi tampilan dashboard dengan KPI berbasis menit, perapihan struktur layout dengan menghapus duplikasi header dan memastikan penggunaan satu layout utama, perbaikan modul Manajemen User (tambah dan edit user dengan validasi yang benar), penyesuaian sistem Master Kegiatan agar bersifat personal per user dengan filtering yang sesuai pada form input laporan, serta pembenahan struktur CSS dan sidebar agar tampilan lebih stabil, konsisten, dan siap untuk tahap pengujian lanjutan serta persiapan deployment.', '["laporan_kegiatan/c4BpeNO72gjs9TQNKP29TJRDVoyh9Cc3POjR5Wyk.png", "laporan_kegiatan/f00HQhFofn7CL9o92cQCoaonp6PrVGo3q152Kxce.png"]', '2026-02-12 01:21:16', '2026-02-12 01:55:16'),
	(9, 1, 11, '2026-02-11', '07:30:00', '16:00:00', 510, 'Diskominfo', 'Pengembangan lanjutan aplikasi SIRANI yang berfokus pada pembenahan struktur layout dan stabilisasi tampilan dashboard, termasuk perbaikan konflik route yang menyebabkan error pada menu Manajemen User, penghapusan layout lama berbasis x-app-layout yang menimbulkan tampilan dobel, penyesuaian struktur sidebar agar tidak menggunakan position: fixed sehingga tidak merusak flex layout, serta perbaikan file CSS yang sebelumnya mengalami error 404 karena kesalahan penamaan; selain itu dilakukan penyempurnaan modul Manajemen User menggunakan Admin\\UserController berbasis resource route sehingga fitur tambah dan edit user berjalan normal dengan validasi yang tepat dan struktur kode lebih rapi serta siap dikembangkan lebih lanjut.', '["laporan_kegiatan/BHPUaQqPozNQ1Vzyc98pFuQHbO2U5F0vcPqBS7AD.png", "laporan_kegiatan/DXy36xEIGyakvXnezEK0CEG3085o7p7OyEzsmeP7.png", "laporan_kegiatan/JmtQvxB8M0abKmrBcI1VXk9GVKkU1kkYb0xj0uEk.png", "laporan_kegiatan/OpmuvOATDm86jDem0SmEbNRdH2qhdqWz5BcKiCJ1.png"]', '2026-02-12 01:49:21', '2026-02-12 01:55:16'),
	(11, 1, 13, '2026-02-13', '08:30:00', '12:30:00', 240, 'Taman Kota Manggar', 'Melaksanakan fasilitasi dukungan perangkat pada kegiatan GPM Serentak Nasional yang diselenggarakan secara hybrid pada Jumat, 13 Februari 2026, dengan melakukan pemasangan dan pengaturan perangkat teleconference di lokasi kegiatan Taman Kota Manggar, meliputi penyiapan jaringan internet, perangkat laptop/PC, kamera, layar/monitor, sistem audio, serta pengujian koneksi guna memastikan pelaksanaan kegiatan dan pelaporan secara daring dapat berjalan lancar dan tanpa kendala teknis', '["laporan_kegiatan/WINVgI8Puj8eGNN31aXoi0U50DWCzMe6tHqqprp3.jpg", "laporan_kegiatan/DlCC6RJ3P54pcAGq9v3QUhwcEDgNky5kyPm7FUVo.jpg", "laporan_kegiatan/2oo8Ue6vBN9WJDE5CVLa7KkklXZhUTJnLDcjoknd.jpg", "laporan_kegiatan/mkUMUxnOw5FZU49dXumaHq9OPJxKY8tNPyoFXH0X.jpg"]', '2026-02-13 01:16:39', '2026-02-19 18:18:23'),
	(12, 1, 14, '2026-02-18', '07:30:00', '08:00:00', 30, 'Kantor Bupati', 'Apel bersama', '["laporan_kegiatan/o29fJTeWqKz4i7kH9rsoTtTqKoUtpX8Iyfqm3LGn.jpg", "laporan_kegiatan/804F4wZP1GvEJycOmsw6aqwFZ3IVhOusNYWMKEB9.jpg"]', '2026-02-17 19:18:19', '2026-02-17 19:18:19'),
	(13, 1, 11, '2026-02-19', '08:00:00', '15:00:00', 420, 'Diskominfo', 'Melakukan pengembangan dan penyempurnaan pada Dashboard Layanan TTE, meliputi perbaikan tampilan UI agar lebih konsisten dan profesional, penambahan filter interaktif berdasarkan jenis permohonan dan triwulan yang saling terintegrasi, pembuatan indikator visual aktif pada kartu statistik, penambahan ringkasan komposisi data dalam bentuk pie chart, serta perapian tampilan responsif untuk perangkat mobile. Selain itu, dilakukan pembaruan manajemen admin dan sinkronisasi perubahan ke repositori Git untuk memastikan versi pengembangan terdokumentasi dengan baik.', '["laporan_kegiatan/laporan_6996b51f8c574.jpg", "laporan_kegiatan/laporan_6996b51fb498e.jpg"]', '2026-02-19 00:00:47', '2026-02-19 00:00:47'),
	(14, 1, 11, '2026-02-18', '08:01:00', '16:00:00', 479, 'Diskominfo', 'Pengembangan lanjutan aplikasi Layanan TTE dengan fokus pada penyempurnaan alur permohonan dan dashboard administrasi. Pekerjaan mencakup implementasi validasi input NIK secara terstruktur (meliputi pengecekan format, tanggal lahir, dan nomor urut), penyesuaian serta penyeragaman jenis permohonan menjadi Pendaftaran Baru, Reset Passphrase, dan Perpanjangan Sertifikat, serta penyempurnaan fitur login admin untuk tiga akun verifikator. Selain itu dilakukan pengembangan dashboard monitoring yang menampilkan statistik permohonan per tahun dan per triwulan, fitur detail permohonan dengan status pending dan diproses yang dilengkapi pencatatan diproses_oleh dan diproses_pada, serta fitur export data ke Excel. Tahap polishing antarmuka juga dilakukan pada bagian header dan tampilan dashboard agar lebih rapi, konsisten, dan informatif sehingga mendukung proses verifikasi yang lebih terstruktur dan efisien.', '["laporan_kegiatan/laporan_6997b0a86b929.jpg", "laporan_kegiatan/laporan_6997b0a92eab8.jpg"]', '2026-02-19 17:54:01', '2026-02-19 18:18:23'),
	(15, 1, 13, '2026-02-25', '08:00:00', '15:00:00', 420, 'Dapur MBG Manggar Desa Padang', 'Menindaklanjuti surat permohonan sebagaimana tercantum dalam surat Nomor 002/SPPG_MGR/II/2026 tanggal 23 Februari 2026\r\nDinas Komunikasi dan Informatika Kabupaten Belitung Timur telah melaksanakan dan memenuhi permintaan peminjaman fasilitas untuk mendukung kegiatan Pelatihan Penjamaah Makanan Relawan yang diselenggarakan pada tanggal 25–26 Februari 2026 di SPPG Padang Manggar Bahari dan Samudera. Fasilitas yang disediakan meliputi 1 unit infocus, 1 unit speaker, serta dukungan 2 orang operator vicon, yang telah digunakan selama kegiatan berlangsung dan dikembalikan sesuai jadwal yang telah ditentukan, sehingga pelaksanaan kegiatan dapat berjalan dengan lancar dan tertib.', '["laporan_kegiatan/laporan_69a100de2efee.jpg", "laporan_kegiatan/laporan_69a100df50a9c.jpg"]', '2026-02-26 19:26:39', '2026-02-26 19:26:39'),
	(16, 1, 13, '2026-02-26', '08:00:00', '15:00:00', 420, 'Dapur MBG Manggar Desa Padang', 'Melaksanakan dan memenuhi permintaan peminjaman fasilitas untuk mendukung kegiatan Pelatihan Penjamaah Makanan Relawan yang diselenggarakan pada tanggal 25–26 Februari 2026 di SPPG Padang Manggar Bahari dan Samudera', '["laporan_kegiatan/laporan_69a1018a8b262.jpg", "laporan_kegiatan/laporan_69a1018ac404c.jpg"]', '2026-02-26 19:29:30', '2026-02-26 19:29:30'),
	(17, 1, 13, '2026-02-27', '08:00:00', '11:30:00', 210, 'Kantor Bupati', 'Entry Meeting Evaluasi Perencanaan dan Penganggaran Tahun\r\n2026 serta Penyampaian Hasil Evaluasi SPIP Terintegrasi Tahun 2025 pada\r\nPemerintah Daerah di Wilayah Provinsi Kepulauan Bangka Belitung', '["laporan_kegiatan/x58hKUgZ0u1Wvwrqv212IVX5CJ6uVOmewcsWWrCg.jpg", "laporan_kegiatan/u5DLspBX5keL2tfocJhPLToCjxT4iQAO2wcbupYg.png"]', '2026-02-27 01:00:23', '2026-02-27 01:02:34'),
	(18, 1, 11, '2026-03-12', '08:00:00', '15:00:00', 420, 'Diskominfo', 'Melakukan pembaharuan antarmuka (UI) pada aplikasi SiCERIA dengan mengimplementasikan desain Sidebar modern yang dilengkapi fitur "Dropdown Melayang" (Floating Menu) untuk meningkatkan efisiensi navigasi saat menu dalam kondisi ciut (collapsed). Selain itu, dilakukan standarisasi tipografi menggunakan font gaya Black dan Uppercase guna memperkuat identitas visual aplikasi, serta memperbaiki integrasi logo pada halaman autentikasi agar tampil lebih optimal dan responsif.\r\n\r\nMengoptimalkan sistem keamanan aplikasi dengan menonaktifkan jalur registrasi publik dan fitur reset password mandiri guna mencegah akses tidak sah, serta memindahkan otoritas pengelolaan akun sepenuhnya kepada administrator. Pekerjaan diakhiri dengan merapikan format tampilan uraian laporan menggunakan teknik text-justify dan whitespace-pre-line untuk memastikan hasil cetak laporan kerja tertata rapi per paragraf sesuai dengan standar dokumentasi kedinasan, kemudian seluruh perubahan kode telah diamankan ke dalam repositori Git.', '["laporan_kegiatan/laporan_69b264d0a4642.jpg", "laporan_kegiatan/laporan_69b264d1aabb2.jpg"]', '2026-03-12 00:01:37', '2026-03-12 00:10:18');

-- Dumping structure for table sirani.master_kegiatan
CREATE TABLE IF NOT EXISTS `master_kegiatan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `is_global` tinyint(1) NOT NULL DEFAULT '0',
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.master_kegiatan: ~7 rows (approximately)
DELETE FROM `master_kegiatan`;
INSERT INTO `master_kegiatan` (`id`, `user_id`, `is_global`, `nama_kegiatan`, `aktif`, `created_at`, `updated_at`) VALUES
	(7, 1, 0, 'Keikutsertaan dalam Kegiatan Pengembangan Kompetensi (Daring dan Luring)', 1, '2026-02-11 21:05:33', '2026-02-11 21:05:33'),
	(8, 1, 0, 'Melakukan Pemeliharaan Infrastruktur TI', 1, '2026-02-11 21:17:05', '2026-02-11 21:17:05'),
	(9, 1, 0, 'Dukungan Teknis Live Streaming', 1, '2026-02-11 21:22:26', '2026-02-11 21:22:26'),
	(10, 4, 0, 'Keikutsertaan dalam Kegiatan Pengembangan Kompetensi (Daring dan Luring)', 1, '2026-02-11 21:29:11', '2026-02-11 21:29:11'),
	(11, 1, 0, 'Pengelolaan Aplikasi dan Website Sistem Informasi', 1, '2026-02-11 21:31:39', '2026-02-11 21:31:39'),
	(12, 4, 0, 'Mengikuti Rapat', 1, '2026-02-11 23:11:55', '2026-02-11 23:11:55'),
	(13, 1, 0, 'Dukungan Teknis Video Conference', 1, '2026-02-12 18:26:16', '2026-02-12 18:26:16'),
	(14, NULL, 1, 'Mengikuti Apel', 1, '2026-02-12 23:14:11', '2026-02-12 23:14:11');

-- Dumping structure for table sirani.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.migrations: ~19 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_02_02_033853_add_role_to_users_table', 1),
	(6, '2026_02_02_044140_make_email_nullable_on_users_table', 1),
	(7, '2026_02_02_050114_create_master_kegiatan_table', 1),
	(8, '2026_02_02_053227_create_laporan_kegiatan_table', 1),
	(9, '2026_02_02_053722_create_laporan_foto_table', 1),
	(10, '2026_02_02_075318_add_foto_to_laporan_kegiatan_table', 1),
	(11, '2026_02_04_015531_add_photo_to_users_table', 1),
	(12, '2026_02_04_040519_create_asn_profiles_table', 1),
	(14, '2026_02_04_064012_create_aktivitas_harian_table', 2),
	(15, '2026_02_04_161425_add_durasi_menit_to_laporan_kegiatan', 1),
	(16, '2026_02_12_011442_add_is_active_to_users_table', 3),
	(17, '2026_02_12_025651_make_jabatan_nullable_on_asn_profiles', 4),
	(18, '2026_02_12_030213_make_asn_profiles_nullable', 5),
	(19, '2026_02_12_034255_add_user_id_to_master_kegiatan_table', 1),
	(20, '2026_02_12_040826_add_is_global_to_master_kegiatan_table', 6);

-- Dumping structure for table sirani.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.password_resets: ~0 rows (approximately)
DELETE FROM `password_resets`;

-- Dumping structure for table sirani.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping structure for table sirani.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pegawai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pegawai',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nip_unique` (`nip`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sirani.users: ~8 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `nip`, `name`, `email`, `photo`, `email_verified_at`, `password`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, '197809052010011012', 'Jefri Hunter Juanda Sianturi', NULL, 'profile/1.jpg', NULL, '$2y$10$VyOgSM51azhDQA2nQEv6tO617l8a/a5R7VPhe2lo9DgFSrxHge0T6', 'admin', 1, NULL, '2026-02-03 21:45:26', '2026-02-13 03:42:13'),
	(2, '198109112006041015', 'Caesar Friadi M, ST., M.Eng', 'admin@test.com', NULL, NULL, '$2y$10$BV0XdwsQXs6SRSZhC8DVJOmPrLtFXVoi1ZYXI4V6fZEUIZMY.6vRa', 'pegawai', 1, NULL, '2026-02-10 05:52:06', '2026-02-12 00:32:06'),
	(4, '198206222011011005', 'Helmi Perdana, ST', 'helmi.perdana@beltim.go.id', NULL, NULL, '$2y$10$GigaB8o0Xz.OpAiiR6BcC.hsLPigvEb0VpvaDhB1vaxmYh5GLKShC', 'pegawai', 1, NULL, '2026-02-11 19:49:36', '2026-02-11 19:49:36'),
	(5, '198807292020121001', 'Saman Fatriansyah, A.Md', 'saman.fatriansyah@beltim.go.id', NULL, NULL, '$2y$10$toCm66kLjVsI1V/TRVWg5O8/UgRoraQZHeWQszFXdGTf.tgGU67Hu', 'pegawai', 1, NULL, '2026-02-11 19:50:58', '2026-02-11 19:50:58'),
	(6, '198803032020121001', 'Febriyan Adipatra, A.Md', 'febriyan.adipatra@beltim.go.id', NULL, NULL, '$2y$10$fcAtu0LfglaGgZRuaqn/UeWHeoOOQFCJjWx7cA63.q9xLUlN.RyHG', 'pegawai', 1, NULL, '2026-02-11 19:52:05', '2026-02-13 20:16:24'),
	(7, '198608122023211021', 'Benny Gunawan, A.Md', 'benny.gunawan@beltim.go.id', NULL, NULL, '$2y$10$rDXK4K7GoQRGu2M/lQDvKerES3zwX/PTcS20LcKoEl9FfnQbnSiyi', 'pegawai', 1, NULL, '2026-02-11 19:53:02', '2026-02-11 19:53:02'),
	(8, '199604292020121001', 'Muhammad Ardhiansyah, A.Md.', 'muhammad.ardhiansyah@beltim.go.id', NULL, NULL, '$2y$10$aj4um6K/LHHrG6cdsQbAjuu0.4oNWC52XOrWDKbpFcNJIys5jA7r.', 'pegawai', 1, NULL, '2026-02-13 20:21:47', '2026-02-13 20:21:47'),
	(9, '198805252025211032', 'Adi Guna Darmadi, S.Si', 'adi.guna@beltim.go.id', NULL, NULL, '$2y$10$TwG91wdwpAtQ3308sF2/FurXTLNzL459/jDcIlMEi.y2sBuXjpvf6', 'pegawai', 1, NULL, '2026-02-13 20:24:53', '2026-02-13 20:24:53');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
