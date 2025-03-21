<?php
/**
 * File untuk mencatat kegagalan perubahan password
 * Memberikan log yang detail untuk debugging
 */

/**
 * Fungsi untuk mencatat kegagalan perubahan password ke file log
 * 
 * @param string $nim NIM mahasiswa
 * @param string $oldPassword Password lama yang digunakan
 * @param string $newPassword Password baru yang dicoba
 * @param string $errorMsg Pesan error yang ditampilkan
 * @param mixed $response Data respons tambahan (opsional)
 */
function logPasswordChangeFailure($nim, $oldPassword, $newPassword, $errorMsg, $response = null) {
    // 📁 Buat direktori logs jika belum ada
    $logDir = __DIR__ . '/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    // 📝 Format nama file log berdasarkan tanggal
    $logFile = $logDir . '/password_change_fails_' . date('Y-m-d') . '.log';
    
    // ⏰ Ambil timestamp untuk log
    $timestamp = date('Y-m-d H:i:s');
    
    // 🔒 Mask password untuk keamanan dengan proper error checking
    $maskedOldPassword = '';
    $maskedNewPassword = '';
    
    if (is_string($oldPassword) && strlen($oldPassword) > 0) {
        $maskedOldPassword = substr($oldPassword, 0, 2) . str_repeat('*', max(strlen($oldPassword) - 4, 0)) . 
                           (strlen($oldPassword) > 3 ? substr($oldPassword, -2) : '');
    } else {
        $maskedOldPassword = '[invalid password]';
    }
    
    if (is_string($newPassword) && strlen($newPassword) > 0) {
        $maskedNewPassword = substr($newPassword, 0, 2) . str_repeat('*', max(strlen($newPassword) - 4, 0)) . 
                           (strlen($newPassword) > 3 ? substr($newPassword, -2) : '');
    } else {
        $maskedNewPassword = '[invalid password]';
    }
    
    // 📄 Buat konten log
    $logContent = "[$timestamp] KEGAGALAN UBAH PASSWORD\n";
    $logContent .= "NIM: $nim\n";
    $logContent .= "Password Lama (masked): $maskedOldPassword\n";
    $logContent .= "Password Baru (masked): $maskedNewPassword\n";
    $logContent .= "Error: $errorMsg\n";
    
    // 🧪 Jika ada data response, tambahkan ke log dengan handling tipe data yang benar
    if ($response !== null) {
        $logContent .= "Response Data:\n";
        
        // 🔍 Handle berbagai tipe data response
        if (is_array($response)) {
            // Jika array, convert ke string dengan json_encode
            $logContent .= json_encode($response, JSON_PRETTY_PRINT) . "\n";
        } elseif (is_object($response)) {
            // Jika object, convert ke string dengan json_encode
            $logContent .= json_encode($response, JSON_PRETTY_PRINT) . "\n";
        } elseif (is_string($response)) {
            // Jika string, hanya ambil 1000 karakter pertama untuk menghindari log terlalu besar
            $logContent .= substr($response, 0, 1000) . (strlen($response) > 1000 ? "... [truncated]" : "") . "\n";
        } else {
            // Jika tipe data lainnya, convert ke string
            $logContent .= "Response (type: " . gettype($response) . "): " . print_r($response, true) . "\n";
        }
    }
    
    $logContent .= "--------------------------------------\n\n";
    
    // 💾 Tulis ke file log
    file_put_contents($logFile, $logContent, FILE_APPEND);
    
    // 📊 Log juga ke error_log untuk debugging
    error_log("🚨 Password change failed for NIM: $nim - Error: $errorMsg");
}

/**
 * Fungsi untuk melihat log kegagalan dalam format HTML
 * Berguna untuk debugging
 */
function viewPasswordChangeFailureLogs() {
    $logDir = __DIR__ . '/logs';
    $logs = [];
    
    // Cek apakah direktori log ada
    if (is_dir($logDir)) {
        // Cari file log kegagalan password
        $files = glob($logDir . '/password_change_fails_*.log');
        
        if (count($files) > 0) {
            // Urutkan file berdasarkan tanggal, terbaru dulu
            rsort($files);
            
            // Tampilkan 5 file log terbaru
            $latestFiles = array_slice($files, 0, 5);
            
            foreach ($latestFiles as $file) {
                // Baca konten file
                $content = file_get_contents($file);
                
                // Parse file name untuk mendapatkan tanggal
                $filename = basename($file);
                preg_match('/password_change_fails_([0-9-]+)\.log/', $filename, $matches);
                $date = isset($matches[1]) ? $matches[1] : 'Unknown date';
                
                // Simpan ke array logs
                $logs[] = [
                    'date' => $date,
                    'content' => $content,
                    'file' => $filename
                ];
            }
        }
    }
    
    return $logs;
}

// 🧪 Jika file ini diakses langsung, tampilkan log kegagalan (tapi hanya jika tidak sedang di-include dari proses_ganti_password.php)
if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__) && (!defined('SUPPRESS_HTML_OUTPUT') || !SUPPRESS_HTML_OUTPUT)) {
    // Set content type untuk HTML
    header('Content-Type: text/html; charset=UTF-8');
    
    echo "<!DOCTYPE html>\n";
    echo "<html lang='id'>\n";
    echo "<head>\n";
    echo "    <meta charset='UTF-8'>\n";
    echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
    echo "    <title>🔒 Log Kegagalan Password</title>\n";
    echo "    <style>\n";
    echo "        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f5f5f5; }\n";
    echo "        h1, h2 { color: #333; }\n";
    echo "        .log-container { margin-bottom: 30px; }\n";
    echo "        .log-date { background-color: #007bff; color: white; padding: 10px; border-radius: 5px 5px 0 0; }\n";
    echo "        .log-content { background-color: #fff; padding: 15px; border-radius: 0 0 5px 5px; white-space: pre-wrap; }\n";
    echo "        .error { color: #dc3545; }\n";
    echo "        .no-logs { background-color: #fff; padding: 15px; border-radius: 5px; color: #6c757d; }\n";
    echo "    </style>\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "    <h1>🔒 Log Kegagalan Perubahan Password</h1>\n";
    
    // Ambil dan tampilkan log
    $logs = viewPasswordChangeFailureLogs();
    
    if (count($logs) > 0) {
        foreach ($logs as $log) {
            echo "    <div class='log-container'>\n";
            echo "        <div class='log-date'>📅 Tanggal: {$log['date']}</div>\n";
            echo "        <pre class='log-content'>" . htmlspecialchars($log['content']) . "</pre>\n";
            echo "    </div>\n";
        }
    } else {
        echo "    <div class='no-logs'>📝 Tidak ada log kegagalan perubahan password.</div>\n";
    }
    
    echo "</body>\n";
    echo "</html>";
}
?>
