<?php
session_start();
require_once '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        error_log("Mulai validasi data");
        
        // Check if NIK already exists
        $checkNik = "SELECT id FROM pendaftaran WHERE nik = ?";
        $stmtCheck = $conn->prepare($checkNik);
        $stmtCheck->bind_param("s", $_POST['nik']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("NIK sudah terdaftar dalam sistem");
        }
        
        // Validate date format
        $date = $_POST['tanggal_lahir'];
        if (!preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $date)) {
            throw new Exception("Format tanggal lahir tidak valid");
        }
        
        // Convert date format from DD/MM/YYYY to YYYY-MM-DD for MySQL
        $dateArr = explode('/', $date);
        $mysqlDate = $dateArr[2] . '-' . $dateArr[1] . '-' . $dateArr[0];
        
        // Sanitize inputs
        $jalur_program = filter_input(INPUT_POST, 'jalur_program', FILTER_SANITIZE_STRING);
        $jurusan = filter_input(INPUT_POST, 'jurusan', FILTER_SANITIZE_STRING);
        $nama = filter_input(INPUT_POST, 'firstn', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $tempat_lahir = filter_input(INPUT_POST, 'tempat_lahir', FILTER_SANITIZE_STRING);
        $jenis_kelamin = filter_input(INPUT_POST, 'jenis_kelamin', FILTER_SANITIZE_STRING);
        $ibu_kandung = filter_input(INPUT_POST, 'ibu_kandung', FILTER_SANITIZE_STRING);
        $nik = filter_input(INPUT_POST, 'nik', FILTER_SANITIZE_STRING);
        $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
        $ukuran_baju = filter_input(INPUT_POST, 'ukuran_baju', FILTER_SANITIZE_STRING);
        $bekerja = filter_input(INPUT_POST, 'bekerja', FILTER_SANITIZE_STRING);
        $tempat_kerja = filter_input(INPUT_POST, 'tempat_kerja', FILTER_SANITIZE_STRING);
        $agama = filter_input(INPUT_POST, 'agama', FILTER_SANITIZE_STRING);
        $pertanyaan = filter_input(INPUT_POST, 'pertanyaan', FILTER_SANITIZE_STRING);

        // Validate required fields
        if (!$jalur_program || !$jurusan || !$nama || !$phone || !$nik) {
            throw new Exception("Semua field wajib harus diisi");
        }

        // Validate NIK length
        if (strlen($nik) !== 16) {
            throw new Exception("NIK harus 16 digit");
        }

        $sql = "INSERT INTO pendaftaran (
            jalur_program, jurusan, nama, phone, tempat_lahir,
            tanggal_lahir, jenis_kelamin, ibu_kandung, nik, alamat,
            ukuran_baju, bekerja, tempat_kerja, agama, pertanyaan
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("sssssssssssssss",
            $_POST['jalur_program'],
            $_POST['jurusan'],
            $_POST['firstn'],
            $_POST['phone'],
            $_POST['tempat_lahir'],
            $mysqlDate,
            $_POST['jenis_kelamin'],
            $_POST['ibu_kandung'],
            $_POST['nik'],
            $_POST['alamat'],
            $_POST['ukuran_baju'],
            $_POST['bekerja'],
            $_POST['tempat_kerja'],
            $_POST['agama'],
            $_POST['pertanyaan']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error saving data: " . $stmt->error);
        }

        error_log("Data berhasil disimpan");
        echo "success";

    } catch (Exception $e) {
        error_log("Error in process_pendaftaran: " . $e->getMessage());
        echo json_encode(['error' => $e->getMessage()]);
    } finally {
        if (isset($stmtCheck)) $stmtCheck->close();
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
