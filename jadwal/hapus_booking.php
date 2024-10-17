<?php
// hapus_booking.php
session_start();
include 'koneksi.php';

if (!isset($_POST['nim']) || !isset($_POST['id_acara'])) {
    echo "Data tidak lengkap.";
    exit();
}

$nim = $_POST['nim'];
$id_acara = $_POST['id_acara'];

// Delete booking
$stmt = $conn->prepare("DELETE FROM booking WHERE NIM = ? AND id_acara = ?");
$stmt->bind_param("si", $nim, $id_acara);

if ($stmt->execute()) {
    echo "<script>alert('Mahasiswa dengan NIM $nim berhasil dihapus dari acara.'); window.location.href='admincontrol.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus mahasiswa dengan NIM $nim.'); window.location.href='admincontrol.php';</script>";
}
?>
