<?php
require_once '../koneksi.php';
require_once '../koneksi_datadaerah.php'; // Add new connection
session_start();

// Initialize variables for the success and error messages
$showSuccessModal = false;
$showErrorModal = false;

// Check if it's a POST request (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $nama_lengkap  = strtoupper(trim($_POST['firstn']));
    $nomor_hp      = trim($_POST['phone']);
    $tempat_lahir  = strtoupper(trim($_POST['tempat_lahir']));
    $tanggal_lahir = $_POST['tanggal_lahir']; // This comes in YYYY-MM-DD format
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
    
    // New fields from the form
    $kawin         = $_POST['kawin'];
    $domisili      = $_POST['domisili'];
    $kemendagri_code = null;
    $domisili_manual = null;

    // Set the appropriate domicile information
    if ($domisili === 'toraja') {
        // Get the actual kemendagri_code from the selected kelurahan using data_daerah connection
        $getCodeStmt = $conn_daerah->prepare("SELECT kemendagri_code FROM kelurahan_lembang WHERE area_name = ?");
        $selectedKelurahan = $_POST['kelurahan'];
        $getCodeStmt->bind_param("s", $selectedKelurahan);
        $getCodeStmt->execute();
        $result = $getCodeStmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $kemendagri_code = $row['kemendagri_code'];
        } else {
            echo '<div class="alert alert-danger">Kode wilayah tidak ditemukan.</div>';
            exit();
        }
        $getCodeStmt->close();
    } else {
        $domisili_manual = isset($_POST['domisili_manual']) ? strtoupper(trim($_POST['domisili_manual'])) : null;
    }

    // Validasi input tidak boleh kosong
    if (
        empty($nama_lengkap) || empty($nomor_hp) || empty($tempat_lahir) ||
        empty($tanggal_lahir) || empty($ibu_kandung) || empty($nik) ||
        empty($jurusan) || empty($agama) || empty($jenis_kelamin) ||
        empty($alamat) || empty($ukuran_baju) || empty($jalur_program) ||
        empty($bekerja) || empty($kawin) || empty($domisili)
    ) {
        echo '<div class="alert alert-danger">Semua field wajib diisi.</div>';
        exit();
    }

    // Validate domicile information
    if ($domisili === 'toraja' && empty($kemendagri_code)) {
        echo '<div class="alert alert-danger">Data domisili Toraja harus lengkap.</div>';
        exit();
    }

    if ($domisili === 'luar_toraja' && empty($domisili_manual)) {
        echo '<div class="alert alert-danger">Data domisili luar Toraja harus diisi.</div>';
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

    // Remove the DD/MM/YYYY validation since we're using HTML5 date input
    // if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggal_lahir)) {
    //     echo '<div class="alert alert-danger">Format tanggal lahir tidak valid. Gunakan format DD/MM/YYYY.</div>';
    //     exit();
    // }

    // No need to convert the date format since it's already in YYYY-MM-DD
    $tanggal_lahir_db = $tanggal_lahir;

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

    // Prepare and bind with new fields
    try {
        $stmt = $conn->prepare("INSERT INTO pendaftar 
        (nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, ibu_kandung, nik, jurusan, agama, 
        jenis_kelamin, pertanyaan, jalur_program, alamat, ukuran_baju, bekerja, tempat_kerja,
        kawin, domisili, kemendagri_code, domisili_manual) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssssssssssssss",
            $nama_lengkap, $nomor_hp, $tempat_lahir, $tanggal_lahir_db, $ibu_kandung,
            $nik, $jurusan, $agama, $jenis_kelamin, $pertanyaan, $jalur_program,
            $alamat, $ukuran_baju, $bekerja, $tempat_kerja, $kawin, $domisili,
            $kemendagri_code, $domisili_manual
        );

        if ($stmt->execute()) {
            echo "success";
            exit();
        } else {
            throw new Exception("Terjadi kesalahan saat menyimpan data: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        exit();
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
} else {
    echo '<div class="alert alert-danger">Method not allowed</div>';
    exit();
}
?>
