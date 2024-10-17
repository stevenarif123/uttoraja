<?php
// login.php
session_start();
include 'koneksi.php'; // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    // Menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM mahasiswaut WHERE NIM = ? AND TanggalLahir = ?");
    $stmt->bind_param("ss", $nim, $tanggal_lahir);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Data ditemukan
        $_SESSION['nim'] = $nim;
        header('Location: booking.php');
    } else {
        // Data tidak ditemukan
        $_SESSION['error'] = 'Data tidak ditemukan';
        header('Location: index.php');
    }
}
?>
