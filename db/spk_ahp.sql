-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2024 at 03:17 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_ahp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alternatif`
--

CREATE TABLE `tbl_alternatif` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_siswa` int(1) UNSIGNED DEFAULT NULL,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_alternatif`
--

INSERT INTO `tbl_alternatif` (`id`, `id_siswa`, `kode_alternatif`, `created_at`, `updated_at`) VALUES
(3, 1, 'A1', '2024-06-10 18:51:17', NULL),
(5, 3, 'A2', '2024-06-12 13:57:15', NULL),
(6, 4, 'A4', '2024-06-12 13:58:28', NULL),
(8, 5, 'A3', '2024-06-13 20:45:51', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_jabatan` int(10) UNSIGNED DEFAULT NULL,
  `id_pangkat_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `id_jurusan_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tahun_ijazah` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id`, `id_jabatan`, `id_pangkat_golongan`, `id_pendidikan`, `id_jurusan_pendidikan`, `nip`, `nama_guru`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `tahun_ijazah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 9, 4, '196506121990022003', 'Sukarti', 'p', 'Palembang', 'Palembang', '2024-05-01', 2009, '2024-05-23 08:29:39', '2024-06-10 19:02:52'),
(4, 5, 9, 9, 4, '199204202015031006', 'Della Rizky Andini', 'l', 'Plaju', 'Palembang', '2024-05-06', 2014, '2024-05-25 17:52:18', '2024-06-16 22:01:41'),
(5, 5, 9, 9, 4, '198912252019022005', 'Sudaryani', 'p', 'Plaju', 'Prabumulih', '2020-04-30', 2011, '2024-05-25 17:53:27', '2024-06-10 19:03:32'),
(6, 5, 9, 9, 4, '1988103020201901', 'Sulastinah', 'p', 'Plaju', 'Prabumulih', '2024-05-05', 2010, '2024-05-26 09:59:45', '2024-06-10 19:04:01'),
(7, 4, 5, 10, 37, '1234567890123456', 'Abdul Kadir, M.Kom.', 'l', 'Depok', 'Depok', '2024-04-30', 2010, '2024-06-10 15:46:11', '2024-06-10 15:57:06'),
(8, 5, 5, 9, 33, '9999999999888777', 'Nur Widyasti', 'p', 'Palembang', 'Palembang', '2024-03-31', 2010, '2024-06-10 18:02:33', NULL),
(9, 5, 4, 9, 34, '1979762520140320', 'Susmayasari', 'p', 'Palembang', 'Palembang', '2024-05-26', 2014, '2024-06-10 19:01:29', NULL),
(10, 5, 4, 9, 33, '1989986520190220', 'Nunsianah', 'p', 'Plaju', 'Palembang', '2024-05-26', 2010, '2024-06-10 19:02:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(2, 'Wakil Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(3, 'Bendahara', '2024-05-20 12:45:34', NULL),
(4, 'Tata Usaha/Administrasi', '2024-05-20 12:45:34', NULL),
(5, 'Wali Kelas', '2024-05-20 12:45:34', NULL),
(6, 'Piket', '2024-05-20 12:45:34', NULL),
(7, 'Bimbingan Konseling', '2024-05-20 12:45:34', NULL),
(8, 'Penjaga Sekolah', '2024-05-20 12:45:34', NULL),
(9, 'Kebersihan', '2024-05-20 12:45:34', '2024-05-20 12:53:45'),
(10, 'Tenaga Administrasi Sekolah', '2024-05-20 12:45:34', NULL),
(11, 'Perpustakaan', '2024-05-20 12:45:34', NULL),
(12, 'Operator', '2024-05-20 12:45:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan_pendidikan`
--

CREATE TABLE `tbl_jurusan_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nama_jurusan` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jurusan_pendidikan`
--

INSERT INTO `tbl_jurusan_pendidikan` (`id`, `id_pendidikan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tidak Ada', '2024-05-11 19:22:50', NULL),
(2, 4, 'IPA', '2024-05-11 19:22:50', '2024-05-13 14:09:23'),
(3, 4, 'IPS', '2024-05-11 19:22:50', '2024-05-13 14:09:34'),
(4, 9, 'Sistem Informasi', '2024-05-11 19:22:50', '2024-05-13 14:09:58'),
(5, 9, 'Psikologi', '2024-05-11 19:22:50', '2024-05-13 14:10:04'),
(8, 4, 'Lainnya', '2024-05-13 14:13:00', NULL),
(9, 5, 'Lainnya', '2024-05-13 14:13:01', NULL),
(10, 6, 'Lainnya', '2024-05-13 14:13:01', NULL),
(11, 7, 'Lainnya', '2024-05-13 14:13:01', NULL),
(12, 8, 'Lainnya', '2024-05-13 14:13:01', NULL),
(13, 9, 'Lainnya', '2024-05-13 14:13:01', NULL),
(14, 10, 'Lainnya', '2024-05-13 14:13:01', NULL),
(15, 11, 'Lainnya', '2024-05-13 14:13:01', NULL),
(16, 9, 'Teknik Elektro', '2024-05-13 16:37:09', NULL),
(28, 8, 'Some \\&quot;\'  string &amp;amp; to Sanitize &amp;lt; !$@%', '2024-05-13 18:05:45', '2024-05-13 18:12:16'),
(29, 9, 'Pendidikan Agama Islam', '2024-05-17 05:11:41', NULL),
(30, 9, 'Hukum', '2024-05-19 18:35:55', NULL),
(32, 9, 'Psikologi', '2024-05-23 04:32:24', NULL),
(33, 9, 'Bahasa Indonesia', '2024-05-23 10:55:19', NULL),
(34, 9, 'Fisika', '2024-05-23 16:27:45', NULL),
(35, 9, 'Matematika', '2024-05-25 17:35:34', NULL),
(36, 9, 'Geografi', '2024-05-26 09:59:36', NULL),
(37, 10, 'Sistem Informasi', '2024-06-10 15:56:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_wali_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nama_kelas` varchar(8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id`, `id_wali_kelas`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, 8, '1A', '2024-06-10 14:31:14', '2024-06-10 18:41:14'),
(2, 4, '1B', '2024-06-10 14:31:14', NULL),
(3, 4, '1C', '2024-06-10 14:31:14', NULL),
(4, 4, '1D', '2024-06-10 14:31:14', NULL),
(5, 9, '2A', '2024-06-10 14:31:14', '2024-06-10 19:05:42'),
(6, 4, '2B', '2024-06-10 14:31:14', NULL),
(7, 4, '2C', '2024-06-10 14:31:14', NULL),
(8, 4, '2D', '2024-06-10 14:31:14', NULL),
(9, 1, '3A', '2024-06-10 14:31:14', '2024-06-10 19:05:28'),
(10, 4, '3B', '2024-06-10 14:31:14', NULL),
(11, 4, '3C', '2024-06-10 14:31:14', NULL),
(12, 4, '3D', '2024-06-10 14:31:14', NULL),
(13, 4, '4A', '2024-06-10 14:31:14', NULL),
(14, 4, '4B', '2024-06-10 14:31:14', NULL),
(15, 4, '4C', '2024-06-10 14:31:14', NULL),
(16, 4, '4D', '2024-06-10 14:31:14', NULL),
(17, 5, '5A', '2024-06-10 14:31:14', '2024-06-10 19:05:15'),
(18, 4, '5B', '2024-06-10 14:31:14', NULL),
(19, 4, '5C', '2024-06-10 14:31:14', NULL),
(20, 4, '5D', '2024-06-10 14:31:14', NULL),
(21, 6, '6A', '2024-06-10 14:31:14', '2024-06-10 19:05:04'),
(22, 4, '6B', '2024-06-10 14:31:14', NULL),
(23, 4, '6C', '2024-06-10 14:31:14', NULL),
(24, 4, '6D', '2024-06-10 14:31:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

CREATE TABLE `tbl_kriteria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_tingkat_kepentingan` int(10) UNSIGNED DEFAULT NULL,
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(64) NOT NULL,
  `status_aktif` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kriteria`
--

INSERT INTO `tbl_kriteria` (`id`, `id_tingkat_kepentingan`, `kode_kriteria`, `nama_kriteria`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'K1', 'Kehadiran', '1', '2024-06-09 09:41:36', '2024-06-12 11:03:03'),
(2, 2, 'K2', 'Tugas', '1', '2024-06-09 09:41:36', '2024-06-15 17:25:22'),
(3, 3, 'K3', 'MID', '1', '2024-06-09 09:41:36', '2024-06-15 17:25:29'),
(4, 4, 'K4', 'UAS', '1', '2024-06-09 09:41:36', '2024-06-15 22:24:18'),
(5, 1, 'K5', 'Perilaku', '1', '2024-06-15 17:25:43', '2024-06-16 23:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pangkat_golongan`
--

CREATE TABLE `tbl_pangkat_golongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pangkat_golongan` varchar(128) NOT NULL,
  `tipe` enum('pns','pppk','gtt','honor') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pangkat_golongan`
--

INSERT INTO `tbl_pangkat_golongan` (`id`, `nama_pangkat_golongan`, `tipe`, `created_at`, `updated_at`) VALUES
(1, 'Golongan Ia (Juru Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(2, 'Golongan Ib (Juru Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(3, 'Golongan Ic (Juru)', 'pns', '2024-05-15 17:21:54', NULL),
(4, 'Golongan Id (Juru Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(5, 'Golongan IIa (Pengatur muda)', 'pns', '2024-05-15 17:21:54', NULL),
(6, 'Golongan IIb (Pengatur Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(7, 'Golongan IIc (Pengatur)', 'pns', '2024-05-15 17:21:54', NULL),
(8, 'Golongan IId (Pengatur tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(9, 'Golongan IIIa (Penata Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(10, 'Golongan IIIb (Penata Muda Tingkat 1)', 'pns', '2024-05-15 17:21:54', NULL),
(11, 'Golongan IIIc (Penata)', 'pns', '2024-05-15 17:21:54', NULL),
(12, 'Golongan IIId (Penata Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(13, 'Golongan IVa (Pembina)', 'pns', '2024-05-15 17:21:54', NULL),
(14, 'Golongan IVb (Pembina Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(15, 'Golongan IVc (Pembina Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(16, 'Golongan IVd (Pembina Madya)', 'pns', '2024-05-15 17:21:54', NULL),
(17, 'Golongan IVe (Pembina Utama)', 'pns', '2024-05-15 17:21:54', NULL),
(18, 'Tidak ada', NULL, '2024-05-15 18:23:14', '2024-05-20 11:50:30'),
(19, 'PPPK', 'pppk', '2024-05-20 11:36:07', NULL),
(20, 'GTT', 'gtt', '2024-05-20 11:36:07', NULL),
(21, 'Honor', 'honor', '2024-05-20 11:49:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendidikan`
--

CREATE TABLE `tbl_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pendidikan`
--

INSERT INTO `tbl_pendidikan` (`id`, `nama_pendidikan`, `created_at`, `updated_at`) VALUES
(1, 'tidak_sekolah', '2024-05-11 19:21:02', '2024-05-13 16:25:34'),
(2, 'SD', '2024-05-11 19:21:03', NULL),
(3, 'SMP', '2024-05-11 19:21:03', NULL),
(4, 'SLTA', '2024-05-11 19:21:03', NULL),
(5, 'DI', '2024-05-11 19:21:03', NULL),
(6, 'DII', '2024-05-11 19:21:03', NULL),
(7, 'DIII', '2024-05-11 19:21:03', NULL),
(8, 'DIV', '2024-05-11 19:21:03', NULL),
(9, 'S1', '2024-05-11 19:21:03', NULL),
(10, 'S2', '2024-05-11 19:21:03', NULL),
(11, 'S3', '2024-05-11 19:21:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_guru` int(10) UNSIGNED DEFAULT NULL,
  `id_siswa` int(10) UNSIGNED DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` enum('admin','guru','kepala_sekolah','siswa') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `id_guru`, `id_siswa`, `username`, `password`, `hak_akses`, `created_at`, `last_login`) VALUES
(9, NULL, NULL, 'admin', '$2y$10$VSwsaud3aHkzE3VzMfuGCO9YizH7A7wVnx7Xfi9kUDiJdhDY53Msy', 'admin', '2024-06-10 14:42:24', NULL),
(10, 7, NULL, '1234567890123456', '$2y$10$BMpVZgOC.9kO5ep4qg1NgueD88nDbYogdY.gbL54KpgvDc77F8nH.', 'guru', '2024-06-10 15:46:11', NULL),
(12, 1, NULL, '196506121990022003', '$2y$10$yl3YmNGYbvKdPqFUXQxT..GSeCl03bwEdmDzJnJDS9q6utP2tab6q', 'kepala_sekolah', '2024-06-10 17:32:47', NULL),
(13, NULL, 1, '9991814928', '$2y$10$wwsMqfqamE.svhDczRjODe2TL7F6JCkGcqqqF3z41tkRnec.ZNxgu', 'siswa', '2024-06-10 17:33:41', NULL),
(14, 8, NULL, '9999999999888777', '$2y$10$V18sgx5Mq5OrMOTiDgDLIe5onbpmJAj4pgoweH7pECFYFu1C5wtEG', 'guru', '2024-06-10 18:02:34', NULL),
(15, NULL, 1, '9991814922', '$2y$10$ClQuypSr8X61xoizKS30j.j0tNcNWzoxTUWBoK.CON4/qVmOivb/.', 'siswa', '2024-06-10 18:47:43', NULL),
(16, 9, NULL, '1979762520140320', '$2y$10$YhnTQHIAlfmjcGfv5699HucG0MJbxCcVlxe4TiiG.bTRJx/cUv2HK', 'guru', '2024-06-10 19:01:29', NULL),
(17, 10, NULL, '1989986520190220', '$2y$10$d5eWa4HmvK94JsHmzRSaauCx2fcq9DWpXATeb0DCm5cBGRsU1d2IO', 'guru', '2024-06-10 19:02:12', NULL),
(18, NULL, 4, '9997672534', '$2y$10$oHJak4.D3fPmZTsZ0i86q.VpKi5PmiWq9saU7ZFLtW/YIJtbq1JNK', 'siswa', '2024-06-12 13:58:28', NULL),
(19, NULL, 5, '9987652345', '$2y$10$UMklf7moNVGQZ5E2k.tatuzY9EVSk3LOm7X/eAcJMlY6dHlwcIE16', 'siswa', '2024-06-12 14:04:46', NULL),
(20, 4, NULL, '199204202015031006', '$2y$10$lMt73oa3tCKiKE2fB4QGo.bvH05apTgp9BbVDmz03/vLId6CJ5UQK', 'guru', '2024-06-16 21:18:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian_alternatif`
--

CREATE TABLE `tbl_penilaian_alternatif` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_alternatif` int(10) UNSIGNED DEFAULT NULL,
  `id_kriteria` int(10) UNSIGNED DEFAULT NULL,
  `id_sub_kriteria` int(10) UNSIGNED DEFAULT NULL,
  `id_tahun_akademik` int(10) UNSIGNED DEFAULT NULL,
  `nilai_siswa` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_penilaian_alternatif`
--

INSERT INTO `tbl_penilaian_alternatif` (`id`, `id_alternatif`, `id_kriteria`, `id_sub_kriteria`, `id_tahun_akademik`, `nilai_siswa`, `created_at`, `updated_at`) VALUES
(41, 5, 1, 4, 3, '90.00', '2024-06-15 20:21:07', NULL),
(42, 5, 2, 4, 3, '80.00', '2024-06-15 20:21:07', NULL),
(43, 5, 3, 4, 3, '85.00', '2024-06-15 20:21:07', NULL),
(44, 5, 4, 3, 3, '75.00', '2024-06-15 20:21:07', NULL),
(45, 5, 5, 4, 3, '88.00', '2024-06-15 20:21:07', NULL),
(46, 3, 1, 3, 3, '75.00', '2024-06-15 20:21:37', NULL),
(47, 3, 2, 4, 3, '85.00', '2024-06-15 20:21:37', NULL),
(48, 3, 3, 5, 3, '96.00', '2024-06-15 20:21:37', NULL),
(49, 3, 4, 4, 3, '87.00', '2024-06-15 20:21:37', NULL),
(50, 3, 5, 4, 3, '90.00', '2024-06-15 20:21:37', NULL),
(56, 3, 1, 5, 2, '99.99', '2024-06-15 23:49:20', NULL),
(57, 3, 2, 4, 2, '80.00', '2024-06-15 23:49:20', NULL),
(58, 3, 3, 4, 2, '85.00', '2024-06-15 23:49:20', NULL),
(59, 3, 4, 4, 2, '85.00', '2024-06-15 23:49:21', NULL),
(65, 6, 1, 3, 3, '67.00', '2024-06-16 20:44:40', NULL),
(66, 6, 2, 3, 3, '65.00', '2024-06-16 20:44:40', NULL),
(67, 6, 3, 3, 3, '68.00', '2024-06-16 20:44:40', NULL),
(68, 6, 4, 3, 3, '69.00', '2024-06-16 20:44:40', NULL),
(69, 6, 5, 3, 3, '65.00', '2024-06-16 20:44:40', NULL),
(70, 8, 1, 4, 3, '80.00', '2024-06-16 22:43:57', NULL),
(71, 8, 2, 3, 3, '75.00', '2024-06-16 22:43:57', NULL),
(72, 8, 3, 4, 3, '90.00', '2024-06-16 22:43:57', NULL),
(73, 8, 4, 4, 3, '85.00', '2024-06-16 22:43:57', NULL),
(74, 8, 5, 4, 3, '88.00', '2024-06-16 22:43:57', NULL),
(75, 8, 1, 3, 2, '77.00', '2024-06-17 01:00:07', NULL),
(76, 8, 2, 4, 2, '89.00', '2024-06-17 01:00:07', NULL),
(77, 8, 3, 2, 2, '56.00', '2024-06-17 01:00:07', NULL),
(78, 8, 4, 1, 2, '23.00', '2024-06-17 01:00:07', NULL),
(79, 6, 1, 5, 2, '99.00', '2024-06-17 01:07:02', NULL),
(80, 6, 2, 2, 2, '52.00', '2024-06-17 01:07:02', NULL),
(81, 6, 3, 2, 2, '56.00', '2024-06-17 01:07:02', NULL),
(82, 6, 4, 3, 2, '67.00', '2024-06-17 01:07:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_range_nilai`
--

CREATE TABLE `tbl_range_nilai` (
  `id` int(10) UNSIGNED NOT NULL,
  `batas_bawah` decimal(5,2) NOT NULL,
  `batas_atas` decimal(5,2) NOT NULL,
  `range_nilai` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_range_nilai`
--

INSERT INTO `tbl_range_nilai` (`id`, `batas_bawah`, `batas_atas`, `range_nilai`, `created_at`, `updated_at`) VALUES
(1, '0.00', '30.00', '1.00', '2024-06-15 11:04:39', '2024-06-15 17:11:59'),
(2, '31.00', '59.00', '2.00', '2024-06-15 11:04:39', '2024-06-15 17:12:02'),
(3, '60.00', '79.00', '3.00', '2024-06-15 11:04:39', '2024-06-15 17:12:04'),
(4, '80.00', '90.00', '4.00', '2024-06-15 11:04:39', '2024-06-15 17:12:05'),
(5, '91.00', '100.00', '5.00', '2024-06-15 11:04:39', '2024-06-15 17:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama_siswa` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telp` varchar(16) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id`, `id_kelas`, `nisn`, `nama_siswa`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `no_telp`, `email`, `created_at`, `updated_at`) VALUES
(1, 11, '9991814928', 'Okta Alfiansyah', 'l', 'Kertapati', 'Palembang', '1999-10-10', '087799055070', 'oktaalfiansyah@gmail.com', '2024-06-16 22:13:58', '2024-06-16 22:13:58'),
(3, 11, '9991814872', 'Bima Satria', 'l', 'Gang Duren', 'Palembang', '2024-05-08', '087765432345', 'bimasatria@gmail.com', '2024-06-12 12:52:49', '2024-06-12 12:52:49'),
(4, 11, '9997672534', 'Arief Rahman', 'l', 'Jakabaring', 'Palembang', '2024-05-27', '087700111100', 'ariefrahman@gmail.com', '2024-06-12 13:58:28', NULL),
(5, 11, '9987652345', 'Benny Setiawan', 'l', 'Palembang', 'Palembang', '1998-05-01', '081992001969', 'bennysetiawan@gmail.com', '2024-06-12 14:04:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_kriteria`
--

CREATE TABLE `tbl_sub_kriteria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kriteria` int(10) UNSIGNED DEFAULT NULL,
  `id_range_nilai` int(10) UNSIGNED DEFAULT NULL,
  `kode_sub_kriteria` varchar(16) NOT NULL,
  `nama_sub_kriteria` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sub_kriteria`
--

INSERT INTO `tbl_sub_kriteria` (`id`, `id_kriteria`, `id_range_nilai`, `kode_sub_kriteria`, `nama_sub_kriteria`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'K1S1', '1', '2024-06-13 18:26:01', '2024-06-15 17:05:23'),
(2, 1, 2, 'K1S2', '2', '2024-06-13 18:26:01', '2024-06-15 17:05:49'),
(3, 1, 3, 'K1S3', '3', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(4, 1, 4, 'K1S4', '4', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(5, 1, 5, 'K1S5', '5', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(6, 2, 1, 'K2S1', '1', '2024-06-13 18:26:01', '2024-06-15 17:05:23'),
(7, 2, 2, 'K2S2', '2', '2024-06-13 18:26:01', '2024-06-15 17:05:49'),
(8, 2, 3, 'K2S3', '3', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(9, 2, 4, 'K2S4', '4', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(10, 2, 5, 'K2S5', '5', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(11, 3, 1, 'K3S1', '1', '2024-06-13 18:26:01', '2024-06-15 17:05:23'),
(12, 3, 2, 'K3S2', '2', '2024-06-13 18:26:01', '2024-06-15 17:05:49'),
(13, 3, 3, 'K3S3', '3', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(14, 3, 4, 'K3S4', '4', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(15, 3, 5, 'K3S5', '5', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(16, 4, 1, 'K4S1', '1', '2024-06-13 18:26:01', '2024-06-15 17:05:23'),
(17, 4, 2, 'K4S2', '2', '2024-06-13 18:26:01', '2024-06-15 17:05:49'),
(18, 4, 3, 'K4S3', '3', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(19, 4, 4, 'K4S4', '4', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(20, 4, 5, 'K4S5', '5', '2024-06-13 18:26:01', '2024-06-15 17:06:59'),
(26, 5, 1, 'K5S1', '1', '2024-06-15 17:29:23', NULL),
(27, 5, 2, 'K5S2', '2', '2024-06-15 17:29:23', NULL),
(28, 5, 3, 'K5S3', '3', '2024-06-15 17:29:23', NULL),
(29, 5, 4, 'K5S4', '4', '2024-06-15 17:29:23', NULL),
(30, 5, 5, 'K5S5', '5', '2024-06-15 17:29:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tahun_akademik`
--

CREATE TABLE `tbl_tahun_akademik` (
  `id` int(10) UNSIGNED NOT NULL,
  `dari_tahun` year(4) NOT NULL,
  `sampai_tahun` year(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tahun_akademik`
--

INSERT INTO `tbl_tahun_akademik` (`id`, `dari_tahun`, `sampai_tahun`, `created_at`, `updated_at`) VALUES
(1, 2021, 2022, '2024-05-28 05:11:49', '2024-06-13 15:21:31'),
(2, 2022, 2023, '2024-05-28 04:52:33', '2024-06-13 15:21:28'),
(3, 2023, 2024, '2024-05-28 04:54:00', '2024-06-13 15:21:23'),
(5, 2020, 2021, '2024-05-28 19:50:48', '2024-06-13 15:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tingkat_kepentingan`
--

CREATE TABLE `tbl_tingkat_kepentingan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nilai_kepentingan` enum('1','3','5','7','9') NOT NULL,
  `keterangan` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tingkat_kepentingan`
--

INSERT INTO `tbl_tingkat_kepentingan` (`id`, `nilai_kepentingan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '1', 'Sama Penting', '2024-06-09 09:00:48', NULL),
(2, '3', 'Cukup Penting (1 Level lebih penting dibandingkan kriteria lainn', '2024-06-09 09:00:48', '2024-06-09 09:01:14'),
(3, '5', 'Lebih Penting (2 Level lebih penting dibandingkan kriteria lainn', '2024-06-09 09:00:48', '2024-06-09 09:01:19'),
(4, '7', 'Sangat Penting (3 Level lebih penting dibandingkan kriteria lain', '2024-06-09 09:00:48', '2024-06-09 09:01:24'),
(5, '9', 'Mutlak Lebih Penting (4 Level lebih penting dibandingkan kriteri', '2024-06-09 09:00:48', '2024-06-09 09:01:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_alternatif` (`kode_alternatif`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_jurusan_pendidikan` (`id_jurusan_pendidikan`),
  ADD KEY `id_pangkat_golongan` (`id_pangkat_golongan`),
  ADD KEY `id_pendidikan` (`id_pendidikan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendidikan` (`id_pendidikan`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wali_kelas` (`id_wali_kelas`);

--
-- Indexes for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kriteria` (`kode_kriteria`),
  ADD KEY `id_tingkat_kepentingan` (`id_tingkat_kepentingan`);

--
-- Indexes for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `tbl_pengguna_ibfk_1` (`id_guru`),
  ADD KEY `id_pegawai` (`id_siswa`);

--
-- Indexes for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_tahun_akademik` (`id_tahun_akademik`),
  ADD KEY `id_sub_kriteria` (`id_sub_kriteria`);

--
-- Indexes for table `tbl_range_nilai`
--
ALTER TABLE `tbl_range_nilai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `range_nilai` (`range_nilai`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_sub_kriteria` (`kode_sub_kriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_range_nilai` (`id_range_nilai`);

--
-- Indexes for table `tbl_tahun_akademik`
--
ALTER TABLE `tbl_tahun_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_tingkat_kepentingan`
--
ALTER TABLE `tbl_tingkat_kepentingan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tbl_range_nilai`
--
ALTER TABLE `tbl_range_nilai`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_tahun_akademik`
--
ALTER TABLE `tbl_tahun_akademik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_tingkat_kepentingan`
--
ALTER TABLE `tbl_tingkat_kepentingan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD CONSTRAINT `tbl_alternatif_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD CONSTRAINT `tbl_guru_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_2` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_3` FOREIGN KEY (`id_jurusan_pendidikan`) REFERENCES `tbl_jurusan_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_4` FOREIGN KEY (`id_pangkat_golongan`) REFERENCES `tbl_pangkat_golongan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD CONSTRAINT `tbl_jurusan_pendidikan_ibfk_1` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD CONSTRAINT `tbl_kelas_ibfk_1` FOREIGN KEY (`id_wali_kelas`) REFERENCES `tbl_guru` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD CONSTRAINT `tbl_kriteria_ibfk_1` FOREIGN KEY (`id_tingkat_kepentingan`) REFERENCES `tbl_tingkat_kepentingan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD CONSTRAINT `tbl_pengguna_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pengguna_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `tbl_alternatif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `tbl_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_3` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `tbl_sub_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_4` FOREIGN KEY (`id_tahun_akademik`) REFERENCES `tbl_tahun_akademik` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  ADD CONSTRAINT `tbl_sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `tbl_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sub_kriteria_ibfk_2` FOREIGN KEY (`id_range_nilai`) REFERENCES `tbl_range_nilai` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
