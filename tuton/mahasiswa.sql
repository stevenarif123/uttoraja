-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Mar 2025 pada 15.19
-- Versi server: 10.6.19-MariaDB-cll-lve
-- Versi PHP: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saluttan_datamahasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `No` int(11) NOT NULL,
  `JalurProgram` enum('RPL','Reguler') NOT NULL,
  `ID` varchar(8) NOT NULL,
  `NIM` varchar(20) NOT NULL,
  `NamaLengkap` varchar(100) NOT NULL,
  `TempatLahir` varchar(50) DEFAULT NULL,
  `TanggalLahir` date DEFAULT NULL,
  `NamaIbuKandung` varchar(100) DEFAULT NULL,
  `NIK` varchar(16) DEFAULT NULL,
  `Jurusan` varchar(255) DEFAULT NULL,
  `NomorHP` varchar(15) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(20) NOT NULL,
  `Agama` varchar(20) NOT NULL,
  `JenisKelamin` varchar(20) NOT NULL,
  `StatusPerkawinan` varchar(20) NOT NULL,
  `NomorHPAlternatif` varchar(15) DEFAULT NULL,
  `NomorIjazah` varchar(20) DEFAULT NULL,
  `TahunIjazah` year(4) DEFAULT NULL,
  `NISN` varchar(10) DEFAULT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `LayananPaketSemester` varchar(20) NOT NULL,
  `DiInputOleh` varchar(50) DEFAULT NULL,
  `DiInputPada` datetime DEFAULT current_timestamp(),
  `DiEditPada` datetime NOT NULL DEFAULT current_timestamp(),
  `STATUS_INPUT_SIA` varchar(50) NOT NULL,
  `UkuranBaju` varchar(3) NOT NULL,
  `AsalKampus` varchar(225) DEFAULT NULL,
  `TahunLulusKampus` int(255) DEFAULT NULL,
  `IPK` varchar(11) DEFAULT NULL,
  `JurusanSMK` int(11) DEFAULT NULL,
  `JenisSekolah` varchar(255) DEFAULT NULL,
  `NamaSekolah` varchar(255) DEFAULT NULL,
  `Masa` varchar(10) NOT NULL DEFAULT '20242'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`No`),
  ADD UNIQUE KEY `ID_UNIQUE` (`ID`),
  ADD UNIQUE KEY `NIM` (`NIM`),
  ADD UNIQUE KEY `NIK_UNIQUE` (`NIK`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2657;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
