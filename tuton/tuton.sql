-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Mar 2025 pada 09.33
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
-- Struktur dari tabel `tuton`
--

CREATE TABLE `tuton` (
  `ID` int(11) NOT NULL,
  `NIM` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Jurusan` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tuton`
--

INSERT INTO `tuton` (`ID`, `NIM`, `Nama`, `Jurusan`, `Email`, `Password`) VALUES
(1, '052484055', 'SEMARIONO', 'Manajemen (S1)', 'f.ann.y.kar.li.n.da.bn.c@gmail.com', '@11032006Ut'),
(2, '052485025', 'RHIKAL', 'Perencanaan Wilayah dan Kota (S1)', 'f.ann.y.kar.li.n.dabn.c@gmail.com', '@21032006Ut'),
(3, '052594234', 'NENY LASRI MALLISA\\\'', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.kar.l.i.nda.bn.c@gmail.com', '@25041992Ut'),
(4, '052595949', 'ZULFIKAR', 'Ilmu Hukum (S1)', 'f.ann.y.kar.l.i.nd.a.b.n.c@gmail.com', '@10102004Ut'),
(5, '052596166', 'VEBIANTI RATU ALLO', 'Manajemen (S1)', 'f.ann.y.kar.li.n.d.a.bn.c@gmail.com', '@21062003Ut'),
(6, '859183116', 'JENI BULAWAN TEMEHI', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.n.dab.nc@gmail.com', '@02071998Ut'),
(7, '054330361', 'OKTAVIANI SORE', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.ka.rlin.dabnc@gmail.com', '@08102006Ut'),
(8, '052484442', 'LUKMAN', 'Manajemen (S1)', 'f.ann.y.kar.li.n.da.b.nc@gmail.com', '@26052005Ut'),
(9, '052588556', 'ARDIANTO PALAYUKAN', 'Sistem Informasi (S1)', 'f.ann.y.kar.l.i.n.d.a.b.n.c@gmail.com', '@27082004Ut'),
(10, '052594148', 'LIRAFINA TA\\\'DUNG', 'Sistem Informasi (S1)', 'f.ann.y.kar.l.i.ndabnc@gmail.com', '@27082004Ut'),
(11, '052595766', 'FAJAR SARIKA', 'Ilmu Hukum (S1)', 'f.ann.y.kar.l.i.nda.bnc@gmail.com', '@25011995Ut'),
(12, '052595931', 'ADELINA', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.kar.l.i.n.d.ab.n.c@gmail.com', '@31122006Ut'),
(13, '052595988', 'YUNUS PAKIDING', 'Ilmu Hukum (S1)', 'f.ann.y.kar.l.in.d.ab.nc@gmail.com', '@28122002Ut'),
(14, '052595995', 'SOFI FEBRIANTI', 'Akuntansi (S1)', 'f.ann.y.kar.l.ind.a.b.n.c@gmail.com', '@23082005Ut'),
(15, '052596009', 'SONY HENDRA PALULLUNGAN', 'Manajemen (S1)', 'f.ann.y.kar.l.in.da.b.nc@gmail.com', '@24121999Ut'),
(16, '052596055', 'IMELDA NOVITA PERMATA SARI', 'Manajemen (S1)', 'f.ann.y.kar.l.inda.b.n.c@gmail.com', '@31011997Ut'),
(17, '052596087', 'JUNIATY YECHONIA PONGTASIK', 'Teknologi Pendidikan (S1)', 'f.ann.y.kar.l.i.nd.a.bnc@gmail.com', '@27061995Ut'),
(18, '052596094', 'M. KHARYANI RANDA BUNGA', 'Perpajakan (S1)', 'f.ann.y.kar.l.ind.a.b.nc@gmail.com', '@26011992Ut'),
(19, '052596141', 'GILBERTO RENO TANDIARRANG', 'Manajemen (S1)', 'f.ann.y.kar.l.ind.abnc@gmail.com', '@01062003Ut'),
(20, '052596159', 'BUSRA SUBA\\\' MAKASSA\\\'', 'Ilmu Pemerintahan (S1)', 'f.ann.y.kar.l.ind.ab.nc@gmail.com', '@19042003Ut'),
(21, '052596173', 'RUTH PATENGKO', 'Matematika (S1)', 'f.ann.y.kar.l.indabnc@gmail.com', '@10021995Ut'),
(22, '052596388', 'YULIANTI', 'Ilmu Hukum (S1)', 'f.ann.y.kar.li.n.d.ab.n.c@gmail.com', '@08052002Ut'),
(23, '052596743', 'RICE\\\' PALULUN', 'Manajemen (S1)', 'f.ann.y.kar.li.n.d.abn.c@gmail.com', '@15092004Ut'),
(24, '052596768', 'ALFRIDA TODING', 'Manajemen (S1)', 'f.ann.y.kar.li.n.d.abnc@gmail.com', '@22042006Ut'),
(25, '054070115', 'SRI EDRYENSI LIMBONG PADANG', 'Manajemen (S1)', 'f.ann.y.ka.rli.n.da.b.n.c@gmail.com', '@29092000Ut'),
(26, '054070147', 'VIRGIE NOVITA GANI', 'Akuntansi (S1)', 'f.ann.y.ka.rli.n.da.b.nc@gmail.com', '@26112005Ut'),
(27, '054070154', 'SELVIANI PADANG', 'Manajemen (S1)', 'f.ann.y.ka.rli.n.da.bn.c@gmail.com', '@28092006Ut'),
(28, '054070487', 'YESIVA AGNES PUTRI', 'Manajemen (S1)', 'f.ann.y.ka.rli.n.d.a.bnc@gmail.com', '@09082003Ut'),
(29, '054071117', 'AGUS PASANDE', 'Sistem Informasi (S1)', 'f.ann.y.ka.rl.indabnc@gmail.com', '@26081996Ut'),
(30, '054326963', 'THEMY FITRIANI RANTE TONGLO', 'Ilmu Hukum (S1)', 'f.ann.y.ka.rlind.abnc@gmail.com', '@10121988Ut'),
(31, '054327206', 'BEUTRIX DJULISA MASANGKA', 'Manajemen (S1)', 'f.ann.y.ka.rlind.a.bnc@gmail.com', '@11032001Ut'),
(32, '054329636', 'BENYAMIN KADEU\'', 'Manajemen (S1)', 'f.ann.y.ka.rli.ndabn.c@gmail.com', '@04122004Ut'),
(33, '054329675', 'EMA MARKUS PASANG', 'Manajemen (S1)', 'f.ann.y.ka.rli.ndabnc@gmail.com', '@03042003Ut'),
(34, '054330995', 'CHERYL OLIVIA XAVIERA', 'Akuntansi (S1)', 'f.ann.y.ka.rlin.d.a.b.n.c@gmail.com', '@27072006Ut'),
(35, '054330694', 'NOVIANTI TANDI KALA\'', 'Akuntansi (S1)', 'f.ann.y.ka.rli.nd.a.bnc@gmail.com', '@16112004Ut'),
(36, '054331618', 'MALSENI PAGORAI', 'Ilmu Pemerintahan (S1)', 'f.ann.y.ka.rlin.da.bnc@gmail.com', '@30041990Ut'),
(37, '859183083', 'JIMMY PASOLANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.n.da.bnc@gmail.com', '@20082002Ut'),
(38, '859436328', 'HOUDYA DONITA', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.ka.rli.n.d.ab.n.c@gmail.com', '@19091983Ut'),
(39, '859437978', 'INDIYANI PAELONGAN', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rli.n.d.ab.nc@gmail.com', '@20112002Ut'),
(40, '859437985', 'Esra Yeni Palangiran ', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rli.n.d.a.bn.c@gmail.com', '@05011999Ut'),
(41, '859440098', 'RISMA PAEMBONAN', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rli.ndab.n.c@gmail.com', '@10101996Ut'),
(42, '859440113', 'ASTRIA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rli.ndab.nc@gmail.com', '@10022004Ut'),
(43, '859440256', 'RISMAYANTI', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.ka.rli.nd.abn.c@gmail.com', '@05051995Ut'),
(44, '859440374', 'NOVIANTI KASSAK', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rlin.dabn.c@gmail.com', '@11111995Ut'),
(45, '859440532', 'HERMIN DATU TADAN', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.ka.rlin.da.b.nc@gmail.com', '@25031989Ut'),
(46, '859440596', 'SUSI MANZANO', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rlind.a.b.nc@gmail.com', '@19121999Ut'),
(47, '859440629', 'AGUSTINA TOMBE\'', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.ka.rli.n.d.a.b.n.c@gmail.com', '@18081992Ut'),
(48, '859441907', 'YUNIS SAPUTRI TIRANDA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.l.in.dab.n.c@gmail.com', '@23041998Ut'),
(49, '859442052', 'AGRENI TANDILILING', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.n.d.ab.nc@gmail.com', '@08081993Ut'),
(50, '859442496', 'IRMAYANTI RALLA SALI\\\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.i.ndab.n.c@gmail.com', '@22102004Ut'),
(51, '859443047', 'RIBKA KALIBO\\\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.i.n.da.b.nc@gmail.com', '@28081995Ut'),
(52, '859443079', 'SARTIKA SENO LINGGI\\\'', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.li.n.d.a.b.n.c@gmail.com', '@12032000Ut'),
(53, '859443119', 'EBIT AMBA\\\'', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.nd.ab.nc@gmail.com', '@22081996Ut'),
(54, '859443126', 'KARTINI BUNGA', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.ndab.nc@gmail.com', '@16081986Ut'),
(55, '859443165', 'ADRIANI ARJU', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.ind.ab.n.c@gmail.com', '@20112000Ut'),
(56, '859443172', 'BERTY RENI RESKI', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.i.nd.abn.c@gmail.com', '@10101999Ut'),
(57, '859443212', 'MONICA SARINA RIANTI BAAN', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.indab.n.c@gmail.com', '@25032004Ut'),
(58, '859443237', 'MERIANTI RATTE PUANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.l.in.d.a.b.n.c@gmail.com', '@05031993Ut'),
(59, '859443251', 'NOTAVIAN MASUANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.indabn.c@gmail.com', '@07101998Ut'),
(60, '859443269', 'DESMIANTI RIDA PALATANG', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.li.n.d.ab.nc@gmail.com', '@15041984Ut'),
(61, '859443283', 'SELOMITHA MARSAYU', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.n.d.a.b.nc@gmail.com', '@09032006Ut'),
(62, '052596134', 'JESCIKA BUBUN ADUNG', 'Ilmu Pemerintahan (S1)', 'f.ann.y.kar.l.inda.bn.c@gmail.com', '@11092005Ut'),
(63, '859442489', 'SERNIYANTI', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.i.nda.b.nc@gmail.com', '@09092002Ut'),
(64, '052292836', 'ANGREANI PATINARAN', 'PENDIDIKAN PANCASILA DAN KEWARGANEGARAAN', 'f.ann.y.ka.rl.i.nda.bnc@gmail.com', '@18081987Ut'),
(65, '052484023', 'ADRIANA BURA', 'Pendidikan Pancasila dan Kewarganegaraan (S1)', 'f.ann.y.kar.li.n.da.b.n.c@gmail.com', '@25032005Ut'),
(66, '052591475', 'SERTIANA SASO\\\'', 'Ilmu Perpustakaan (S1)', 'f.ann.y.kar.l.in.dab.nc@gmail.com', '@10091986Ut'),
(67, '052591776', 'NOPATRI LIMBO BAE\\\'', 'Manajemen (S1)', 'f.ann.y.kar.l.i.nd.a.b.nc@gmail.com', '@12112003Ut'),
(68, '052594044', 'HERMIN ERI ITTU', 'Manajemen (S1)', 'f.ann.y.kar.l.i.nd.abnc@gmail.com', '@09051998Ut'),
(69, '052594083', 'ESTER', 'Ilmu Hukum (S1)', 'f.ann.y.kar.l.i.nda.b.n.c@gmail.com', '@26022022Ut'),
(70, '052594155', 'RENSENI MANGOLO', 'Manajemen (S1)', 'f.ann.y.kar.l.in.d.a.b.nc@gmail.com', '@10022005Ut'),
(71, '052594273', 'LARA SITI SINGKI', 'Sistem Informasi (S1)', 'f.ann.y.kar.l.i.ndabn.c@gmail.com', '@10012004Ut'),
(72, '052595576', 'NEVI MONITA', 'Akuntansi (S1)', 'f.ann.y.kar.l.i.n.d.a.b.nc@gmail.com', '@30102004Ut'),
(73, '052595956', 'RESTIANI DAUN DATU', 'Manajemen (S1)', 'f.ann.y.kar.l.in.d.a.bn.c@gmail.com', '@07062007Ut'),
(74, '052596023', 'MARVHIN ZWEI LAMBE', 'Ilmu Hukum (S1)', 'f.ann.y.kar.l.in.da.b.n.c@gmail.com', '@01022006Ut'),
(75, '054326734', 'SENI KAMBUNO', 'Ilmu Hukum (S1)', 'f.ann.y.ka.rlinda.b.n.c@gmail.com', '@10091998Ut'),
(76, '054326773', 'SERLY BAKE\\\' EMBONGBULAN', 'Pendidikan Ekonomi (S1)', 'f.ann.y.ka.rlind.ab.nc@gmail.com', '@12091978Ut'),
(77, '054326806', 'YULIANA MARAMBAK', 'Ilmu Perpustakaan (S1)', 'f.ann.y.ka.rlind.a.bn.c@gmail.com', '@25011985Ut'),
(78, '054326988', 'SET SANDY ARRUAN', 'Ilmu Hukum (S1)', 'f.ann.y.ka.rlind.a.b.n.c@gmail.com', '@28092003Ut'),
(79, '054328587', 'IRPAN PAKULLA', 'Ilmu Hukum (S1)', 'f.ann.y.ka.rlin.da.bn.c@gmail.com', '@28042003Ut'),
(80, '054329571', 'DESI NATALIA', 'Pendidikan Pancasila dan Kewarganegaraan (S1)', 'f.ann.y.ka.rli.n.d.a.b.nc@gmail.com', '@20061995Ut'),
(81, '054330078', 'CINTHYA AYU SULISTYONINGRUM', 'Ilmu Perpustakaan (S1)', 'cinthyaayu04@gmail.com', 'Jepara2004'),
(82, '054330282', 'DELWIN PARAPASAN', 'Akuntansi (S1)', 'f.ann.y.ka.rlin.d.a.bnc@gmail.com', '@17122006Ut'),
(83, '054330347', 'EFRI ELNI KANDAURE', 'Ilmu Komunikasi (S1)', 'f.ann.y.ka.rlin.d.ab.nc@gmail.com', '@22062003Ut'),
(84, '054330616', 'ANDI ANDAK', 'Ilmu Pemerintahan (S1)', 'f.ann.y.ka.rlind.ab.n.c@gmail.com', '@07042003Ut'),
(85, '054330623', 'THABITA PUTRI MANGONTAN', 'Akuntansi Keuangan Publik (S1)', 'f.ann.y.ka.rlind.abn.c@gmail.com', '@09112001Ut'),
(86, '054331048', 'EKY', 'Pendidikan Pancasila dan Kewarganegaraan (S1)', 'f.ann.y.ka.rli.n.da.bnc@gmail.com', '@07112003Ut'),
(87, '054331055', 'MARTINA RAMA\'', 'Manajemen (S1)', 'f.ann.y.ka.rlin.dab.n.c@gmail.com', '@15031995Ut'),
(88, '054331585', 'JUNARDI SALEPPA', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Pertanian (S1)', 'f.ann.y.ka.rli.nd.a.b.n.c@gmail.com', '@01062002Ut'),
(89, '054331893', 'GIDION MAREA', 'Pendidikan Pancasila dan Kewarganegaraan (S1)', 'f.ann.y.ka.rli.n.dabnc@gmail.com', '@21011993Ut'),
(90, '859432954', 'IMELDA BURARA\'', 'PGSD', 'f.ann.y.ka.rl.i.n.dabnc@gmail.com', '@30051993Ut'),
(91, '859432979', 'RISMA BOROTODING', 'PGSD', 'f.ann.y.ka.rl.in.d.ab.nc@gmail.com', '@09061991Ut'),
(92, '859433021', 'SUSSA', 'PGSD', 'f.ann.y.ka.rl.in.d.a.b.nc@gmail.com', '@01121986Ut'),
(93, '859436145', 'OKTAVIANI LOLOBUNGA\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rli.n.dab.n.c@gmail.com', '@06101998Ut'),
(94, '859438045', 'INDRIYANI KOMBONG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rli.n.d.abn.c@gmail.com', '@10062005Ut'),
(95, '859440231', 'OKTAVINA TA\'BI PADANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rli.nd.ab.n.c@gmail.com', '@03102006Ut'),
(96, '859440335', 'ESTETIKA MANTANA', 'Pendidikan Guru Anak Usia Dini Masukan Guru Prajabatan (Pre Srevice) (S1)', 'f.ann.y.ka.rlin.d.abnc@gmail.com', '@19062006Ut'),
(97, '859440342', 'EKLESIA INE\\\' SARANGA\\\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.ka.rlin.d.abn.c@gmail.com', '@05032002Ut'),
(98, '859440708', 'DIANTI BANNE', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rlin.d.ab.n.c@gmail.com', '@31071998Ut'),
(99, '859442464', 'VERONIKA SARCE', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.in.d.a.bnc@gmail.com', '@11022002Ut'),
(100, '859442575', 'JUNIATI RUMPA', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.in.d.abn.c@gmail.com', '@22061987Ut'),
(101, '859443086', 'NOVAN BUNGA\\\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.i.n.da.bnc@gmail.com', '@01042005Ut'),
(102, '859443133', 'NURHASANA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.l.in.dabn.c@gmail.com', '@11122003Ut'),
(103, '859443244', 'ELSI EVIT TANGILOMBAN', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.l.ind.abn.c@gmail.com', '@05061999Ut'),
(104, '052596048', 'GREGORIUS SANTO MARAMPA', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Pertanian (S1)', 'f.ann.y.kar.l.in.da.bn.c@gmail.com', '@17082009Ut'),
(105, '052588785', 'ALFIN PETRUS DUMA\\\' TANDINGAN', 'Pariwisata (S1)', 'alfinpetrus4@gmail.com', 'Amarise28'),
(106, '052595917', 'ROBIANTO', 'Ilmu Komunikasi (S1)', 'rantoebong45@gmail.com', '@13101996Ut'),
(107, '859443197', 'SARCE BURA', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.nd.ab.n.c@gmail.com', '@03041993Ut'),
(108, '859439093', 'GALIS BOREAN', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.ka.rli.n.dabn.c@gmail.com', '@26101999Ut'),
(109, '052723283', 'MARNI BAKO\\\'', 'Ilmu Hukum (S1)', '052723283@ecampus.ut.ac.id', '@08022003Ut'),
(110, '055292178', 'ABDUL RAJAB', 'Sistem Informasi (S1)', 'f.ann.y.karl.i.n.da.bn.c@gmail.com', '@07071998Ut'),
(111, '055291896', 'ADRIANUS RESKI PASANDE', 'Manajemen (S1)', 'f.ann.y.kar.linda.b.nc@gmail.com', 'Tidak diketahui'),
(112, '859450762', 'AGUSTINA LIMBONG MANIK', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.karl.i.n.da.b.nc@gmail.com', '@11101996Ut'),
(113, '055292519', 'AGUSTINUS PULUNG', 'Manajemen (S1)', 'f.ann.y.karl.i.n.da.bnc@gmail.com', 'Tidak diketahui'),
(114, '859441573', 'ALFRIDA ELIAS', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.n.d.abn.c@gmail.com', 'Tidak diketahui'),
(115, '055292264', 'ANDAREAS ANGGI PASOLON', 'Perencanaan Wilayah dan Kota (S1)', 'f.ann.y.kar.linda.bn.c@gmail.com', 'Tidak diketahui'),
(116, '055290547', 'ANDREAS DUMA\\\'TONAPA', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Peternakan (S1)', 'andreastonapa1@gmail.com', 'Tidak diketahui'),
(117, '859450637', 'ANGYLIANA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.lindab.n.c@gmail.com', 'Tidak diketahui'),
(118, '055292415', 'CANDRA KURNYAWAN TANDIRAU', 'Ilmu Hukum (S1)', 'f.ann.y.karl.i.nd.ab.nc@gmail.com', 'Tidak diketahui'),
(119, '055682763', 'BILL LUCKY LEMBA', 'Manajemen (S1)', 'f.ann.y.karl.i.ndab.n.c@gmail.com', 'Tidak diketahui'),
(120, '055292185', 'CHENI LEMBANG BULAWAN', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.kar.li.nd.abn.c@gmail.com', 'Tidak diketahui'),
(121, '859450938', 'DELIANTI KOTOK', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.li.nda.b.n.c@gmail.com', 'Tidak diketahui'),
(122, '859450802', 'DITA ALI LANDE', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.nda.b.nc@gmail.com', 'Tidak diketahui'),
(123, '859450827', 'ELIVSTA SAPUTRI', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.nda.bn.c@gmail.com', 'Tidak diketahui'),
(124, '055682731', 'ELVIN SULI', 'Sosiologi (S1)', 'f.ann.y.karl.i.nda.bn.c@gmail.com', 'Tidak diketahui'),
(125, '054329682', 'FENNYWATY', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.ka.rli.n.dab.nc@gmail.com', 'Tidak diketahui'),
(126, '859449403', 'FITRIANI KAYANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.lind.abnc@gmail.com', 'Tidak diketahui'),
(127, '859450945', 'HERDAYANTI PAYUNG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.ndab.nc@gmail.com', 'Tidak diketahui'),
(128, '055682953', 'IRWAN', 'PENDIDIKAN AGAMA ISLAM (S1)', 'f.ann.y.kar.li.ndabnc@gmail.com', 'Tidak diketahui'),
(129, '055292533', 'KRISTINA', 'Ilmu Administrasi Negara (S1)', 'f.ann.y.karl.i.n.d.a.b.nc@gmail.com', 'Tidak diketahui'),
(130, '859448282', 'KRISTINA JUNI KONDA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.lin.d.a.bn.c@gmail.com', 'Tidak diketahui'),
(131, '859450683', 'LINDA MARLIS', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.karl.i.n.d.abnc@gmail.com', 'Tidak diketahui'),
(132, '055292408', 'NATALIA', 'Ilmu Administrasi Bisnis (S1)', 'f.ann.y.karl.i.n.d.ab.nc@gmail.com', 'Tidak diketahui'),
(133, '055040992', 'PATRESIA SANGGA', 'Pendidikan Biologi (S1)', 'f.ann.y.kar.lin.d.ab.n.c@gmail.com', 'Tidak diketahui'),
(134, '052487154', 'PELIPUS', 'Agribisnis Bidang Minat Penyuluhan dan Komunikasi Pertanian (S1)', 'f.ann.y.kar.li.n.dab.n.c@gmail.com', 'Tidak diketahui'),
(135, '055682985', 'PONCIANA SALU', 'Ilmu Hukum (S1)', 'f.ann.y.karl.i.nd.a.bnc@gmail.com', 'Tidak diketahui'),
(136, '055291982', 'RESTI BURA LIMBONG', 'Perpajakan (S1)', 'f.ann.y.karl.i.n.da.b.n.c@gmail.com', 'Tidak diketahui'),
(137, '859448963', 'RIANTI BARRAK PADANG', 'Pendidikan Guru Anak Usia Dini Masukan Guru Prajabatan (Pre Srevice) (S1)', 'f.ann.y.kar.lin.da.b.n.c@gmail.com', 'Tidak diketahui'),
(138, '055292526', 'RILYA PUAK LEMBANG', 'Manajemen (S1)', 'f.ann.y.kar.lind.ab.n.c@gmail.com', 'Tidak diketahui'),
(139, '859450597', 'SELVIANA SULU\\\'', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.lind.ab.nc@gmail.com', 'Tidak diketahui'),
(140, '859448917', 'SEPRIANI RONA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.lin.d.ab.nc@gmail.com', 'Tidak diketahui'),
(141, '055042158', 'SRI HARMEATI PAUANG', 'Sistem Informasi (S1)', 'f.ann.y.kar.lin.da.b.nc@gmail.com', 'Tidak diketahui'),
(142, '055287334', 'STEPANUS PALLUNAN', 'Pendidikan Ekonomi (S1)', 'f.ann.y.kar.lin.da.bn.c@gmail.com', 'Tidak diketahui'),
(143, '859450723', 'VERAWATI KARAENG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'vherawatikaraeng263@gmail.com', 'Tidak diketahui'),
(144, '055040803', 'YORINDA SOMBOLINGGI\\\'', 'Ilmu Perpustakaan (S1)', 'f.ann.y.kar.lin.dab.nc@gmail.com', 'Tidak diketahui'),
(145, '859448497', 'YOSEP TANDI', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.kar.lin.da.bnc@gmail.com', 'Tidak diketahui'),
(146, '859450669', 'YUSTINA WINDA SAU\\\'', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.karl.i.n.d.ab.n.c@gmail.com', 'Tidak diketahui'),
(147, '859449356', '', NULL, NULL, '@25101973Ut'),
(148, '859449356', '', NULL, NULL, '@25101973Ut'),
(149, '859451051', '', NULL, NULL, '@21051995Ut'),
(150, '055292375', '', NULL, NULL, ''),
(151, '055292375', '', NULL, NULL, ''),
(152, '055292375', '', NULL, NULL, ''),
(153, '055292375', '', NULL, NULL, ''),
(154, '055292375', '', NULL, NULL, '@10102006Ut'),
(155, '055292375', '', NULL, NULL, '@10102006Ut'),
(156, '055292375', '', NULL, NULL, '@10102006Ut'),
(157, '055682795', 'ELVI SANGGALANGI', 'Ilmu Pemerintahan (S1)', 'sanggalangielvi@gmail.com', 'Elvi1998'),
(158, '859448949', 'GRICE MA\\\'DIN', 'Pendidikan Guru Anak Usia Dini Masukan Guru Dalam jabatan (In Service) (S1)', 'f.ann.y.kar.l.i.n.d.abnc@gmail.com', '@27071984Ut'),
(159, '859450794', 'HASNIDAR', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.kar.li.ndab.n.c@gmail.com', '@19091996Ut'),
(160, '859448092', 'IRFAN LA MADA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'lamadairfan@gmail.com', 'Lmdairfn03'),
(161, '055039357', 'KRISLIATI TONAPA', 'Akuntansi (S1)', 'tonapakrsty@gmail.com', 'Elvano24'),
(162, '859450676', 'PINCE PASILA', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.karl.i.n.d.abn.c@gmail.com', '@31082010Ut'),
(163, '055682788', 'PRIAYUANTY', 'Teknologi Pendidikan (S1)', 'f.ann.y.karl.i.nd.a.b.nc@gmail.com', '@01632006Ut'),
(164, '859450873', 'RISKA SERANG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Prajabatan (Pre Service) (S1)', 'f.ann.y.karl.i.n.dabn.c@gmail.com', '@22092000Ut'),
(165, '859450755', 'SEPRIANI DATU LOTONG', 'Pendidikan Guru Sekolah Dasar Masukan Guru Dalam jabatan (in Service) (S1)', 'f.ann.y.karl.i.n.dab.nc@gmail.com', '@06112003Ut'),
(166, '055292447', 'YANSI SANDI RAYO', 'Ilmu Perpustakaan (S1)', 'f.ann.y.karl.i.nd.ab.n.c@gmail.com', '@21012002Ut'),
(167, '055292257', 'ABDUL AWAL DZIKIR', 'Ilmu Hukum (S1)', 'f.ann.y.kar.lin.dabn.c@gmail.com', '@13012001Ut'),
(168, '055292422', 'JEWICA VIRGI ANDHANY', 'Ilmu Administrasi Negara (S1)', 'f.ann.y.karl.i.nd.a.bn.c@gmail.com', '@31082003Ut');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tuton`
--
ALTER TABLE `tuton`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tuton`
--
ALTER TABLE `tuton`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
