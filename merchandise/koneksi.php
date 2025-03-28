<?php
// Parameter koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "merchandise";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset untuk memastikan penanganan karakter khusus yang tepat
$conn->set_charset("utf8mb4");
?>
