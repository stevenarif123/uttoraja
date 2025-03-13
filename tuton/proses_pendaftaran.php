<?php
// Nonaktifkan penampilan kesalahan ke output
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Atur header untuk JSON
header('Content-Type: application/json');

// 🔒 Enhanced security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Mulai output buffering
ob_start();

require_once "../../koneksi.php";

// 🛡️ Enhanced input validation
// Key functionality:
// 1. Input validation
if(isset($_POST['no']) && isset($_POST['nim']) && isset($_POST['email'])) {
    // Sanitize and validate inputs
    $no = filter_var($_POST['no'], FILTER_VALIDATE_INT);
    $nim = filter_input(INPUT_POST, 'nim', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if(!$no || !$nim || !$email) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
        exit();
    }

    // Ambil data mahasiswa dari database
    $sql = "SELECT NamaLengkap, Jurusan, TanggalLahir FROM mahasiswa WHERE No = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan pernyataan SQL.']);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $no);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $mahasiswa = mysqli_fetch_assoc($result);

    if($mahasiswa) {
        $nama = $mahasiswa['NamaLengkap'];
        $jurusan = $mahasiswa['Jurusan'];
        $tanggal_lahir = $mahasiswa['TanggalLahir'];
        $dd = date('d', strtotime($tanggal_lahir));
        $mm = date('m', strtotime($tanggal_lahir));
        $yyyy = date('Y', strtotime($tanggal_lahir));

        // Langkah 1: Permintaan GET untuk mendapatkan sesskey dan cookies
        $cookie_file = tempnam(sys_get_temp_dir(), 'cookie');

        // Initialize cURL with proper headers first 🔒
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cookie_file,
            CURLOPT_COOKIEFILE => $cookie_file,
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
        
        // 🔍 Extract the anti-DDoS key from script tag
        if(preg_match('/document\.cookie\s*=\s*["\']ct_anti_ddos_key["\'].*?escape\("([a-f0-9]{32})"\)/s', $initial_response, $matches)) {
            $anti_ddos_cookie = $matches[1];
        } else {
            // 📝 Try alternate pattern from direct cookie assignment
            if(preg_match('/"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([a-f0-9]{32})"\)/', $initial_response, $matches)) {
                $anti_ddos_cookie = $matches[1];
            } else {
                error_log("Failed to extract anti-DDoS key from response");
                error_log("Response: " . $initial_response);
                echo json_encode(['status' => 'error', 'message' => 'Could not extract security token']);
                exit();
            }
        }

        // Set the cookie and make the request 🍪
        $cookies = [
            'ct_anti_ddos_key=' . $anti_ddos_cookie,
            'ct_headless=' . base64_encode($anti_ddos_cookie . ':false')
        ];

        // Simulate clicking the button by making a request with the cookie 🖱️
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'Cookie: ' . implode('; ', $cookies)
        ], curl_getinfo($ch, CURLINFO_HEADER_OUT)));

        // Now make the request to the actual registration page
        curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/apput/newuser/');
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = 'Error during GET request: ' . curl_error($ch);
            error_log($error_msg);
            echo json_encode(['status' => 'error', 'message' => $error_msg]);
            exit();
        }

        // Simpan respon GET untuk debugging
        file_put_contents('get_response_debug.html', $response);

        // Langkah 2: Ekstrak sesskey menggunakan regex
        $sesskey = '';
        if (preg_match('/<input\s+type=["\']hidden["\']\s+name=["\']sesskey["\']\s+value=["\']([^"\']+)["\']/i', $response, $matches)) {
            $sesskey = $matches[1];
        } else {
            $error_msg = 'Tidak dapat menemukan sesskey.';
            error_log($error_msg);
            echo json_encode(['status' => 'error', 'message' => $error_msg]);
            exit();
        }

        // Langkah 3: Permintaan POST dengan data dan header lengkap
        $data = [
            'action' => 'newuser',
            'sesskey' => $sesskey,
            '_qf__newuseract_form' => '1',
            'nim_user' => $nim,
            'dd' => $dd,
            'mm' => $mm,
            'yyyy' => $yyyy,
            'email_user' => $email,
            'nomor_hp' => '', // Nomor HP dihapus atau dikosongkan
            'submitbutton' => 'KIRIM'
        ];

        $headers = [
            'Host: elearning.ut.ac.id',
            'Origin: https://elearning.ut.ac.id',
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
            'Referer: https://elearning.ut.ac.id/apput/newuser/',
            'Accept-Encoding: gzip, deflate, br',
        ];

        curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/apput/newuser/act.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = 'Error during POST request: ' . curl_error($ch);
            error_log($error_msg);
            echo json_encode(['status' => 'error', 'message' => $error_msg]);
            exit();
        } else {
            // Simpan respon POST untuk debugging
            file_put_contents('post_response_debug.html', $response);

            // Check for email verification message first
            if (strpos($response, 'PENGECEKAN EMAIL') !== false || 
                strpos($response, 'email sedang dikirimkan') !== false) {
                
                // Extract password if available
                $password = 'Tidak diketahui';
                if (preg_match('/Password(?:\s*Anda\s*adalah)?:\s*([^\s<]+)/i', $response, $pw_matches)) {
                    $password = htmlspecialchars(trim($pw_matches[1]), ENT_QUOTES, 'UTF-8');
                }

                // Save to tuton table regardless of password status
                $sql_insert = "INSERT INTO tuton (NIM, Nama, Jurusan, Email, Password) VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
                if (!$stmt_insert) {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyiapkan pernyataan SQL untuk insert tuton.']);
                    exit();
                }

                mysqli_stmt_bind_param($stmt_insert, "sssss", $nim, $nama, $jurusan, $email, $password);
                
                if (mysqli_stmt_execute($stmt_insert)) {
                    // Return success with email verification message
                    echo json_encode([
                        'status' => 'success', 
                        'message' => 'Pendaftaran berhasil. Silahkan cek email Anda untuk verifikasi. ' . 
                                   'Jika email tidak ditemukan, periksa folder spam/bulk.'
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke tabel tuton.']);
                }

                error_log("Successfully registered user: $nim");
            } else {
                // Look for error messages if not success
                $error_message = 'Tidak diketahui.';
                if (preg_match('/<div\s+class=["\']error["\']>(.*?)<\/div>/is', $response, $error_matches)) {
                    $error_message = strip_tags(trim($error_matches[1]));
                } elseif (preg_match('/<div\s+class=["\']alert\s+alert-danger["\']>(.*?)<\/div>/is', $response, $error_matches)) {
                    $error_message = strip_tags(trim($error_matches[1]));
                }

                echo json_encode(['status' => 'error', 'message' => "Pendaftaran gagal. Pesan error: $error_message"]);
            }
        }

        // 🧹 Cleanup
        curl_close($ch);
        if(file_exists($cookie_file)) {
            unlink($cookie_file);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    }
}
?>