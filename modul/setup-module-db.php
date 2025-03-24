<?php
/**
 * Module Database Setup Script
 * 
 * This script creates the necessary tables for the module tracking system
 * and populates them with sample data for testing
 */

// Include database connection
require_once '../koneksi.php';

// Create mahasiswa table if not exists
$mahasiswaTable = "
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
";

// Create pengiriman_modul table if not exists
$pengirimanModulTable = "
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
";

// Execute the table creation queries
try {
    if ($conn->query($mahasiswaTable) === TRUE) {
        echo "Table 'mahasiswa' created successfully or already exists<br>";
    } else {
        echo "Error creating table 'mahasiswa': " . $conn->error . "<br>";
    }
    
    if ($conn->query($pengirimanModulTable) === TRUE) {
        echo "Table 'pengiriman_modul' created successfully or already exists<br>";
    } else {
        echo "Error creating table 'pengiriman_modul': " . $conn->error . "<br>";
    }
    
    // Check if we already have sample data
    $result = $conn->query("SELECT COUNT(*) as count FROM mahasiswa");
    $row = $result->fetch_assoc();
    
    // Insert sample data if the table is empty
    if ($row['count'] == 0) {
        // Sample mahasiswa data
        $mahasiswaData = "
        INSERT INTO `mahasiswa` (`nim`, `nama`, `tanggal_lahir`, `program_studi`, `status`) VALUES
        ('123456789', 'Budi Santoso', '1995-05-15', 'S1 Manajemen', 'Aktif'),
        ('987654321', 'Dewi Anggraini', '1998-10-22', 'S1 Akuntansi', 'Aktif'),
        ('567890123', 'Ahmad Rizky', '1997-03-07', 'S1 Ilmu Komunikasi', 'Aktif'),
        ('456789012', 'Siti Rahma', '1996-09-12', 'S1 PGSD', 'Aktif'),
        ('345678901', 'Rizki Pratama', '1999-02-28', 'S1 Teknologi Informasi', 'Aktif');
        ";
        
        // Sample pengiriman_modul data
        $pengirimanModulData = "
        INSERT INTO `pengiriman_modul` (`nim`, `semester`, `tahun_ajaran`, `tanggal_kirim`, `tanggal_tiba`, `status`, `keterangan`) VALUES
        ('123456789', 'Ganjil', '2023/2024', '2023-09-10', '2023-09-15', 'Sudah Tersedia', 'Modul lengkap semester 1'),
        ('987654321', 'Ganjil', '2023/2024', '2023-09-12', NULL, 'Dalam Perjalanan', 'Pengiriman via JNE'),
        ('567890123', 'Ganjil', '2023/2024', NULL, NULL, 'Belum Tersedia', 'Menunggu pengiriman dari UT Pusat'),
        ('456789012', 'Ganjil', '2023/2024', '2023-09-05', '2023-09-10', 'Sudah Tersedia', 'Modul lengkap semester 3'),
        ('345678901', 'Ganjil', '2023/2024', '2023-09-08', NULL, 'Dalam Perjalanan', 'Pengiriman via POS');
        ";
        
        // Execute sample data insertion
        if ($conn->multi_query($mahasiswaData)) {
            echo "Sample mahasiswa data inserted successfully<br>";
            $conn->next_result();  // Move past the first result set
        } else {
            echo "Error inserting mahasiswa data: " . $conn->error . "<br>";
        }
        
        if ($conn->multi_query($pengirimanModulData)) {
            echo "Sample pengiriman_modul data inserted successfully<br>";
        } else {
            echo "Error inserting pengiriman_modul data: " . $conn->error . "<br>";
        }
    } else {
        echo "Sample data already exists. Skipping data insertion.<br>";
    }
    
    echo "<br>Database setup completed successfully! 🎉<br>";
    echo "<a href='modul.php'>Go to Module Page</a>";
    
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

// Close connection
$conn->close();
?>
