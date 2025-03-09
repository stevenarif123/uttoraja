-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 04:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datamahasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `prodi_admisi`
--

CREATE TABLE `prodi_admisi` (
  `id_prodi` int(11) NOT NULL,
  `kode_program_studi` varchar(255) DEFAULT NULL,
  `nama_program_studi` varchar(255) DEFAULT NULL,
  `nama_fakultas` varchar(255) DEFAULT NULL,
  `status_pikma` int(11) DEFAULT NULL,
  `minimum_pengalaman_mengajar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi_admisi`
--

INSERT INTO `prodi_admisi` (`id_prodi`, `kode_program_studi`, `nama_program_studi`, `nama_fakultas`, `status_pikma`, `minimum_pengalaman_mengajar`) VALUES
(26, '118', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(31, '122', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(36, '163', 'Teknologi Pendidikan (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 0),
(44, '252', 'Sistem Informasi (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(47, '279', 'Perencanaan Wilayah dan Kota (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(51, '310', 'Ilmu Perpustakaan (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(52, '311', 'Ilmu Hukum (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(69, '458', 'Ekonomi Syariah (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(72, '471', 'Pariwisata (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(74, '483', 'Akuntansi Keuangan Publik (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(76, '50', 'Ilmu Administrasi Negara (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(78, '51', 'Ilmu Administrasi Bisnis (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(80, '53', 'Ekonomi Pembangunan (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(81, '54', 'Manajemen (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(82, '55', 'Matematika (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(83, '56', 'Statistika (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(84, '57', 'Pendidikan Bahasa dan Sastra Indonesia (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(86, '58', 'Pendidikan Bahasa Inggris (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(91, '59', 'Pendidikan Biologi (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(102, '60', 'Pendidikan Fisika (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(104, '61', 'Pendidikan Kimia (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(105, '62', 'Pendidikan Matematika (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(113, '70', 'Sosiologi (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(114, '71', 'Ilmu Pemerintahan (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(115, '72', 'Ilmu Komunikasi (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(116, '73', 'Pendidikan Pancasila dan Kewarganegaraan (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(117, '74', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Pertanian (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(118, '75', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Peternakan (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(119, '76', 'Pendidikan Ekonomi (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(120, '77', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Perikanan (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(121, '78', 'Biologi (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(125, '83', 'Akuntansi (S1)', 'Fakultas Ekonomi dan Bisnis', 0, 0),
(126, '84', 'Teknologi Pangan (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(129, '87', 'Sastra Inggris Bidang Minat Penerjemahan (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(158, '151', 'PENDIDIKAN AGAMA ISLAM (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(159, '312', 'Perpajakan (S1)', 'Fakultas Hukum, Ilmu Sosial dan Ilmu Politik', 0, 0),
(161, '253', 'Sains Data (S1)', 'Fakultas Sains dan Teknologi', 0, 0),
(164, '11A', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1),
(165, '12A', 'Pendidikan Guru Anak Usia Dini Masukan Guru Prajabatan (Pre Srevice) (S1)', 'Fakultas Keguruan dan Ilmu Pendidikan', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prodi_admisi`
--
ALTER TABLE `prodi_admisi`
  ADD PRIMARY KEY (`id_prodi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
