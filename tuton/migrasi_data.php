<?php
// 🔒 Security headers
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once "../../koneksi.php";

// 🛡️ Enhanced input validation
if(isset($_POST['no'])) {
    $no = filter_var($_POST['no'], FILTER_VALIDATE_INT);
    
    if(!$no) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit();
    }

    try {
        // 🔄 Transaction for data consistency
        mysqli_begin_transaction($koneksi);

        // Mengambil data mahasiswa dari database
        $sql = "SELECT * FROM mahasiswa WHERE No = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "i", $no);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $mahasiswa = mysqli_fetch_assoc($result);

        if($mahasiswa) {
            $nim = $mahasiswa['NIM'];
            $nama = $mahasiswa['NamaLengkap'];
            $jurusan = $mahasiswa['Jurusan'];
            $email = $mahasiswa['Email'];
            $password = $mahasiswa['Password']; // Atau isi sesuai kebutuhan

            // 🎯 Enhanced duplicate checking
            $sql_check = "SELECT COUNT(*) as count FROM tuton WHERE NIM = ?";
            $stmt_check = mysqli_prepare($koneksi, $sql_check);
            mysqli_stmt_bind_param($stmt_check, "s", $nim);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            $count = mysqli_fetch_assoc($result_check)['count'];

            if($count == 0) {
                // 📝 Insert with error handling
                $sql_insert = "INSERT INTO tuton (NIM, Nama, Jurusan, Email, Password) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
                
                if(!$stmt_insert) {
                    throw new Exception("Database preparation failed");
                }

                mysqli_stmt_bind_param($stmt_insert, "sssss", $nim, $nama, $jurusan, $email, $password);
                
                if(!mysqli_stmt_execute($stmt_insert)) {
                    throw new Exception("Insert failed");
                }

                mysqli_commit($koneksi);
                echo json_encode(['status' => 'success', 'message' => 'Data migration successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data already exists']);
            }

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Mahasiswa tidak ditemukan.']);
        }

    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        error_log("Migration error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Migration failed']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
}
?>
