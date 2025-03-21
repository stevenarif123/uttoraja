<?php
// Enable detailed error reporting for debugging (but don't display to users in production)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
// Log errors instead
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

// Add PHP version compatibility check for cURL handle types - NEW! 🚀
if (!defined('CURL_HANDLE_TYPE')) {
    define('CURL_HANDLE_TYPE', PHP_VERSION_ID >= 80000 ? 'CurlHandle' : 'resource');
    error_log("🔧 PHP Version: " . PHP_VERSION . " - Using cURL handle type: " . CURL_HANDLE_TYPE);
}

// Set proper content type for AJAX responses
header('Content-Type: application/json');

// 🚫 IMPORTANT: Make sure nothing is output before our JSON response
ob_start(); // Buffer all output

require_once '../../koneksi.php'; // Koneksi ke database

// ⚠️ We need to include this carefully to prevent direct HTML output
// Define a constant to prevent the file from outputting HTML directly
define('SUPPRESS_HTML_OUTPUT', true);
require_once 'gagal_change_password.php';

// Increase timeout limits for long-running operations
set_time_limit(120); // 2 minutes
ini_set('max_execution_time', '120');

// Initialize response array - better structure for AJAX
$responseData = [
    'success' => false,
    'message' => '',
    'debug' => []
];

try {
    // Check if request is POST and has required data
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nim']) && isset($_POST['new_password'])) {
        // Get data from request
        $nim = $_POST['nim'];
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $masa = isset($_POST['masa']) ? $_POST['masa'] : '20242';
        
        // Log request data for debugging
        error_log("🔄 Received request: NIM=$nim, masa=$masa");
        
        // Validate input
        if (empty($nim) || empty($newPassword) || empty($oldPassword)) {
            $responseData['message'] = "❌ Error: NIM, password lama dan password baru harus diisi!";
            sendJsonResponse($responseData);
            exit;
        }
        
        // Check if NIM exists in database for the specified period
        $checkSql = "SELECT Password FROM mahasiswa WHERE NIM = ? AND Masa = ?";
        $checkStmt = mysqli_prepare($koneksi, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "ss", $nim, $masa);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $dbPassword = $row['Password'];

            // Log for debugging
            error_log("🔄 Attempting password change for NIM: $nim with oldPassword: $oldPassword");
            $responseData['debug'][] = "Attempting password change for $nim";
            
            // Update password on elearning.ut.ac.id server using cURL
            $result = changePasswordOnServer($nim, $oldPassword, $newPassword);
            
            if ($result['success']) {
                // Update password in local database
                $updateSql = "UPDATE mahasiswa SET Password = ?, DiEditPada = NOW() WHERE NIM = ? AND Masa = ?";
                $updateStmt = mysqli_prepare($koneksi, $updateSql);
                mysqli_stmt_bind_param($updateStmt, "sss", $newPassword, $nim, $masa);
                $updateResult = mysqli_stmt_execute($updateStmt);
                
                if ($updateResult) {
                    $responseData['success'] = true;
                    $responseData['message'] = "✅ Password berhasil diubah untuk mahasiswa dengan NIM: $nim (Masa: $masa)! 🎉";
                } else {
                    $responseData['success'] = true; // Still success on server
                    $responseData['message'] = "⚠️ Password berhasil diubah di server, tetapi gagal diperbarui di database lokal: " . mysqli_error($koneksi);
                }
            } else {
                // Failed to change password
                $errorMsg = $result['message'];
                if (isset($result['response']) && is_array($result['response'])) {
                    $responseData['debug'] = $result['response']; // Pass debug info
                }
                
                // Log failure for debugging - but don't output HTML
                // Use the modified function that respects SUPPRESS_HTML_OUTPUT
                logPasswordChangeFailure($nim, $oldPassword, $newPassword, $errorMsg, $result['response'] ?? null);
                
                $responseData['message'] = "❌ Gagal mengubah password: " . $errorMsg;
            }
        } else {
            $responseData['message'] = "❌ Mahasiswa dengan NIM $nim untuk masa $masa tidak ditemukan di database!";
        }
    } else {
        $responseData['message'] = "❌ Data tidak lengkap atau metode request tidak valid!";
    }
} catch (Exception $e) {
    // Log the full exception for debugging
    error_log("Password change exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    
    $responseData['message'] = "⚠️ Terjadi kesalahan pada server: " . $e->getMessage();
    $responseData['debug'][] = $e->getTraceAsString();
}

// Always return a valid JSON response and clean any buffer
sendJsonResponse($responseData);
exit;

/**
 * Send JSON response and clean output buffer
 * @param array $data The data to send as JSON
 */
function sendJsonResponse($data) {
    // Clear any output that might have been created
    ob_clean();
    
    // Set proper JSON header again (just to be sure)
    header('Content-Type: application/json');
    
    // Encode and output the data
    echo json_encode($data);
    
    // Flush and end output buffering
    ob_end_flush();
}

/**
 * Fungsi untuk mengubah password di server elearning.ut.ac.id
 * 
 * @param string $username NIM mahasiswa yang akan diubah passwordnya
 * @param string $oldPassword Password lama
 * @param string $newPassword Password baru
 * @return array Array dengan status dan pesan hasil operasi
 */
function changePasswordOnServer($username, $oldPassword, $newPassword) {
    // Create temporary cookie file 🍪
    $cookieFile = tempnam(sys_get_temp_dir(), "CURLCOOKIE");
    chmod($cookieFile, 0600);
    
    // 🔐 Debug start
    error_log("🔄 Starting password change process for: $username");
    
    try {
        // 🌟 Initialize cURL with improved settings
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
        ]);
        
        // 🔥 CRITICAL FIX: First check for anti-DDoS protection
        error_log("🛡️ Checking for anti-DDoS protection...");
        curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Handle anti-DDoS if detected
        if ($httpCode == 403 && strpos($response, 'ct_anti_ddos_key') !== false) {
            error_log("🛡️ Anti-DDoS protection detected! Trying to bypass...");
            
            // Extract anti-DDoS key
            $ct_anti_ddos_key = null;
            if (preg_match('/document\.cookie\s*=\s*"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([^"]+)"\)/', $response, $matches)) {
                $ct_anti_ddos_key = $matches[1];
                error_log("🔑 Extracted anti-DDoS key: $ct_anti_ddos_key");
            } else {
                // Fallback to default key if extraction fails
                $ct_anti_ddos_key = "5eeda57c2163dd4b6fae0cd962d03da7";
                error_log("🔑 Using default anti-DDoS key: $ct_anti_ddos_key");
            }
            
            // Create the cookie values
            $ct_headless = urlencode(base64_encode($ct_anti_ddos_key . ':false'));
            $cookie_header = "ct_anti_ddos_key=$ct_anti_ddos_key; ct_headless=$ct_headless";
            
            curl_setopt($ch, CURLOPT_COOKIE, $cookie_header);
            error_log("🍪 Setting anti-DDoS cookies: $cookie_header");
            
            // Try again with anti-DDoS cookies
            curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/');
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            error_log("🔄 After anti-DDoS bypass - HTTP code: $httpCode");
        }
        
        // 🥠 NOW get the login page and extract token
        curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/login/index.php');
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        error_log("🔄 Login page request - HTTP code: $httpCode");
        
        // Save response for debugging
        $debugFile = sys_get_temp_dir() . '/login_page_' . time() . '.html';
        file_put_contents($debugFile, $response);
        error_log("💾 Saved login page to: $debugFile");
        
        // 🎯 Extract token using the pattern that works in token_fix_test.php
        $logintoken = null;
        
        if (preg_match('/<input type="hidden" name="logintoken" value="([^"]+)">/', $response, $matches)) {
            $logintoken = $matches[1];
            error_log("🎯 Found logintoken with EXACT match: $logintoken");
        } elseif (preg_match('/<input[^>]*name="logintoken"[^>]*value="([^"]+)"[^>]*>/', $response, $matches)) {
            $logintoken = $matches[1];
            error_log("🔍 Found logintoken with alternative pattern: $logintoken");
        } else {
            // Manual search as last resort
            error_log("⚠️ Regex patterns failed. Trying manual search...");
            $formStart = strpos($response, '<form class="login-form"');
            if ($formStart !== false) {
                $formEnd = strpos($response, '</form>', $formStart);
                if ($formEnd !== false) {
                    $formContent = substr($response, $formStart, $formEnd - $formStart);
                    $tokenPos = strpos($formContent, 'name="logintoken"');
                    if ($tokenPos !== false) {
                        $valueStart = strpos($formContent, 'value="', $tokenPos);
                        if ($valueStart !== false) {
                            $valueStart += 7; // Length of 'value="'
                            $valueEnd = strpos($formContent, '"', $valueStart);
                            if ($valueEnd !== false) {
                                $logintoken = substr($formContent, $valueStart, $valueEnd - $valueStart);
                                error_log("📌 Found logintoken with manual search: $logintoken");
                            }
                        }
                    }
                }
            }
        }
        
        if (!$logintoken) {
            error_log("❌ CRITICAL: Could not extract logintoken by any method");
            error_log("🔍 Response contains login form? " . (strpos($response, '<form class="login-form"') !== false ? "Yes" : "No"));
            
            return [
                'success' => false,
                'message' => 'Tidak dapat menemukan token login di halaman. Periksa file log untuk detail.',
                'response' => [
                    'http_code' => $httpCode,
                    'debug_file' => $debugFile
                ]
            ];
        }
        
        error_log("✅ Successfully extracted logintoken: $logintoken");
        
        // 🔑 Step 2: Perform login with proper session handling
        $loginResult = doLogin($ch, $cookieFile, $username, $oldPassword, $logintoken);
        
        if (!$loginResult['success']) {
            curl_close($ch);
            if (file_exists($cookieFile)) {
                unlink($cookieFile);
            }
            return [
                'success' => false,
                'message' => 'Gagal login: ' . $loginResult['message'],
                'response' => $loginResult['response'] ?? null
            ];
        }
        
        // 🏠 Step 3: Access change password page directly
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/login/change_password.php',
            CURLOPT_HTTPGET => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true
        ]);
        
        $pwdPageResponse = curl_exec($ch);
        $pwdPageUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        // Check if we're still logged in (not redirected to login page)
        if (strpos($pwdPageUrl, 'login/index.php') !== false) {
            error_log("🔑 Redirected to login page - session may have expired");
            $debugFile = sys_get_temp_dir() . '/session_expired_' . time() . '.html';
            file_put_contents($debugFile, $pwdPageResponse);
            
            return [
                'success' => false,
                'message' => 'Sesi login habis (Anda dialihkan kembali ke halaman login)',
                'response' => [
                    'debug_file' => $debugFile
                ]
            ];
        }
        
        // 🔍 Extract sesskey with improved direct pattern matching
        $sesskey = null;
        
        // 🎯 DIRECTLY target the specific input field format for sesskey
        if (preg_match('/<input[^>]*name="sesskey"[^>]*value="([^"]+)"[^>]*>/', $pwdPageResponse, $matches)) {
            $sesskey = $matches[1];
            error_log("🔑 Found sesskey directly: $sesskey");
        }
        
        // Fallback methods if needed
        if (!$sesskey && preg_match('/sesskey=([a-zA-Z0-9]+)/i', $pwdPageResponse, $matches)) {
            $sesskey = $matches[1];
            error_log("🔑 Found sesskey from URL parameter: $sesskey");
        }
        
        if (!$sesskey && preg_match('/"sesskey"\s*:\s*"([^"]+)"/', $pwdPageResponse, $matches)) {
            $sesskey = $matches[1];
            error_log("🔑 Found sesskey from JSON data: $sesskey");
        }
        
        if (!$sesskey) {
            $debugFile = sys_get_temp_dir() . '/no_sesskey_' . time() . '.html';
            file_put_contents($debugFile, $pwdPageResponse);
            error_log("💾 Failed to find sesskey. Saved debug to: $debugFile");
            
            return [
                'success' => false,
                'message' => 'Tidak dapat menemukan sesskey di halaman ganti password',
                'response' => [
                    'debug_file' => $debugFile
                ]
            ];
        }
        
        error_log("🔑 Found sesskey for password change: $sesskey");
        
        // 🔄 Step 4: Submit password change form
        $changeResult = doChangePassword($ch, $cookieFile, $sesskey, $oldPassword, $newPassword);
        
        // Cleanup and return result
        curl_close($ch);
        if (file_exists($cookieFile)) {
            unlink($cookieFile);
        }
        
        return $changeResult;
        
    } catch (Exception $e) {
        error_log("🚨 cURL exception: " . $e->getMessage());
        
        // Cleanup resources
        if (isset($ch) && $ch) {
            curl_close($ch);
        }
        if (file_exists($cookieFile)) {
            unlink($cookieFile);
        }
        
        return [
            'success' => false,
            'message' => 'Error pada sistem: ' . $e->getMessage(),
            'response' => ['exception' => $e->getMessage()]
        ];
    }
}

/**
 * Fungsi untuk login ke elearning.ut.ac.id
 * 
 * @param mixed $ch cURL handle (CurlHandle in PHP 8+, resource in PHP <8)
 * @param string $cookieFile File untuk menyimpan cookie
 * @param string $username NIM mahasiswa
 * @param string $password Password
 * @param string $logintoken Token untuk login
 * @return array Array dengan status dan pesan hasil login
 */
function doLogin($ch, $cookieFile, $username, $password, $logintoken) {
    // 🔐 Debug login attempt
    error_log("🔑 LOGIN ATTEMPT - Username: $username, Token: $logintoken");
    
    // 📝 Create post data exactly like test_anti_ddos.php - which works
    $postFields = http_build_query([
        'logintoken' => $logintoken,
        'username' => $username,
        'password' => $password,
        'anchor' => ''
    ]);
    
    error_log("📝 Login post data length: " . strlen($postFields));
    
    // 🚀 Submit login form with properly formatted headers - fixing syntax errors
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://elearning.ut.ac.id/login/index.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HEADER => true,
        CURLOPT_COOKIEJAR => $cookieFile,
        CURLOPT_COOKIEFILE => $cookieFile,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Host: elearning.ut.ac.id',
            'Cache-Control: max-age=0',
            'Upgrade-Insecure-Requests: 1',
            'Origin: https://elearning.ut.ac.id',
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Referer: https://elearning.ut.ac.id/login/index.php',
            'Accept-Language: en-GB,en;q=0.9'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    
    // Debug logging
    error_log("🔄 Login response - HTTP Code: $httpCode, Final URL: $finalUrl");
    
    // Save the response for debugging
    $debugFile = sys_get_temp_dir() . '/login_response_' . time() . '.html';
    file_put_contents($debugFile, $response);
    error_log("💾 Saved login response to: $debugFile");
    
    // 📌 Verify login success - most reliable is checking if redirected to /my/ or dashboard
    $success = false;
    
    // Check for redirect to my/ or dashboard which indicates success
    if (strpos($finalUrl, '/my') !== false || strpos($finalUrl, 'dashboard') !== false) {
        $success = true;
        error_log("✅ Login successful - redirected to dashboard: $finalUrl");
    } 
    // Check for MoodleSession cookie which also indicates success
    else if (preg_match('/Set-Cookie:.*MoodleSession/i', $response)) {
        $success = true;
        error_log("✅ Login successful - MoodleSession cookie present");
        
        // Verify by loading the dashboard/my page to confirm login worked
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/my/',
            CURLOPT_HTTPGET => true,
            CURLOPT_POST => false
        ]);
        $verifyResponse = curl_exec($ch);
        $verifyUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        if (strpos($verifyUrl, '/my') === false && strpos($verifyUrl, 'login/index.php') !== false) {
            $success = false;
            error_log("⚠️ Login appeared successful but session invalid - redirected back to login");
        }
    }
    
    if ($success) {
        return [
            'success' => true,
            'message' => 'Login berhasil',
            'final_url' => $finalUrl
        ];
    }
    
    // Login failed, check for specific error messages
    $errorMsg = 'Login gagal dengan kode HTTP: ' . $httpCode;
    
    // Extract error message
    if (preg_match('/<div[^>]*class="[^"]*loginerror[^"]*"[^>]*>(.*?)<\/div>/is', $response, $matches)) {
        $errorMsg = strip_tags(trim($matches[1]));
        $errorMsg = preg_replace('/\s+/', ' ', $errorMsg);
    } 
    else if (strpos($response, 'Invalid login') !== false) {
        $errorMsg = 'Username atau password salah';
    }
    
    error_log("❌ Login failed: $errorMsg");
    
    // Save response for debugging
    $debugFile = sys_get_temp_dir() . '/login_failed_' . time() . '.html';
    file_put_contents($debugFile, $response);
    
    return [
        'success' => false,
        'message' => $errorMsg,
        'response' => [
            'http_code' => $httpCode,
            'final_url' => $finalUrl,
            'debug_file' => $debugFile
        ]
    ];
}

/**
 * Melakukan permintaan perubahan password
 * 
 * @param mixed $ch cURL handle (CurlHandle in PHP 8+, resource in PHP <8)
 * @param string $cookieFile File cookie
 * @param string $sesskey Session key
 * @param string $oldPassword Password lama
 * @param string $newPassword Password baru
 * @return array Hasil operasi
 */
function doChangePassword($ch, $cookieFile, $sesskey, $oldPassword, $newPassword) {
    // Create post fields EXACTLY matching the change password form
    $postFields = sprintf(
        'id=1&sesskey=%s&_qf__login_change_password_form=1&password=%s&newpassword1=%s&newpassword2=%s&submitbutton=%s',
        $sesskey,
        urlencode($oldPassword),
        urlencode($newPassword),
        urlencode($newPassword),
        urlencode('Save changes')
    );
    
    error_log("🔄 Attempting password change with sesskey: $sesskey");
    
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://elearning.ut.ac.id/login/change_password.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_COOKIEFILE => $cookieFile,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [
            'Host: elearning.ut.ac.id',
            'Content-Type: application/x-www-form-urlencoded',
            'Origin: https://elearning.ut.ac.id',
            'Referer: https://elearning.ut.ac.id/login/change_password.php',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    
    error_log("🔄 Password change HTTP Code: $httpCode, Final URL: $finalUrl");
    
    // Save response for debugging
    $debugFile = sys_get_temp_dir() . '/pwd_change_response_' . time() . '.html';
    file_put_contents($debugFile, $response);
    
    // Check for explicit success indicators
    if (strpos($finalUrl, 'change_password_complete.php') !== false || 
        strpos($finalUrl, 'preferences.php') !== false) {
        error_log("✅ Password change confirmed successful by URL!");
        return [
            'success' => true,
            'message' => '✅ Password berhasil diubah! 🎉',
            'final_url' => $finalUrl
        ];
    }
    
    // Check for success messages in response content
    if (strpos($response, 'Password has been changed') !== false || 
        (strpos($response, 'successfully') !== false && strpos($response, 'password') !== false)) {
        error_log("✅ Password change confirmed successful by text!");
        return [
            'success' => true,
            'message' => '✅ Password berhasil diubah! 🎉',
            'final_url' => $finalUrl
        ];
    }
    
    // Check if we got redirected back to login page (session expired)
    if (strpos($finalUrl, 'login/index.php') !== false) {
        error_log("❌ Session expired during password change");
        return [
            'success' => false,
            'message' => 'Sesi habis saat mencoba mengubah password. Login kembali dan coba lagi.',
            'response' => [
                'http_code' => $httpCode,
                'final_url' => $finalUrl,
                'debug_file' => $debugFile
            ]
        ];
    }
    
    // Check for specific errors
    if (strpos($response, 'current password') !== false && strpos($response, 'incorrect') !== false) {
        error_log("❌ Current password is incorrect");
        return [
            'success' => false,
            'message' => '❌ Password lama tidak sesuai',
            'response' => ['final_url' => $finalUrl, 'debug_file' => $debugFile]
        ];
    }
    
    // For any other outcome, assume failure and provide debug info
    return [
        'success' => false,
        'message' => "❌ Gagal mengubah password. Kode HTTP: $httpCode",
        'response' => [
            'http_code' => $httpCode, 
            'final_url' => $finalUrl,
            'debug_file' => $debugFile
        ]
    ];
}
?>