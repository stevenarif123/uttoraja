<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

// Add CORS headers for local development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

// Verify database connection first
require_once "../../koneksi.php";

if (!isset($koneksi)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed'
    ]);
    exit();
}

// Log incoming request
error_log("Received POST request: " . print_r($_POST, true));

// Define debugLog function once at the top
function debugLog($message, $data = null, $isError = false) {
    $debug_file = 'debug_log_' . date('Y-m-d') . '.txt';
    $timestamp = date('Y-m-d H:i:s');
    $log = "[{$timestamp}] {$message}\n";
    
    if($isError) {
        $log .= "ERROR: ";
    }
    
    if ($data !== null) {
        if(is_array($data) || is_object($data)) {
            $log .= print_r($data, true);
        } else {
            $log .= $data;
        }
    }
    
    $log .= "\n\n";
    file_put_contents($debug_file, $log, FILE_APPEND);
}

// Add cookie cleanup function after debugLog definition
function cleanupCookies() {
    // 🧹 Clean any existing cookie files in temp directory
    $tempFiles = glob(sys_get_temp_dir() . '/cookie*');
    foreach($tempFiles as $file) {
        if(is_file($file) && strpos($file, 'cookie') !== false) {
            @unlink($file);
        }
    }
    
    // 🍪 Clear PHP session cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-3600, '/');
        }
    }
}

// Add response helper function
function sendJsonResponse($status, $message, $debug = null) {
    // Clear any previous output
    if (ob_get_length()) ob_clean();
    
    // Set JSON header
    header('Content-Type: application/json; charset=utf-8');
    
    $response = [
        'status' => $status,
        'message' => $message
    ];
    if ($debug !== null && ini_get('display_errors')) {
        $response['debug'] = $debug;
    }
    echo json_encode($response);
    exit();
}

// Nonaktifkan penampilan kesalahan ke output
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

// 🛡️ Enhanced input validation
// Key functionality:
// 1. Input validation
if(isset($_POST['no']) && isset($_POST['nim']) && isset($_POST['email'])) {
    debugLog('Received POST request', $_POST);
    try {
        // 🧹 Cleanup existing cookies first
        cleanupCookies();
        
        // Sanitize and validate inputs
        $no = filter_var($_POST['no'], FILTER_VALIDATE_INT);
        $nim = htmlspecialchars(strip_tags($_POST['nim'])); // 🔄 Updated sanitization
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if(!$no || !$nim || !$email) {
            sendJsonResponse('error', 'Invalid input data');
        }

        // Ambil data mahasiswa dari database
        $sql = "SELECT NamaLengkap, Jurusan, TanggalLahir FROM mahasiswa WHERE No = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        if (!$stmt) {
            sendJsonResponse('error', 'Database query preparation failed', mysqli_error($koneksi));
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
            // Create new cookie file with proper permissions
            $cookie_file = tempnam(sys_get_temp_dir(), 'cookie');
            chmod($cookie_file, 0600);

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
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTPHEADER => [
                    'Host: elearning.ut.ac.id',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.9',
                    'Accept-Encoding: gzip, deflate, br',
                    'Connection: keep-alive',
                    'Cache-Control: max-age=0',
                    'Upgrade-Insecure-Requests: 1'
                ]
            ]);

            // Get initial response 🔄
            $initial_response = curl_exec($ch);
            
            if(curl_errno($ch)) {
                throw new Exception('Curl Error: ' . curl_error($ch));
            }

            // Extract token using simplified pattern and save response
            file_put_contents('initial_response.html', $initial_response);
            
            if(preg_match('/escape\("([a-f0-9]{32})"\)/', $initial_response, $matches)) {
                $anti_ddos_cookie = $matches[1];
                debugLog('Found Token', ['token' => $anti_ddos_cookie]);
            } else {
                throw new Exception('Could not extract security token from response');
            }

            // Set proper cookies for next request
            $date = gmdate('D, d M Y H:i:s T', time() + (180 * 24 * 60 * 60));
            $cookies = [
                'ct_anti_ddos_key=' . $anti_ddos_cookie . '; expires=' . $date . '; path=/; samesite=lax; secure',
                'ct_headless=' . base64_encode($anti_ddos_cookie . ':false') . '; path=/; samesite=lax'
            ];

            // Make the /apput/newuser/ request with proper headers
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/',
                CURLOPT_HTTPHEADER => [
                    'Host: elearning.ut.ac.id',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.9',
                    'Accept-Encoding: gzip, deflate, br',
                    'Connection: keep-alive',
                    'Cookie: ' . implode('; ', $cookies),
                    'Referer: https://elearning.ut.ac.id/',
                    'Upgrade-Insecure-Requests: 1'
                ]
            ]);

            $response = curl_exec($ch);

            // Define standard headers first 🌐
            $standard_headers = [
                'Host: elearning.ut.ac.id',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.9',
                'Accept-Encoding: gzip, deflate, br',
                'Connection: keep-alive',
                'Upgrade-Insecure-Requests: 1'
            ];

            // 🔄 Simplified initial request to get anti-DDoS token
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_COOKIEJAR => $cookie_file,
                CURLOPT_COOKIEFILE => $cookie_file,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_HTTPHEADER => $standard_headers
            ]);

            $initial_response = curl_exec($ch);
            debugLog('Initial Response Status', curl_getinfo($ch, CURLINFO_HTTP_CODE));

            // Extract token with simplified pattern
            if(preg_match('/escape\("([a-f0-9]{32})"\)/', $initial_response, $matches)) {
                $anti_ddos_cookie = $matches[1];
                debugLog('Found Token', ['token' => $anti_ddos_cookie]);
            } else {
                throw new Exception('Could not extract security token from response');
            }

            // Set cookies with proper format
            $date = gmdate('D, d M Y H:i:s T', time() + (180 * 24 * 60 * 60));
            $cookies = [
                'ct_anti_ddos_key=' . $anti_ddos_cookie . '; expires=' . $date . '; path=/; samesite=lax; secure',
                'ct_headless=' . base64_encode($anti_ddos_cookie . ':false') . '; path=/; samesite=lax'
            ];

            // 🌐 Navigate to registration page with token
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/',
                CURLOPT_HTTPHEADER => array_merge($standard_headers, [
                    'Cookie: ' . implode('; ', $cookies),
                    'Referer: https://elearning.ut.ac.id/'
                ])
            ]);

            $response = curl_exec($ch);
            debugLog('Registration Page Status', curl_getinfo($ch, CURLINFO_HTTP_CODE));

            // Extract sesskey for form submission
            if (!preg_match('/<input\s+type=["\']hidden["\']\s+name=["\']sesskey["\']\s+value=["\']([^"\']+)["\']/i', $response, $matches)) {
                throw new Exception('Could not find sesskey in response');
            }
            $sesskey = $matches[1];

            // 📤 Submit registration form
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/act.php',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    'action' => 'newuser',
                    'sesskey' => $sesskey,
                    '_qf__newuseract_form' => '1',
                    'nim_user' => $nim,
                    'dd' => $dd,
                    'mm' => $mm,
                    'yyyy' => $yyyy,
                    'email_user' => $email,
                    'nomor_hp' => '',
                    'submitbutton' => 'KIRIM'
                ]),
                CURLOPT_HTTPHEADER => array_merge($standard_headers, [
                    'Cookie: ' . implode('; ', $cookies),
                    'Origin: https://elearning.ut.ac.id',
                    'Referer: https://elearning.ut.ac.id/apput/newuser/',
                    'Content-Type: application/x-www-form-urlencoded'
                ])
            ]);

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

                // Update the token extraction patterns to include the new format
                $patterns = [
                    // Direct JavaScript assignment pattern
                    '/document\.cookie\s*=\s*["\']ct_anti_ddos_key["\']\s*\+\s*["\']=["\']\s*\+\s*escape\(["\']([a-f0-9]{32})["\']\)/',
                    // HTML escaped pattern
                    '/ct_anti_ddos_key["\'\s]*\+?\s*=\s*escape\(["\']([a-f0-9]{32})["\']\)/',
                    // Direct value in quotes
                    '/["\']((?:[a-f0-9]{32}))["\']\s*\+\s*["\']:["\']\s*\+\s*navigator\.webdriver/',
                    // New pattern from response
                    '/escape\(["\']([a-f0-9]{32})["\']\)/'
                ];

                $anti_ddos_cookie = null;
                foreach($patterns as $pattern) {
                    if(preg_match($pattern, $initial_response, $matches)) {
                        $anti_ddos_cookie = $matches[1];
                        debugLog('Found Token', [
                            'pattern' => $pattern,
                            'token' => $anti_ddos_cookie
                        ]);
                        break;
                    }
                }

                if(!$anti_ddos_cookie) {
                    // If no pattern matched, try direct search for known format
                    if(strpos($initial_response, 'ct_anti_ddos_key') !== false) {
                        preg_match('/[a-f0-9]{32}/', $initial_response, $matches);
                        if(!empty($matches[0])) {
                            $anti_ddos_cookie = $matches[0];
                            debugLog('Found Token (Direct Search)', ['token' => $anti_ddos_cookie]);
                        }
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

                // Add additional headers to mimic browser behavior
                $additional_headers = [
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.9',
                    'Accept-Encoding: gzip, deflate, br',
                    'Connection: keep-alive',
                    'Cookie: ' . implode('; ', $cookies),
                    'Sec-Fetch-Site: none',
                    'Sec-Fetch-Mode: navigate',
                    'Sec-Fetch-User: ?1',
                    'Sec-Fetch-Dest: document',
                    'Sec-Ch-Ua: "Chromium";v="122", "Not(A:Brand";v="24", "Google Chrome";v="122"',
                    'Sec-Ch-Ua-Mobile: ?0',
                    'Sec-Ch-Ua-Platform: "Windows"'
                ];

                // Make request with updated headers for registration page 📝
                curl_setopt_array($ch, [
                    CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/',
                    CURLOPT_HTTPHEADER => array_merge($standard_headers, [
                        'Cookie: ' . implode('; ', $cookies),
                        'Referer: https://elearning.ut.ac.id/'
                    ]),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_ENCODING => 'gzip'
                ]);

                // Execute the request 🚀
                $response = curl_exec($ch);

                // Extract sesskey from response
                if (!preg_match('/<input\s+type=["\']hidden["\']\s+name=["\']sesskey["\']\s+value=["\']([^"\']+)["\']/i', $response, $matches)) {
                    throw new Exception('Could not find sesskey in response');
                }
                
                $sesskey = $matches[1];
                debugLog('Found sesskey', ['sesskey' => $sesskey]);

                // Final POST request with registration data 📤
                curl_setopt_array($ch, [
                    CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/act.php',
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query([
                        'action' => 'newuser',
                        'sesskey' => $sesskey,
                        '_qf__newuseract_form' => '1',
                        'nim_user' => $nim,
                        'dd' => $dd,
                        'mm' => $mm,
                        'yyyy' => $yyyy,
                        'email_user' => $email,
                        'nomor_hp' => '',
                        'submitbutton' => 'KIRIM'
                    ]),
                    CURLOPT_HTTPHEADER => array_merge($standard_headers, [
                        'Cookie: ' . implode('; ', $cookies),
                        'Origin: https://elearning.ut.ac.id',
                        'Referer: https://elearning.ut.ac.id/apput/newuser/',
                        'Content-Type: application/x-www-form-urlencoded'
                    ]),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_FOLLOWLOCATION => true
                ]);

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
                // 🧹 Cleanup on error
                cleanupCookies();
                if(file_exists($cookie_file)) {
                    @unlink($cookie_file);
                }
                sendJsonResponse('error', 'Server error occurred', $e->getMessage());
            }

            // 🧹 Final cleanup
            cleanupCookies();
            if(file_exists($cookie_file)) {
                @unlink($cookie_file);
            }
            
        } else {
            sendJsonResponse('error', 'Data mahasiswa tidak ditemukan');
        }
        
    } catch (Exception $e) {
        debugLog('Error occurred', $e->getMessage());
        // 🧹 Cleanup on error
        cleanupCookies();
        sendJsonResponse('error', 'Error processing request: ' . $e->getMessage(), $e->getMessage());
    }
} else {
    debugLog('Invalid request - missing parameters');
    sendJsonResponse('error', 'Missing required parameters');
}
?>