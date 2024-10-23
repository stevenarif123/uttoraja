<?php
include '../koneksi.php'; // Include the database connection file

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Validate and sanitize input data
    $nama_lengkap = strtoupper(trim($_POST['firstn']));
    $nomor_hp = trim($_POST['phone']);
    $tempat_lahir = strtoupper(trim($_POST['tempat_lahir']));
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $ibu_kandung = strtoupper(trim($_POST['ibu_kandung']));
    $nik = trim($_POST['nik']);
    $jurusan = trim($_POST['jurusan']);
    $agama = trim($_POST['agama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pertanyaan = trim($_POST['pertanyaan']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO pendaftar (nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, ibu_kandung, nik, jurusan, agama, jenis_kelamin, pertanyaan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nama_lengkap, $nomor_hp, $tempat_lahir, $tanggal_lahir, $ibu_kandung, $nik, $jurusan, $agama, $jenis_kelamin, $pertanyaan);

    // Execute the statement
    if ($stmt->execute()) {
        // Success modal
        echo '<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Pendaftaran Berhasil!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Data pendaftaran berhasil disimpan.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="index.php" class="btn btn-primary">OK</a>
                        </div>
                    </div>
                </div>
              </div>
              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                      var successModal = new bootstrap.Modal(document.getElementById("successModal"));
                      successModal.show();
                  });
              </script>';
    } else {
        // Error modal
        echo '<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Pendaftaran Gagal!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Terjadi kesalahan saat menyimpan data pendaftaran.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
              </div>
              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                      var errorModal = new bootstrap.Modal(document.getElementById("errorModal"));
                      errorModal.show();
                  });
              </script>';
    }

    // Close statement
    $stmt->close();
}
// Close connection
$conn->close();
?>


// Perintah SQL untuk membuat tabel pendaftar:
/*
CREATE TABLE pendaftar (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    ibu_kandung VARCHAR(255) NOT NULL,
    nik VARCHAR(50) NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    agama VARCHAR(50) NOT NULL,
    jenis_kelamin VARCHAR(10) NOT NULL,
    pertanyaan TEXT
);
*/
// Tutup koneksi