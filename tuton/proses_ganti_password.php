<?php
require_once '../../koneksi.php';

if (isset($_POST['nim']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
    $nim = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $oldPassword = mysqli_real_escape_string($koneksi, $_POST['old_password']);
    $newPassword = mysqli_real_escape_string($koneksi, $_POST['new_password']);

    // Ambil password dari database (opsional, bisa dihapus jika tidak diperlukan)
    $sql = "SELECT Password FROM tuton WHERE NIM = '$nim'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Lakukan proses login dan penggantian password ke elearning
        // Inisialisasi cURL
        $ch = curl_init();

        // File cookie untuk menyimpan session
        $cookieFile = tempnam(sys_get_temp_dir(), 'cookie_');

        // Get initial anti-DDoS page with proper headers 🔒
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Host: elearning.ut.ac.id',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language: en-GB,en;q=0.9',
                'Accept-Encoding: gzip, deflate, br',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1'
            ]
        ]);
        
        $initial_response = curl_exec($ch);
        
        // 🔍 Extract anti-DDoS key with improved pattern
        if(preg_match('/document\.cookie\s*=\s*["\']ct_anti_ddos_key["\'].*?escape\("([a-f0-9]{32})"\)/s', $initial_response, $matches)) {
            $anti_ddos_cookie = $matches[1];
        } else {
            // 📝 Try alternate pattern
            if(preg_match('/"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([a-f0-9]{32})"\)/', $initial_response, $matches)) {
                $anti_ddos_cookie = $matches[1];
            } else {
                echo "❌ Failed to extract security token. Please try again.";
                exit();
            }
        }

        // Set cookies and continue with login process
        $cookies = [
            'ct_anti_ddos_key=' . $anti_ddos_cookie,
            'ct_headless=' . base64_encode($anti_ddos_cookie . ':false')
        ];

        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Content-Type: application/x-www-form-urlencoded',
            'Cookie: ' . implode('; ', $cookies)
        ];

        // Step 1: Mendapatkan halaman login untuk mengambil logintoken
        $loginUrl = 'https://elearning.ut.ac.id/login/index.php';
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Non-aktifkan verifikasi SSL jika diperlukan
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $loginPage = curl_exec($ch);

        // Mengambil logintoken
        if (preg_match('/name="logintoken" value="(.*?)"/', $loginPage, $matches)) {
            $logintoken = $matches[1];
        } else {
            $logintoken = '';
        }

        // Step 2: Melakukan login
        $postFields = [
            'username' => $nim,
            'password' => $oldPassword,
            'logintoken' => $logintoken,
        ];

        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $loginResponse = curl_exec($ch);

        // Update password di database terlebih dahulu
        $sqlUpdate = "UPDATE tuton SET Password = '$newPassword' WHERE NIM = '$nim'";
        if (mysqli_query($koneksi, $sqlUpdate)) {
            $updateMessage = "Password di database berhasil diperbarui untuk NIM $nim.";
        } else {
            $updateMessage = "Gagal mengupdate password di database: " . mysqli_error($koneksi);
        }

        // Enhanced error handling for login 🔍
        if (strpos($loginResponse, 'loginerrors') === false) {
            // Login berhasil

            // Step 3: Mengakses halaman dashboard untuk mendapatkan sesskey
            $dashboardUrl = 'https://elearning.ut.ac.id/my/';
            curl_setopt($ch, CURLOPT_URL, $dashboardUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, [
                'Referer: ' . $loginUrl
            ]));
            curl_setopt($ch, CURLOPT_POST, 0);
            $dashboardPage = curl_exec($ch);

            // Mengambil sesskey
            if (preg_match('/"sesskey":"(.*?)"/', $dashboardPage, $matches)) {
                $sesskey = $matches[1];
            } elseif (preg_match('/name="sesskey" value="(.*?)"/', $dashboardPage, $matches)) {
                $sesskey = $matches[1];
            } else {
                $sesskey = '';
            }

            if ($sesskey != '') {
                // Step 4: Mengirim permintaan ubah password
                $changePasswordUrl = 'https://elearning.ut.ac.id/login/change_password.php';
                curl_setopt($ch, CURLOPT_URL, $changePasswordUrl);
                curl_setopt($ch, CURLOPT_POST, 0);
                $changePasswordPage = curl_exec($ch);

                $postFields = [
                    'id' => 1,
                    'sesskey' => $sesskey,
                    '_qf__login_change_password_form' => 1,
                    'password' => $oldPassword,
                    'newpassword1' => $newPassword,
                    'newpassword2' => $newPassword,
                    'submitbutton' => 'Save changes',
                ];

                curl_setopt($ch, CURLOPT_URL, $changePasswordUrl);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $changePasswordResponse = curl_exec($ch);

                // Enhanced password change verification ✅
                if (strpos($changePasswordResponse, 'Password changed') !== false || 
                    strpos($changePasswordResponse, 'berhasil diubah') !== false ||
                    strpos($changePasswordResponse, 'successfully') !== false) {
                    
                    // Update local database
                    $sqlUpdate = "UPDATE tuton SET Password = ? WHERE NIM = ?";
                    $stmt = mysqli_prepare($koneksi, $sqlUpdate);
                    mysqli_stmt_bind_param($stmt, "ss", $newPassword, $nim);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        echo "✅ Password berhasil diubah di elearning dan database lokal untuk NIM $nim.";
                    } else {
                        echo "⚠️ Password berhasil diubah di elearning tetapi gagal update database: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "❌ Gagal mengubah password di elearning. Mohon coba lagi.";
                }
            } else {
                $changePasswordMessage = "Gagal mengambil sesskey. Tidak dapat mengubah password di elearning.";
            }

        } else {
            // Login gagal
            echo "❌ Login gagal. Periksa kembali NIM dan password lama Anda.";
        }

        // Tutup koneksi cURL
        curl_close($ch);

        // Hapus file cookie sementara
        unlink($cookieFile);

        // Tampilkan pesan akhir
        echo $updateMessage . "<br>" . $changePasswordMessage;

    } else {
        echo "NIM tidak ditemukan di database.";
    }
} else {
    echo "Data tidak lengkap. Pastikan NIM, password lama, dan password baru dikirim.";
}
?>
