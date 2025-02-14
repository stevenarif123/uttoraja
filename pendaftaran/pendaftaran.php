<?php
require_once '../koneksi.php';
session_start();

// Initialize variables for the success and error messages
$showSuccessModal = false;
$showErrorModal = false;

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Validate and sanitize input data
    $nama_lengkap  = strtoupper(trim($_POST['firstn']));
    $nomor_hp      = trim($_POST['phone']);
    $tempat_lahir  = strtoupper(trim($_POST['tempat_lahir']));
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $ibu_kandung   = strtoupper(trim($_POST['ibu_kandung']));
    $nik           = trim($_POST['nik']);
    $jurusan       = trim($_POST['jurusan']);
    $agama         = trim($_POST['agama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $pertanyaan    = trim($_POST['pertanyaan']);
    $jalur_program = $_POST['jalur_program'];
    $alamat        = strtoupper(trim($_POST['alamat']));
    $ukuran_baju   = $_POST['ukuran_baju'];
    $bekerja       = $_POST['bekerja'];
    $tempat_kerja  = isset($_POST['tempat_kerja']) ? strtoupper(trim($_POST['tempat_kerja'])) : '';

    // Validasi input tidak boleh kosong
    if (
        empty($nama_lengkap) || empty($nomor_hp) || empty($tempat_lahir) ||
        empty($tanggal_lahir) || empty($ibu_kandung) || empty($nik) ||
        empty($jurusan) || empty($agama) || empty($jenis_kelamin) ||
        empty($alamat) || empty($ukuran_baju) || empty($jalur_program) ||
        empty($bekerja)
    ) {
        echo '<div class="alert alert-danger">Semua field wajib diisi.</div>';
        exit();
    }

    if ($bekerja === 'Ya' && empty($tempat_kerja)) {
        echo '<div class="alert alert-danger">Jika sedang bekerja, tempat kerja wajib diisi.</div>';
        exit();
    }
    
    if (strlen($jalur_program) > 50) {
        echo '<div class="alert alert-danger">Jalur program maksimal 50 karakter.</div>';
        exit();
    }

    if (strlen($ukuran_baju) > 5) {
        echo '<div class="alert alert-danger">Ukuran baju maksimal 5 karakter.</div>';
        exit();
    }

    // Validasi NIK harus 16 digit angka
    if (!preg_match('/^[0-9]{16}$/', $nik)) {
        echo '<div class="alert alert-danger">NIK harus 16 digit angka.</div>';
        exit();
    }

    // Validasi nomor HP harus berupa angka dan panjang 10-20 digit
    if (!preg_match('/^[0-9]{10,20}$/', $nomor_hp)) {
        echo '<div class="alert alert-danger">Nomor HP harus berupa angka dan panjang 10-20 digit.</div>';
        exit();
    }

    // Validasi format tanggal lahir (DD/MM/YYYY)
    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggal_lahir)) {
        echo '<div class="alert alert-danger">Format tanggal lahir tidak valid. Gunakan format DD/MM/YYYY.</div>';
        exit();
    }

    // Ubah format tanggal lahir ke YYYY-MM-DD untuk database
    $tanggal_lahir_db = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal_lahir)));

    // Cek apakah data sudah ada di database
    $checkStmt = $conn->prepare("SELECT * FROM pendaftar WHERE nik = ?");
    $checkStmt->bind_param("s", $nik);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows > 0) {
        echo '<div class="alert alert-danger">NIK sudah terdaftar.</div>';
        exit();
    }
    $checkStmt->close();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO pendaftar 
    (nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, ibu_kandung, nik, jurusan, agama, jenis_kelamin, pertanyaan, jalur_program, alamat, ukuran_baju, bekerja, tempat_kerja) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssssssssssssss",
        $nama_lengkap,
        $nomor_hp,
        $tempat_lahir,
        $tanggal_lahir_db,
        $ibu_kandung,
        $nik,
        $jurusan,
        $agama,
        $jenis_kelamin,
        $pertanyaan,
        $jalur_program,
        $alamat,
        $ukuran_baju,
        $bekerja,
        $tempat_kerja
    );

    if ($stmt->execute()) {
        echo "success";
        exit();
    } else {
        echo '<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data: ' . $stmt->error . '</div>';
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<div class="alert alert-danger">Akses tidak valid.</div>';
    exit();
}
?>
