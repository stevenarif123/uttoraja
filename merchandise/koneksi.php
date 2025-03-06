<?php

$servername = "localhost"; // Ganti dengan nama host database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$dbname = "merchandise"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  error_log("Koneksi gagal: " . $conn->connect_error . "\n", 3, "../merchandise/error_log");
  die("Koneksi gagal: " . $conn->connect_error);
} else {
    error_log("Koneksi database berhasil\n", 3, "error_log");
}

// Add these SQL statements after connection is established
$sql = [
    "ALTER TABLE Products ADD COLUMN IF NOT EXISTS 
        size_options VARCHAR(255) COMMENT 'Comma-separated list of available sizes'",
    
    "ALTER TABLE Order_Items ADD COLUMN IF NOT EXISTS 
        selected_size VARCHAR(10) AFTER quantity"
];

foreach ($sql as $query) {
    if (!$conn->query($query)) {
        error_log("Error executing query: " . $conn->error . "\n", 3, "error_log");
    }
}

// Menutup koneksi (opsional jika Anda tidak ingin menutup koneksi di sini)
// $conn->close();
?>
