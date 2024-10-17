<?php
// admincontrol.php
session_start();
include 'koneksi.php';

// Fetch events
$acaraList = $conn->query("SELECT * FROM acara");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Control - Booking Acara</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1 class="mt-5">Admin Control - Daftar Acara</h1>
    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#pilihMahasiswaModal">Pilih Mahasiswa</button>
    <?php while($acara = $acaraList->fetch_assoc()): ?>
    <div class="card mt-3">
        <div class="card-header">
            <?php echo $acara['nama_acara']; ?> - <?php echo date('d-m-Y', strtotime($acara['tanggal_acara'])); ?>
        </div>
        <div class="card-body">
            <p>Maksimal Booking: <?php echo $acara['max_booking']; ?> orang</p>
            <?php
            // Fetch the bookings for this event
            $stmt = $conn->prepare("SELECT m.NIM, m.Nama, m.Jurusan FROM booking b JOIN mahasiswaut m ON b.NIM = m.NIM WHERE b.id_acara = ?");
            $stmt->bind_param("i", $acara['id_acara']);
            $stmt->execute();
            $bookings = $stmt->get_result();
            ?>
            <?php if ($bookings->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $booking['NIM']; ?></td>
                        <td><?php echo $booking['Nama']; ?></td>
                        <td><?php echo $booking['Jurusan']; ?></td>
                        <td>
                            <form method="post" action="hapus_booking.php" style="display:inline;">
                                <input type="hidden" name="nim" value="<?php echo $booking['NIM']; ?>">
                                <input type="hidden" name="id_acara" value="<?php echo $acara['id_acara']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Belum ada mahasiswa yang mendaftar acara ini.</p>
            <?php endif; ?>
            <!-- index.php (Tambahkan di dalam loop acara di bagian card body) -->
            <div class="card-body">
                <p>Maksimal Booking: <?php echo $acara['max_booking']; ?> orang</p>
                <!-- Tabel daftar mahasiswa (sesuai sebelumnya) -->
                <!-- ... -->
                <!-- Tambahkan tombol cetak -->
                <a href="print_absen.php?id_acara=<?php echo $acara['id_acara']; ?>" class="btn btn-info no-print">Cetak Daftar Hadir</a>
            </div>

        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- Modal Pilih Mahasiswa -->
<div class="modal fade" id="pilihMahasiswaModal" tabindex="-1" role="dialog" aria-labelledby="pilihMahasiswaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="pilihMahasiswaForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Mahasiswa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Search Bar -->
          <div class="form-group">
            <input type="text" class="form-control" id="searchMahasiswa" placeholder="Cari NIM atau Nama">
          </div>
          <!-- Tabel Mahasiswa -->
          <table class="table table-bordered" id="mahasiswaTable">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Fetch mahasiswa
              $mahasiswaList = $conn->query("SELECT * FROM mahasiswaut");
              while($mahasiswa = $mahasiswaList->fetch_assoc()):
              ?>
              <tr>
                <td><input type="checkbox" name="nim[]" value="<?php echo $mahasiswa['NIM']; ?>"></td>
                <td><?php echo $mahasiswa['NIM']; ?></td>
                <td><?php echo $mahasiswa['Nama']; ?></td>
                <td><?php echo $mahasiswa['Jurusan']; ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" id="prosesMahasiswaBtn" class="btn btn-primary">Proses</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Pilih Acara -->
<div class="modal fade" id="pilihAcaraModal" tabindex="-1" role="dialog" aria-labelledby="pilihAcaraModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="pilihAcaraForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Acara</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Pilih Acara -->
          <?php
          // Fetch acara
          $acaraList = $conn->query("SELECT * FROM acara");
          while($acara = $acaraList->fetch_assoc()):
          ?>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="id_acara" id="acara<?php echo $acara['id_acara']; ?>" value="<?php echo $acara['id_acara']; ?>" required>
            <label class="form-check-label" for="acara<?php echo $acara['id_acara']; ?>">
              <?php echo $acara['nama_acara']; ?> - <?php echo date('d-m-Y', strtotime($acara['tanggal_acara'])); ?>
            </label>
          </div>
          <?php endwhile; ?>
        </div>
        <div class="modal-footer">
          <button type="button" id="prosesAcaraBtn" class="btn btn-primary">Proses</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Search function
    $("#searchMahasiswa").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#mahasiswaTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
    // Select all checkbox
    $("#selectAll").click(function(){
        $('input[name="nim[]"]').prop('checked', this.checked);
    });

    // Proses button in Pilih Mahasiswa Modal
    $("#prosesMahasiswaBtn").click(function(){
        var selectedNIM = [];
        $('input[name="nim[]"]:checked').each(function() {
            selectedNIM.push($(this).val());
        });
        if (selectedNIM.length == 0) {
            alert("Silakan pilih minimal satu mahasiswa.");
            return;
        }
        // Store selected NIMs in hidden input
        $('#pilihAcaraForm').append('<input type="hidden" name="nim_list" id="nim_list" value="'+selectedNIM.join(',')+'">');
        // Hide Pilih Mahasiswa Modal
        $('#pilihMahasiswaModal').modal('hide');
        // Show Pilih Acara Modal
        $('#pilihAcaraModal').modal('show');
    });

    // Proses button in Pilih Acara Modal
    $("#prosesAcaraBtn").click(function(){
        var id_acara = $('input[name="id_acara"]:checked').val();
        var nim_list = $('#nim_list').val();
        if (!id_acara) {
            alert("Silakan pilih acara.");
            return;
        }
        // Send data via AJAX
        $.ajax({
            url: 'proses_booking_massal.php',
            type: 'POST',
            data: {id_acara: id_acara, nim_list: nim_list},
            success: function(response) {
                alert(response.message);
                // Reload the page
                location.reload();
            },
            error: function() {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
});
</script>
</body>
</html>
