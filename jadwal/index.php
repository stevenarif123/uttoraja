<?php
// index.php
session_start();
include 'koneksi.php';

// Fetch events
$acaraList = $conn->query("SELECT * FROM acara");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Kehadiran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1 class="mt-5">Daftar Jadwal</h1>
    <?php while($acara = $acaraList->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="card-header">
            <?php echo $acara['nama_acara']; ?> - <?php echo date('d-m-Y', strtotime($acara['tanggal_acara'])); ?>
        </div>
        <div class="card-body">
            <p>Maksimal Kursi: <?php echo $acara['max_booking']; ?> orang</p>
            <?php
            // Fetch the bookings for this event
            $stmt = $conn->prepare("SELECT m.Nama, m.Jurusan FROM booking b JOIN mahasiswaut m ON b.NIM = m.NIM WHERE b.id_acara = ?");
            $stmt->bind_param("i", $acara['id_acara']);
            $stmt->execute();
            $bookings = $stmt->get_result();
            ?>
            <?php if ($bookings->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $booking['Nama']; ?></td>
                        <td><?php echo $booking['Jurusan']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Belum ada mahasiswa yang mendaftar acara ini.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endwhile; ?>
    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#loginModal">Masuk</button>
</div>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <!-- Konten modal login sesuai sebelumnya -->
  <div class="modal-dialog" role="document">
    <form id="loginForm" method="post" action="login.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Masukkan Data Peserta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="form-group">
             <label for="nim">NIM</label>
             <input type="text" class="form-control" id="nim" name="nim" required>
           </div>
           <div class="form-group">
             <label for="tanggal_lahir">Tanggal Lahir</label>
             <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
           </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
