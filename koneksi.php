<?php

$servername = "localhost"; // Ganti dengan nama host database Anda
$username = "nama_pengguna"; // Ganti dengan nama pengguna database Anda
$password = "kata_sandi"; // Ganti dengan kata sandi database Anda
$dbname = "nama_database"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
// Menutup koneksi (opsional jika Anda tidak ingin menutup koneksi di sini)
// $conn->close();
?>
