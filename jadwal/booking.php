<?php
// booking.php
session_start();
if (!isset($_SESSION['nim'])) {
    header('Location: index.php');
    exit();
}

include 'koneksi.php';

// Ambil data acara
$acara = $conn->query("SELECT * FROM acara");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Acara</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1 class="mt-5">Pilih Acara untuk Booking</h1>
    <form id="bookingForm">
        <?php while($row = $acara->fetch_assoc()): ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="id_acara" id="acara<?php echo $row['id_acara']; ?>" value="<?php echo $row['id_acara']; ?>" required>
              <label class="form-check-label" for="acara<?php echo $row['id_acara']; ?>">
                <?php echo $row['nama_acara']; ?> - <?php echo date('d-m-Y', strtotime($row['tanggal_acara'])); ?> (Maksimal: <?php echo $row['max_booking']; ?>)
              </label>
            </div>
        <?php endwhile; ?>
        <button type="button" id="lanjutkanBtn" class="btn btn-primary mt-3">Lanjutkan</button>
    </form>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="konfirmasiForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Booking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin booking acara berikut?</p>
          <p id="acaraDetail"><strong></strong></p>
          <input type="hidden" name="id_acara" id="id_acara_selected">
        </div>
        <div class="modal-footer">
          <button type="button" id="bookingBtn" class="btn btn-success">Ya, Booking</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Hasil -->
<div class="modal fade" id="hasilModal" tabindex="-1" role="dialog" aria-labelledby="hasilModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="hasilModalLabel">Informasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="hasilPesan"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$('#lanjutkanBtn').click(function() {
    var id_acara = $('input[name="id_acara"]:checked').val();
    if (!id_acara) {
        alert('Silakan pilih acara terlebih dahulu.');
        return;
    }
    var acaraText = $('label[for="acara' + id_acara + '"]').text();
    $('#acaraDetail strong').text(acaraText);
    $('#id_acara_selected').val(id_acara);
    $('#konfirmasiModal').modal('show');
});

$('#bookingBtn').click(function() {
    var id_acara = $('#id_acara_selected').val();
    $.ajax({
        url: 'proses_booking_ajax.php',
        type: 'POST',
        data: {id_acara: id_acara},
        success: function(response) {
            $('#konfirmasiModal').modal('hide');
            $('#hasilPesan').text(response.message);
            $('#hasilModal').modal('show');
        },
        error: function() {
            $('#konfirmasiModal').modal('hide');
            $('#hasilPesan').text('Terjadi kesalahan. Silakan coba lagi.');
            $('#hasilModal').modal('show');
        }
    });
});
</script>
</body>
</html>
