<?php
header('Content-Type: text/html; charset=utf-8');
echo "<h1>🔍 Server Connection Test</h1>";

// Test database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    require_once '../../koneksi.php';
    
    if ($koneksi) {
        echo "<p style='color:green'>✅ Database connection successful!</p>";
        
        // Test query
        $result = mysqli_query($koneksi, "SELECT 1");
        if ($result) {
            echo "<p style='color:green'>✅ Database query successful!</p>";
            mysqli_free_result($result);
        } else {
            echo "<p style='color:red'>❌ Database query failed: " . mysqli_error($koneksi) . "</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Database connection failed!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Database error: " . $e->getMessage() . "</p>";
}

// Test elearning.ut.ac.id connectivity
echo "<h2>2. Elearning Server Test</h2>";
try {
    $ch = curl_init('https://elearning.ut.ac.id/');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo "<p style='color:red'>❌ Connection to elearning.ut.ac.id failed: " . curl_error($ch) . "</p>";
    } else {
        echo "<p style='color:green'>✅ Connection to elearning.ut.ac.id successful! HTTP code: $httpCode</p>";
        
        // Check for anti-DDoS protection
        if ($httpCode == 403 && strpos($response, 'ct_anti_ddos_key') !== false) {
            echo "<p style='color:orange'>⚠️ Anti-DDoS protection detected</p>";
        }
        
        // Check if we can extract login form
        if (preg_match('/<form.*?id=["|\']login["|\'].*?>/is', $response)) {
            echo "<p style='color:green'>✅ Login form detected!</p>";
            
            // Check for logintoken
            if (preg_match('/<input.*?name=["|\']logintoken["|\'].*?value=["|\']([^"|\']+)["|\'].*?>/is', $response, $matches)) {
                echo "<p style='color:green'>✅ Login token found: " . substr($matches[1], 0, 5) . "...</p>";
            } else {
                echo "<p style='color:red'>❌ Login token not found</p>";
            }
        } else {
            echo "<p style='color:red'>❌ Login form not detected</p>";
        }
    }
    curl_close($ch);
} catch (Exception $e) {
    echo "<p style='color:red'>❌ cURL error: " . $e->getMessage() . "</p>";
}

// Test PHP settings
echo "<h2>3. PHP Configuration</h2>";
echo "<p>PHP version: " . phpversion() . "</p>";
echo "<p>max_execution_time: " . ini_get('max_execution_time') . "</p>";
echo "<p>memory_limit: " . ini_get('memory_limit') . "</p>";
echo "<p>allow_url_fopen: " . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . "</p>";
echo "<p>file_uploads: " . (ini_get('file_uploads') ? 'Yes' : 'No') . "</p>";
echo "<p>Default timeout: " . ini_get('default_socket_timeout') . "</p>";

// Test temp directory
echo "<h2>4. Temporary Directory Test</h2>";
$tempFile = tempnam(sys_get_temp_dir(), "TEST");
if ($tempFile !== false) {
    echo "<p style='color:green'>✅ Temporary file created: $tempFile</p>";
    if (file_put_contents($tempFile, "Test data")) {
        echo "<p style='color:green'>✅ Writing to temporary file successful</p>";
    } else {
        echo "<p style='color:red'>❌ Could not write to temporary file</p>";
    }
    
    if (unlink($tempFile)) {
        echo "<p style='color:green'>✅ Temporary file deleted successfully</p>";
    } else {
        echo "<p style='color:red'>❌ Could not delete temporary file</p>";
    }
} else {
    echo "<p style='color:red'>❌ Could not create temporary file</p>";
}

echo "<h2>5. System Information</h2>";
echo "<p>Server software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>OS: " . PHP_OS . "</p>";
echo "<p>SAPI: " . php_sapi_name() . "</p>";

// Test if CURL extension is installed
echo "<h2>6. PHP Extensions</h2>";
echo "<p>CURL: " . (function_exists('curl_version') ? 'Installed ✅' : 'Not installed ❌') . "</p>";
if (function_exists('curl_version')) {
    $curlInfo = curl_version();
    echo "<p>CURL version: " . $curlInfo['version'] . "</p>";
    echo "<p>SSL version: " . $curlInfo['ssl_version'] . "</p>";
}
echo "<p>JSON: " . (function_exists('json_encode') ? 'Installed ✅' : 'Not installed ❌') . "</p>";
echo "<p>DOM: " . (class_exists('DOMDocument') ? 'Installed ✅' : 'Not installed ❌') . "</p>";
?>
