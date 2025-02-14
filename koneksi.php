<?php

$servername = "localhost"; // Ganti dengan nama host database Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$dbname = "datamahasiswa"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  error_log("Koneksi gagal: " . $conn->connect_error . "\n", 3, "../pendaftaran/error_log");
  die("Koneksi gagal: " . $conn->connect_error);
} else {
    error_log("Koneksi database berhasil\n", 3, "../pendaftaran/error_log");
}
// Menutup koneksi (opsional jika Anda tidak ingin menutup koneksi di sini)
// $conn->close();
?>
