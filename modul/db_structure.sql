-- Table structure for mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(9) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for pengiriman_modul
CREATE TABLE IF NOT EXISTS `pengiriman_modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nim` varchar(9) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `tanggal_kirim` date DEFAULT NULL,
  `tanggal_tiba` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Belum Tersedia',
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `nim` (`nim`),
  CONSTRAINT `pengiriman_modul_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data for testing
INSERT INTO `mahasiswa` (`nim`, `nama`, `tanggal_lahir`, `program_studi`, `status`) VALUES
('123456789', 'Budi Santoso', '1995-05-15', 'S1 Manajemen', 'Aktif'),
('987654321', 'Dewi Anggraini', '1998-10-22', 'S1 Akuntansi', 'Aktif'),
('567890123', 'Ahmad Rizky', '1997-03-07', 'S1 Ilmu Komunikasi', 'Aktif');

INSERT INTO `pengiriman_modul` (`nim`, `semester`, `tahun_ajaran`, `tanggal_kirim`, `tanggal_tiba`, `status`, `keterangan`) VALUES
('123456789', 'Ganjil', '2023/2024', '2023-09-10', '2023-09-15', 'Sudah Tersedia', 'Modul lengkap semester 1'),
('987654321', 'Ganjil', '2023/2024', '2023-09-12', NULL, 'Dalam Perjalanan', 'Pengiriman via JNE'),
('567890123', 'Ganjil', '2023/2024', NULL, NULL, 'Belum Tersedia', 'Menunggu pengiriman dari UT Pusat');
