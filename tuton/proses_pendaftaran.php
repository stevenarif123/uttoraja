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
            CURLOPT_ENCODING => 'gzip',  // 🔄 Handle gzip encoding
            CURLOPT_VERBOSE => true,     // 📝 Enable verbose debugging
            CURLOPT_HTTPHEADER => [
                'Host: elearning.ut.ac.id',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language: en-GB,en;q=0.9',
                'Accept-Encoding: gzip, deflate, br',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1',
                'Cache-Control: no-cache'  // 🚫 Prevent caching
            ]
        ]);

        // Capture verbose output for debugging
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $initial_response = curl_exec($ch);
        
        // Log response headers
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        debugLog('Curl Connection Details', $verboseLog);

        // Extract response headers and body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($initial_response, 0, $header_size);
        $body = substr($initial_response, $header_size);

        // Save raw response for debugging
        file_put_contents('debug_full_response.txt', "Headers:\n$headers\n\nBody:\n$body");

        // Look for anti-DDoS token with exact pattern from debug_response.html
        if(preg_match('/document\.cookie\s*=\s*"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([a-f0-9]{32})"\)/', $body, $matches)) {
            $anti_ddos_cookie = $matches[1];
            debugLog('Found Token (Primary)', ['token' => $anti_ddos_cookie]);
        } else if(preg_match('/escape\("([a-f0-9]{32})"\).*?ct_anti_ddos_key/', $body, $matches)) {
            $anti_ddos_cookie = $matches[1];
            debugLog('Found Token (Secondary)', ['token' => $anti_ddos_cookie]);
        } else {
            debugLog('Token Extraction Failed', [
                'response_length' => strlen($body),
                'response_preview' => substr($body, 0, 500)
            ], true);
            throw new Exception('Could not extract security token');
        }

        // Set proper cookies with all required attributes
        $date = gmdate('D, d M Y H:i:s T', time() + (180 * 24 * 60 * 60));
        $cookies = [
            'ct_anti_ddos_key=' . $anti_ddos_cookie . '; expires=' . $date . '; path=/; samesite=lax; secure',
            'ct_headless=' . base64_encode($anti_ddos_cookie . ':false') . '; path=/; samesite=lax'
        ];

        // Make another request with cookies
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/',
            CURLOPT_HTTPHEADER => array_merge([
                'Cookie: ' . implode('; ', $cookies)
            ], curl_getinfo($ch, CURLINFO_HEADER_OUT))
        ]);

        $response = curl_exec($ch);
        debugLog('Cookie Response', [
            'status' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            'cookies_sent' => $cookies
        ]);

        // 🔍 Debug function for detailed logging
        function debugLog($step, $data, $isError = false) {
            $debug_file = 'debug_log_' . date('Y-m-d') . '.txt';
            $timestamp = date('Y-m-d H:i:s');
            $log = "[{$timestamp}] {$step}\n";
            if($isError) {
                $log .= "ERROR: ";
            }
            $log .= print_r($data, true) . "\n\n";
            file_put_contents($debug_file, $log, FILE_APPEND);
        }

        try {
            debugLog('Starting Process', [
                'NIM' => $nim,
                'Email' => $email
            ]);

            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_COOKIEJAR => $cookie_file,
                CURLOPT_COOKIEFILE => $cookie_file,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => 'gzip, deflate, br',
                CURLOPT_VERBOSE => true,
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

            // Capture curl verbose output
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
            
            $initial_response = curl_exec($ch);
            
            if(curl_errno($ch)) {
                throw new Exception('Curl Error: ' . curl_error($ch));
            }

            // Log verbose output
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            debugLog('Curl Verbose Log', $verboseLog);

            // Save full response for inspection
            file_put_contents('initial_response.html', $initial_response);
            debugLog('Initial Response', substr($initial_response, 0, 1000) . '...');

            // Look for anti-DDoS token in the response
            $patterns = [
                '/escape\("([a-f0-9]{32})"\).*?ct_anti_ddos_key/',
                '/ct_anti_ddos_key.*?escape\("([a-f0-9]{32})"\)/',
                '/document\.cookie\s*=\s*["\']ct_anti_ddos_key["\'].*?escape\("([a-f0-9]{32})"\)/',
                '/"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([a-f0-9]{32})"\)/'
            ];

            $anti_ddos_cookie = null;
            foreach($patterns as $pattern) {
                if(preg_match($pattern, $initial_response, $matches)) {
                    $anti_ddos_cookie = $matches[1];
                    debugLog('Found Token', ['pattern' => $pattern, 'token' => $anti_ddos_cookie]);
                    break;
                }
            }

            if(!$anti_ddos_cookie) {
                throw new Exception('Could not extract anti-DDoS token from response');
            }

            // Set cookies exactly as the page does
            $date = gmdate('D, d M Y H:i:s T', time() + (180 * 24 * 60 * 60));
            $webdriver = 'false'; // Simulate non-headless browser
            
            $cookies = [
                'ct_anti_ddos_key=' . $anti_ddos_cookie . '; expires=' . $date . '; path=/; samesite=lax; secure',
                'ct_headless=' . base64_encode($anti_ddos_cookie . ':' . $webdriver) . '; path=/; samesite=lax'
            ];

            // Make request with cookies
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

            // 🔍 Debug function
            function debugLog($step, $data) {
                $debug_file = 'debug_log_' . date('Y-m-d') . '.txt';
                $timestamp = date('Y-m-d H:i:s');
                $log = "[{$timestamp}] {$step}\n";
                $log .= print_r($data, true) . "\n\n";
                file_put_contents($debug_file, $log, FILE_APPEND);
            }

            // Inside the main logic, after curl initialization
            debugLog('Initial Request Headers', curl_getinfo($ch, CURLINFO_HEADER_OUT));
            debugLog('Initial Response Headers', $initial_response);

            // After getting anti-DDoS cookie
            debugLog('Anti-DDoS Cookie', [
                'extracted_cookie' => $anti_ddos_cookie ?? 'not found',
                'full_cookies' => $cookies
            ]);

            // Before registration request
            debugLog('Registration Request', [
                'headers' => $headers,
                'data' => $data,
                'cookies' => $cookies
            ]);

            // After registration response
            debugLog('Registration Response', [
                'raw_response' => $response,
                'curl_info' => curl_getinfo($ch),
                'curl_error' => curl_error($ch)
            ]);

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
        } catch (Exception $e) {
            debugLog('Exception Caught', $e->getMessage(), true);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    }
}
?>