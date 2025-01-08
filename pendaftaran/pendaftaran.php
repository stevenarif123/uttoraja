<?php
require_once '../koneksi.php';

// Initialize variables for the success and error messages
$showSuccessModal = false;
$showErrorModal = false;

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Validate and sanitize input data
    $nama_lengkap = strtoupper(trim($_POST['firstn']));
    $nomor_hp = trim($_POST['phone']);
    $tempat_lahir = strtoupper(trim($_POST['tempat_lahir']));
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $ibu_kandung = strtoupper(trim($_POST['ibu_kandung']));
    $nik = trim($_POST['nik']);
    $jurusan = trim($_POST['jurusan']);
    $agama = trim($_POST['agama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pertanyaan = trim($_POST['pertanyaan']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO pendaftar (nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, ibu_kandung, nik, jurusan, agama, jenis_kelamin, pertanyaan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nama_lengkap, $nomor_hp, $tempat_lahir, $tanggal_lahir, $ibu_kandung, $nik, $jurusan, $agama, $jenis_kelamin, $pertanyaan);

    // Execute the statement
    if ($stmt->execute()) {
        $showSuccessModal = true; // Show success modal
    } else {
        $showErrorModal = true; // Show error modal
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Redirect back to the form with success/error state
session_start();
if ($showSuccessModal) {
    $_SESSION['form_status'] = 'success';
} else if ($showErrorModal) {
    $_SESSION['form_status'] = 'error';
}

// Redirecting to the form page
header("Location: index.php");
exit();
?>


// Perintah SQL untuk membuat tabel pendaftar:
/*
CREATE TABLE pendaftar (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    ibu_kandung VARCHAR(255) NOT NULL,
    nik VARCHAR(50) NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    agama VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(10) NOT NULL,
    pertanyaan TEXT
);
*/
// Tutup koneksi