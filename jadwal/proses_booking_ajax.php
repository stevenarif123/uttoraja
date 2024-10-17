<?php
// proses_booking_ajax.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['nim']) || !isset($_POST['id_acara'])) {
    $response = array('message' => 'Akses ditolak.');
    echo json_encode($response);
    exit();
}

include 'koneksi.php';

$id_acara = $_POST['id_acara'];
$nim = $_SESSION['nim'];

// Cek apakah sudah booking acara ini sebelumnya
$stmt = $conn->prepare("SELECT * FROM booking WHERE NIM = ? AND id_acara = ?");
$stmt->bind_param("si", $nim, $id_acara);
$stmt->execute();
$existing_booking = $stmt->get_result();

if ($existing_booking->num_rows > 0) {
    $response = array('message' => 'Anda sudah melakukan booking untuk acara ini.');
    echo json_encode($response);
    exit();
}

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
    if ($stmt->execute()) {
        $response = array('message' => 'Booking berhasil!');
    } else {
        $response = array('message' => 'Terjadi kesalahan saat menyimpan booking.');
    }
} else {
    $response = array('message' => 'Kuota booking telah penuh.');
}

echo json_encode($response);
?>
