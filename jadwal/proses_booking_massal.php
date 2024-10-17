<?php
// proses_booking_massal.php
session_start();
header('Content-Type: application/json');

include 'koneksi.php';

if (!isset($_POST['id_acara']) || !isset($_POST['nim_list'])) {
    $response = array('message' => 'Data tidak lengkap.');
    echo json_encode($response);
    exit();
}

$id_acara = $_POST['id_acara'];
$nim_list = explode(',', $_POST['nim_list']);

// Cek apakah acara ada
$stmt = $conn->prepare("SELECT * FROM acara WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$acara = $stmt->get_result()->fetch_assoc();

if (!$acara) {
    $response = array('message' => 'Acara tidak ditemukan.');
    echo json_encode($response);
    exit();
}

// Cek jumlah booking saat ini
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM booking WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$booking_count = $result['total'];

$max_booking = $acara['max_booking'];
$success_count = 0;
$error_messages = array();

foreach ($nim_list as $nim) {
    // Check if booking already exists
    $stmt = $conn->prepare("SELECT * FROM booking WHERE NIM = ? AND id_acara = ?");
    $stmt->bind_param("si", $nim, $id_acara);
    $stmt->execute();
    $existing_booking = $stmt->get_result();

    if ($existing_booking->num_rows > 0) {
        $error_messages[] = "Mahasiswa dengan NIM $nim sudah terdaftar di acara ini.";
        continue;
    }

    if ($booking_count >= $max_booking) {
        $error_messages[] = "Kuota penuh. Tidak dapat menambah mahasiswa dengan NIM $nim.";
        continue;
    }

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO booking (NIM, id_acara, tanggal_booking) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $nim, $id_acara);
    if ($stmt->execute()) {
        $success_count++;
        $booking_count++;
    } else {
        $error_messages[] = "Gagal menambahkan mahasiswa dengan NIM $nim.";
    }
}

$message = "$success_count mahasiswa berhasil ditambahkan.";
if (!empty($error_messages)) {
    $message .= "\n" . implode("\n", $error_messages);
}

$response = array('message' => $message);
echo json_encode($response);
?>
