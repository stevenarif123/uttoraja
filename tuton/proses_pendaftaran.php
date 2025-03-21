<?php
header('Content-Type: application/json');
require_once "../../koneksi.php";

// Debug and error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log("Processing registration request");

// Add this function before the try block
function checkExistingRegistration($nim, $status_file) {
    if (file_exists($status_file)) {
        $status_data = json_decode(file_get_contents($status_file), true) ?? [];
        return isset($status_data[$nim]);
    }
    return false;
}

try {
    // Validate incoming data 🔍
    if (!isset($_POST['nim']) || !isset($_POST['birthdate']) || !isset($_POST['email'])) {
        throw new Exception('Data tidak lengkap: NIM, Email dan Tanggal Lahir wajib diisi');
    }

    // Sanitize inputs 🧹
    $nim = filter_var($_POST['nim'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST['phone']) ? filter_var($_POST['phone'], FILTER_SANITIZE_STRING) : '';

    // Parse birthdate
    $date = new DateTime($_POST['birthdate']);
    $dd = $date->format('d');
    $mm = $date->format('m');
    $yyyy = $date->format('Y');

    // Add this after input validation
    $storage_path = __DIR__ . '/storage';
    $status_file = $storage_path . '/registration_status.json';

    // Check for existing registration first
    if (checkExistingRegistration($nim, $status_file)) {
        throw new Exception('NIM ini sudah diaktifasi atau dalam proses konfirmasi.');
    }

    // Create temporary cookie file
    $cookie_file = tempnam(sys_get_temp_dir(), 'cookie');
    chmod($cookie_file, 0600);

    // Initialize CURL
    $ch = curl_init();

    // Step 1: Initial request to get anti-DDoS token 🔑
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://elearning.ut.ac.id/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_COOKIEJAR => $cookie_file,
        CURLOPT_COOKIEFILE => $cookie_file,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_HTTPHEADER => [
            'Host: elearning.ut.ac.id',
            'Cache-Control: max-age=0',
            'Sec-Ch-Ua: "Chromium";v="133", "Not(A:Brand";v="99"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'Sec-Fetch-Site: none',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-User: ?1',
            'Sec-Fetch-Dest: document',
            'Accept-Language: en-GB,en;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive'
        ]
    ]);

    $response = curl_exec($ch);
    
    // Extract anti-DDoS token
    if (!preg_match('/ct_anti_ddos_key.*?escape\("([a-f0-9]{32})"\)/', $response, $matches)) {
        throw new Exception('Could not extract anti-DDoS token');
    }
    $anti_ddos_token = $matches[1];

    // Step 2: Get sesskey from registration page 🔐
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/act.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'sesskey=' . $anti_ddos_token,
        CURLOPT_HTTPHEADER => [
            'Host: elearning.ut.ac.id',
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: https://elearning.ut.ac.id',
            'Referer: https://elearning.ut.ac.id/apput/newuser/',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language: en-GB,en;q=0.9',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
        ]
    ]);

    $response = curl_exec($ch);
    
    // Debug response if needed
    error_log("Registration page response length: " . strlen($response));
    
    // Validate response
    if ($response === false) {
        throw new Exception('Failed to get registration page: ' . curl_error($ch));
    }
    
    // Try multiple patterns for sesskey extraction 🔑
    $sesskey = null;
    $patterns = [
        '/<input.*?name=["|\']sesskey["|\'].*?value=["|\']([a-zA-Z0-9]+)["|\']/',
        '/sesskey=([a-zA-Z0-9]+)/',
        '/name=["\']sesskey["\']\s+value=["\']([^"\']+)["\']/i'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $response, $matches)) {
            $sesskey = $matches[1];
            break;
        }
    }
    
    if (!$sesskey) {
        // Log response for debugging
        error_log("Failed to extract sesskey. Response excerpt: " . substr($response, 0, 500));
        throw new Exception('Tidak dapat mengakses halaman pendaftaran. Silakan coba lagi nanti.');
    }

    // Step 3: Submit registration form 📝
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
            'nomor_hp' => $phone,
            'submitbutton' => 'KIRIM'
        ]),
        CURLOPT_HTTPHEADER => [
            'Host: elearning.ut.ac.id',
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: https://elearning.ut.ac.id',
            'Referer: https://elearning.ut.ac.id/apput/newuser/act.php',
            'Accept-Language: en-GB,en;q=0.9',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
        ]
    ]);

    $response = curl_exec($ch);
    
    // Function to extract error messages from various formats 🔍
    function extractErrorMessage($html) {
        // Error patterns with priorities
        $errorPatterns = [
            // NIM and birthdate mismatch specific pattern 🔍
            'nim_date_mismatch' => [
                'pattern' => '/<div[^>]*(?:id="dd")[^>]*class="[^"]*invalid-feedback[^"]*"[^>]*>.*?NIM[^<]*Tanggal[^<]*Tidak\s+Sesuai[^<]*<\/div>/is',
                'message' => 'NIM dan Tanggal Lahir tidak sesuai dengan data mahasiswa. Mohon periksa kembali.'
            ],
            // Date validation specific pattern
            'date_error' => [
                'pattern' => '/<div[^>]*(?:id="dd"|id="mm"|id="yyyy")[^>]*class="[^"]*invalid-feedback[^"]*"[^>]*>.*?lahir[^<]*<\/div>/is',
                'message' => 'Tanggal lahir tidak sesuai. Mohon periksa kembali tanggal, bulan, dan tahun lahir Anda.'
            ],
            // General feedback pattern
            'general' => [
                'pattern' => '/<div[^>]*class="[^"]*(?:invalid-feedback|form-control-feedback)[^"]*"[^>]*>(.*?)<\/div>/is',
                'useMatch' => true
            ]
        ];

        // Check patterns in priority order
        foreach ($errorPatterns as $type => $config) {
            if (preg_match($config['pattern'], $html, $matches)) {
                if (isset($config['message'])) {
                    return $config['message'];
                }
                if ($config['useMatch'] ?? false) {
                    return strip_tags(trim($matches[1]));
                }
            }
        }
        
        return false;
    }

    // Check response for success/error messages
    if (strpos($response, 'PENGECEKAN EMAIL') !== false) {
        // Define storage path 📁
        $storage_path = __DIR__ . '/storage';
        $status_file = $storage_path . '/registration_status.json';
        
        // Create storage directory if not exists
        if (!file_exists($storage_path)) {
            mkdir($storage_path, 0755, true);
            // Create .htaccess to prevent direct access
            file_put_contents($storage_path . '/.htaccess', "Deny from all");
        }
        
        // Load existing data 📝
        $status_data = [];
        if (file_exists($status_file)) {
            $status_data = json_decode(file_get_contents($status_file), true) ?? [];
        }
        
        // Get file lock for concurrent access 🔒
        $lock_file = fopen($status_file . '.lock', 'w+');
        if (flock($lock_file, LOCK_EX)) {
            try {
                // Update status data
                $status_data[$nim] = [
                    'email' => $email,
                    'status' => 'PENDING',
                    'timestamp' => date('Y-m-d H:i:s'),
                    'phone' => $phone
                ];
                
                // Save updated data
                file_put_contents($status_file, json_encode($status_data, JSON_PRETTY_PRINT));
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Email verifikasi telah dikirim. Silakan cek email Anda termasuk folder Spam/Bulk.'
                ]);
            } finally {
                flock($lock_file, LOCK_UN);
            }
        } else {
            throw new Exception('Sistem sedang sibuk, silakan coba lagi.');
        }
        fclose($lock_file);
        
    } else {
        $error_message = extractErrorMessage($response);
        
        // Enhanced error logging
        error_log("Registration error for NIM: $nim");
        error_log("Response excerpt: " . substr($response, 0, 1000));
        
        if (strpos($response, 'property "id" on null') !== false) {
            throw new Exception('Sistem sedang memproses data. Silakan coba lagi dalam beberapa saat.');
        }

        if (!$error_message) {
            $validation_messages = [
                'sudah diaktifasi' => 'NIM ini sudah diaktifasi atau dalam proses konfirmasi.',
                'tidak ditemukan' => 'NIM tidak ditemukan dalam database mahasiswa aktif.',
                'tidak sesuai' => 'Data yang dimasukkan tidak sesuai dengan database mahasiswa.',
                'NIM dan' => 'NIM dan Tanggal Lahir tidak sesuai dengan data mahasiswa aktif.',
                'gagal' => 'Proses pendaftaran gagal, silakan coba beberapa saat lagi.'
            ];

            foreach ($validation_messages as $key => $msg) {
                if (stripos($response, $key) !== false) {
                    $error_message = $msg;
                    break;
                }
            }
        }

        if (!$error_message) {
            $error_message = 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi dalam beberapa menit.';
        }

        throw new Exception($error_message);
    }

    curl_close($ch);
    @unlink($cookie_file); // Cleanup

} catch (Exception $e) {
    error_log("Error in proses_pendaftaran.php: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
