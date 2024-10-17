<?php
// print_absen.php
session_start();
include 'koneksi.php';

// Cek apakah id_acara sudah diberikan
if (!isset($_GET['id_acara'])) {
    echo "ID acara tidak ditemukan.";
    exit();
}

$id_acara = $_GET['id_acara'];

// Ambil data acara
$stmt = $conn->prepare("SELECT * FROM acara WHERE id_acara = ?");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$acara = $stmt->get_result()->fetch_assoc();

if (!$acara) {
    echo "Acara tidak ditemukan.";
    exit();
}

// Ambil data booking dan mahasiswa
$stmt = $conn->prepare("SELECT m.NIM, m.Nama, m.Jurusan FROM booking b JOIN mahasiswaut m ON b.NIM = m.NIM WHERE b.id_acara = ? ORDER BY m.Nama ASC");
$stmt->bind_param("i", $id_acara);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir - <?php echo $acara['nama_acara']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print { display: none; }
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <h2 class="text-center">Daftar Hadir</h2>
    <h3 class="text-center"><?php echo $acara['nama_acara']; ?></h3>
    <p class="text-center"><?php echo date('d-m-Y', strtotime($acara['tanggal_acara'])); ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($bookings->num_rows > 0):
                $no = 1;
                while($row = $bookings->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row['NIM']; ?></td>
                <td><?php echo $row['Nama']; ?></td>
                <td><?php echo $row['Jurusan']; ?></td>
                <td></td>
            </tr>
            <?php
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="5" class="text-center">Belum ada peserta yang mendaftar.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button class="btn btn-primary no-print" onclick="window.print();">Cetak</button>
    <a href="index.php" class="btn btn-secondary no-print">Kembali</a>
</div>
</body>
</html>
