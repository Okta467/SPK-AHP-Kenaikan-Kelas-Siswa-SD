-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 09:47 PM
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
(2, 2, 'A2', '2024-06-10 18:47:43', '2024-06-10 18:51:04'),
(3, 1, 'A1', '2024-06-10 18:51:17', NULL);

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
(4, 5, 9, 9, 4, '199204202015031006', 'Della Rizky Andini', 'l', 'Plaju', 'Palembang', '2024-05-06', 2014, '2024-05-25 17:52:18', '2024-06-10 19:04:23'),
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
(1, 1, 'K1', 'Kehadiran', '1', '2024-06-09 09:41:36', '2024-06-10 19:26:17'),
(2, 2, 'K2', 'Harian', '1', '2024-06-09 09:41:36', '2024-06-10 19:26:20'),
(3, 3, 'K3', 'Tugas', '1', '2024-06-09 09:41:36', '2024-06-10 19:26:26'),
(4, 4, 'K4', 'UAS', '1', '2024-06-09 09:41:36', '2024-06-10 19:26:34');

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
(12, 1, NULL, '196506121990022003', '$2y$10$2sh7PaSKyWz6lNjKHKGyrugwv9trVbvNKA62PcHel6dhrTPhrOdQm', 'kepala_sekolah', '2024-06-10 17:32:47', NULL),
(13, NULL, 1, '9991814928', '$2y$10$wwsMqfqamE.svhDczRjODe2TL7F6JCkGcqqqF3z41tkRnec.ZNxgu', 'siswa', '2024-06-10 17:33:41', NULL),
(14, 8, NULL, '9999999999888777', '$2y$10$V18sgx5Mq5OrMOTiDgDLIe5onbpmJAj4pgoweH7pECFYFu1C5wtEG', 'guru', '2024-06-10 18:02:34', NULL),
(15, NULL, 1, '9991814922', '$2y$10$ClQuypSr8X61xoizKS30j.j0tNcNWzoxTUWBoK.CON4/qVmOivb/.', 'siswa', '2024-06-10 18:47:43', NULL),
(16, 9, NULL, '1979762520140320', '$2y$10$YhnTQHIAlfmjcGfv5699HucG0MJbxCcVlxe4TiiG.bTRJx/cUv2HK', 'guru', '2024-06-10 19:01:29', NULL),
(17, 10, NULL, '1989986520190220', '$2y$10$d5eWa4HmvK94JsHmzRSaauCx2fcq9DWpXATeb0DCm5cBGRsU1d2IO', 'guru', '2024-06-10 19:02:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian_alternatif`
--

CREATE TABLE `tbl_penilaian_alternatif` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_alternatif` int(10) UNSIGNED DEFAULT NULL,
  `id_kriteria` int(10) UNSIGNED DEFAULT NULL,
  `id_tahun_akademik` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 11, '9991814928', 'Okta Alfiansyah', 'l', 'Kertapati', 'Palembang', '1999-10-10', '87799055070', 'oktaalfiansyah@gmail.com', '2024-06-10 16:24:05', NULL),
(2, 12, '9991814922', 'Bima Satria', 'l', 'Gg. Duren', 'Palembang', '2024-05-27', '87700111100', 'bimasatria@gmail.com', '2024-06-10 18:47:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_kriteria`
--

CREATE TABLE `tbl_sub_kriteria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kriteria` int(10) UNSIGNED DEFAULT NULL,
  `kode_sub_kriteria` varchar(16) NOT NULL,
  `nama_sub_kriteria` varchar(64) NOT NULL,
  `bobot` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sub_kriteria`
--

INSERT INTO `tbl_sub_kriteria` (`id`, `id_kriteria`, `kode_sub_kriteria`, `nama_sub_kriteria`, `bobot`, `created_at`, `updated_at`) VALUES
(1, 1, 'K1S1', 'Kehadiran 1', '1.00', '2024-06-10 19:45:24', NULL),
(2, 1, 'K1S2', 'Kehadiran 2', '2.00', '2024-06-10 19:45:24', NULL),
(3, 1, 'K1S3', 'Kehadiran 3', '3.00', '2024-06-10 19:45:24', NULL),
(4, 1, 'K1S4', 'Kehadiran 4', '4.00', '2024-06-10 19:45:24', NULL),
(5, 2, 'K2S1', 'Harian 1', '1.00', '2024-06-10 19:45:24', NULL),
(6, 2, 'K2S2', 'Harian 2', '2.00', '2024-06-10 19:45:24', NULL),
(7, 2, 'K2S3', 'Harian 3', '3.00', '2024-06-10 19:45:24', NULL),
(8, 2, 'K2S4', 'Harian 4', '4.00', '2024-06-10 19:45:24', NULL),
(9, 3, 'K3S1', 'Tugas 1', '1.00', '2024-06-10 19:45:24', NULL),
(10, 3, 'K3S2', 'Tugas 2', '2.00', '2024-06-10 19:45:24', NULL),
(11, 3, 'K3S3', 'Tugas 3', '3.00', '2024-06-10 19:45:24', NULL),
(12, 3, 'K3S4', 'Tugas 4', '4.00', '2024-06-10 19:45:24', NULL),
(13, 4, 'K4S1', 'UAS 1', '1.00', '2024-06-10 19:45:24', NULL),
(14, 4, 'K4S2', 'UAS 2', '2.00', '2024-06-10 19:45:24', NULL),
(15, 4, 'K4S3', 'UAS 3', '3.00', '2024-06-10 19:45:24', NULL),
(16, 4, 'K4S4', 'UAS 4', '4.00', '2024-06-10 19:45:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tahun_akademik`
--

CREATE TABLE `tbl_tahun_akademik` (
  `id` int(10) UNSIGNED NOT NULL,
  `tahun_akademik` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tahun_akademik`
--

INSERT INTO `tbl_tahun_akademik` (`id`, `tahun_akademik`, `created_at`, `updated_at`) VALUES
(1, '2021/2022', '2024-05-28 05:11:49', '2024-05-28 05:19:26'),
(2, '2022/2023', '2024-05-28 04:52:33', '2024-05-28 05:19:23'),
(3, '2023/2024', '2024-05-28 04:54:00', '2024-05-28 05:19:29'),
(5, '2020/2021', '2024-05-28 19:50:48', NULL);

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
  ADD KEY `id_tahun_akademik` (`id_tahun_akademik`);

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
  ADD KEY `id_kriteria` (`id_kriteria`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_tahun_akademik`
--
ALTER TABLE `tbl_tahun_akademik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_3` FOREIGN KEY (`id_tahun_akademik`) REFERENCES `tbl_tahun_akademik` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  ADD CONSTRAINT `tbl_sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `tbl_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
