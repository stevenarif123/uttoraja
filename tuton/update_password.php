<?php
// Set proper headers to handle AJAX requests and prevent caching
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');

// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/password_errors.log');

// Import database connection
require_once "../../koneksi.php";

// Log the received request for debugging
error_log("📝 PASSWORD UPDATE: Received request with data: " . print_r($_POST, true));

// Initialize response array
$response = [
    'success' => false,
    'message' => 'No action was performed. 🤷‍♂️'
];

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $nim = isset($_POST['nim']) ? trim($_POST['nim']) : '';
    $masa = isset($_POST['masa']) ? trim($_POST['masa']) : '';
    $old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    error_log("🔑 Processing password change: NIM=$nim, Masa=$masa");

    // Validate required fields
    if (empty($nim) || empty($new_password)) {
        $response['message'] = "❌ NIM dan Password baru harus diisi!";
        echo json_encode($response);
        exit;
    }

    try {
        // First, check if the NIM exists in mahasiswa table
        $check_sql = "SELECT NIM, Password FROM mahasiswa WHERE NIM = ?";
        $check_stmt = mysqli_prepare($koneksi, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $nim);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $mahasiswa_data = mysqli_fetch_assoc($check_result);
            $current_password = $mahasiswa_data['Password'];
            
            error_log("🔄 Database check: Current password=" . ($current_password ?: '[empty]'));
            
            // Only verify old password if:
            // 1. Old password is provided 
            // 2. Current password exists in database
            // 3. They don't match
            if (!empty($old_password) && !empty($current_password) && $old_password !== $current_password) {
                $response['message'] = "❌ Password lama tidak cocok dengan data yang tersimpan!";
                echo json_encode($response);
                exit;
            }

            // Begin transaction to ensure data consistency
            mysqli_begin_transaction($koneksi);
            
            // Update password in mahasiswa table
            $update_mahasiswa_sql = "UPDATE mahasiswa SET Password = ?, DiEditPada = NOW() WHERE NIM = ?";
            $update_mahasiswa_stmt = mysqli_prepare($koneksi, $update_mahasiswa_sql);
            mysqli_stmt_bind_param($update_mahasiswa_stmt, "ss", $new_password, $nim);
            $mahasiswa_updated = mysqli_stmt_execute($update_mahasiswa_stmt);
            
            if (!$mahasiswa_updated) {
                error_log("❌ Failed to update mahasiswa table: " . mysqli_error($koneksi));
            }
            
            // Check if NIM exists in tuton table
            $check_tuton_sql = "SELECT NIM FROM tuton WHERE NIM = ?";
            $check_tuton_stmt = mysqli_prepare($koneksi, $check_tuton_sql);
            mysqli_stmt_bind_param($check_tuton_stmt, "s", $nim);
            mysqli_stmt_execute($check_tuton_stmt);
            $check_tuton_result = mysqli_stmt_get_result($check_tuton_stmt);
            
            $tuton_updated = true;
            if (mysqli_num_rows($check_tuton_result) > 0) {
                // Update existing record
                $update_tuton_sql = "UPDATE tuton SET Password = ? WHERE NIM = ?";
                $update_tuton_stmt = mysqli_prepare($koneksi, $update_tuton_sql);
                mysqli_stmt_bind_param($update_tuton_stmt, "ss", $new_password, $nim);
                $tuton_updated = mysqli_stmt_execute($update_tuton_stmt);
                
                if (!$tuton_updated) {
                    error_log("❌ Failed to update tuton table: " . mysqli_error($koneksi));
                }
            } else {
                // Create new record in tuton table
                $insert_tuton_sql = "INSERT INTO tuton (NIM, Password) VALUES (?, ?)";
                $insert_tuton_stmt = mysqli_prepare($koneksi, $insert_tuton_sql);
                mysqli_stmt_bind_param($insert_tuton_stmt, "ss", $nim, $new_password);
                $tuton_updated = mysqli_stmt_execute($insert_tuton_stmt);
                
                if (!$tuton_updated) {
                    error_log("❌ Failed to insert into tuton table: " . mysqli_error($koneksi));
                }
            }
            
            // If both updates succeed, commit transaction
            if ($mahasiswa_updated && $tuton_updated) {
                mysqli_commit($koneksi);
                error_log("✅ Password successfully updated for NIM: $nim");
                
                // Get student name for nicer message
                $name_sql = "SELECT NamaLengkap FROM mahasiswa WHERE NIM = ?";
                $name_stmt = mysqli_prepare($koneksi, $name_sql);
                mysqli_stmt_bind_param($name_stmt, "s", $nim);
                mysqli_stmt_execute($name_stmt);
                $name_result = mysqli_stmt_get_result($name_stmt);
                $student_name = "";
                
                if ($name_row = mysqli_fetch_assoc($name_result)) {
                    $student_name = stripslashes($name_row['NamaLengkap']);
                }
                
                $response = [
                    'success' => true,
                    'message' => "✅ Password berhasil diperbarui! 🎉<br/><br/>" .
                                (!empty($student_name) ? "<strong>Nama:</strong> {$student_name}<br/>" : "") .
                                "<strong>NIM:</strong> {$nim}<br/>" .
                                "<strong>Password baru:</strong> {$new_password}"
                ];
            } else {
                // If something fails, roll back changes
                mysqli_rollback($koneksi);
                $response['message'] = "❌ Gagal memperbarui password. Silakan coba lagi.";
            }
        } else {
            $response['message'] = "❌ NIM tidak ditemukan dalam database!";
            error_log("❌ NIM not found: $nim");
        }
    } catch (Exception $e) {
        // If any exception occurs, roll back transaction
        error_log("🚨 Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        
        if (isset($koneksi) && $koneksi->connect_errno === 0) {
            mysqli_rollback($koneksi);
        }
        
        $response['message'] = "❌ Terjadi kesalahan: " . $e->getMessage();
    }
}

// Output JSON response
echo json_encode($response);
exit;
?>
