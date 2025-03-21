<?php
require_once "../../koneksi.php";

// Initialize response array
$response = array(
    'status' => 'error',
    'message' => 'An unknown error occurred.'
);

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    if (isset($_POST['no'])) {
        $no = $_POST['no'];
        
        // Validate no
        if (!empty($no)) {
            // Get mahasiswa data by NO
            $sql_mahasiswa = "SELECT * FROM mahasiswa WHERE No = ?";
            $stmt_mahasiswa = mysqli_prepare($koneksi, $sql_mahasiswa);
            mysqli_stmt_bind_param($stmt_mahasiswa, "i", $no);
            mysqli_stmt_execute($stmt_mahasiswa);
            $result_mahasiswa = mysqli_stmt_get_result($stmt_mahasiswa);
            
            if ($row_mahasiswa = mysqli_fetch_assoc($result_mahasiswa)) {
                $nim = $row_mahasiswa['NIM'];
                $nama = $row_mahasiswa['NamaLengkap'];
                $password = $row_mahasiswa['Password'];
                
                // Check if NIM already exists in tuton table
                $sql_check = "SELECT * FROM tuton WHERE NIM = ?";
                $stmt_check = mysqli_prepare($koneksi, $sql_check);
                mysqli_stmt_bind_param($stmt_check, "s", $nim);
                mysqli_stmt_execute($stmt_check);
                $result_check = mysqli_stmt_get_result($stmt_check);
                
                if (mysqli_num_rows($result_check) > 0) {
                    // Update existing record
                    $sql_update = "UPDATE tuton SET Password = ? WHERE NIM = ?";
                    $stmt_update = mysqli_prepare($koneksi, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "ss", $password, $nim);
                    
                    if (mysqli_stmt_execute($stmt_update)) {
                        $response = array(
                            'status' => 'success',
                            'message' => "Data untuk NIM $nim (". stripslashes($nama) .") berhasil diperbarui dalam tabel tuton! ✅"
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Gagal memperbarui data di tabel tuton. " . mysqli_error($koneksi)
                        );
                    }
                } else {
                    // Insert new record
                    $sql_insert = "INSERT INTO tuton (NIM, Password) VALUES (?, ?)";
                    $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
                    mysqli_stmt_bind_param($stmt_insert, "ss", $nim, $password);
                    
                    if (mysqli_stmt_execute($stmt_insert)) {
                        $response = array(
                            'status' => 'success',
                            'message' => "Data untuk NIM $nim (". stripslashes($nama) .") berhasil dimasukkan ke tabel tuton! ✅"
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Gagal memasukkan data ke tabel tuton. " . mysqli_error($koneksi)
                        );
                    }
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => "Data mahasiswa dengan No $no tidak ditemukan."
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => "Parameter 'no' tidak valid."
            );
        }
    } else {
        $response = array(
            'status' => 'error',
            'message' => "Parameter 'no' tidak ditemukan."
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => "Metode request tidak valid."
    );
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
