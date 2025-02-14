<?php
// Koneksi ke database (ganti dengan informasi koneksi Anda)
require_once '../koneksi.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Siapkan dan bind
    $stmt = $conn->prepare("INSERT INTO kontak (nama, email, telepon, pesan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Eksekusi pernyataan
    if ($stmt->execute()) {
        // Redirect ke halaman kontak dengan pesan sukses
        header("Location: index.php?status=success");
    } else {
        // Redirect ke halaman kontak dengan pesan error
        header("Location: index.php?status=error");
    }

    // Tutup pernyataan dan koneksi
    $stmt->close();
    $conn->close();
}
?>
