<?php
// proses_booking.php
session_start();
if (!isset($_SESSION['nim']) || !isset($_POST['id_acara'])) {
    header('Location: index.php');
    exit();
}

include 'koneksi.php';

$id_acara = $_POST['id_acara'];
$nim = $_SESSION['nim'];

// Cek jumlah booking
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM booking WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT max_booking FROM acara WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$acara = $stmt->get_result()->fetch_assoc();

if ($result['total'] < $acara['max_booking']) {
    // Simpan booking
    $stmt = $conn->prepare("INSERT INTO booking (NIM, id_acara, tanggal_booking) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $nim, $id_acara);
    $stmt->execute();

    echo "Booking berhasil!";
} else {
    echo "Kuota booking telah penuh.";
}
?>
