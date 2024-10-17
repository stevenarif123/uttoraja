<?php
// konfirmasi.php
session_start();
if (!isset($_SESSION['nim']) || !isset($_POST['id_acara'])) {
    header('Location: index.php');
    exit();
}

include 'koneksi.php';

$id_acara = $_POST['id_acara'];
$nim = $_SESSION['nim'];

// Ambil data acara
$stmt = $conn->prepare("SELECT * FROM acara WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$acara = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1 class="mt-5">Konfirmasi Booking</h1>
    <p>Apakah Anda yakin ingin booking acara berikut?</p>
    <p><strong><?php echo $acara['nama_acara']; ?> - <?php echo $acara['tanggal_acara']; ?></strong></p>
    <form action="proses_booking.php" method="post">
        <input type="hidden" name="id_acara" value="<?php echo $id_acara; ?>">
        <button type="submit" class="btn btn-success">Ya, Booking</button>
        <a href="booking.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
