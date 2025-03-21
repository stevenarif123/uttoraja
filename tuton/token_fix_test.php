<?php
/**
 * 🧪 Simple test script to validate token extraction with anti-DDoS handling
 * This file isolates just the token extraction part for quick testing
 */
header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔑 Login Token Extraction Test</h1>";

// Create a temporary cookie file
$cookieFile = tempnam(sys_get_temp_dir(), "TOKEN_TEST");
chmod($cookieFile, 0600);

// Initialize cURL
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
]);

// Step 1: Check for anti-DDoS protection
echo "<h2>Step 1: Initial Request & Anti-DDoS Check</h2>";
curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/');
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "<p>HTTP Code: <strong>$httpCode</strong></p>";

// Handle anti-DDoS if detected
if ($httpCode == 403 && strpos($response, 'ct_anti_ddos_key') !== false) {
    echo "<p style='color:orange'>⚠️ Anti-DDoS protection detected!</p>";
    
    // Extract the anti-DDoS key
    $ct_anti_ddos_key = null;
    if (preg_match('/document\.cookie\s*=\s*"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([^"]+)"\)/', $response, $matches)) {
        $ct_anti_ddos_key = $matches[1];
        echo "<p style='color:green'>✅ Extracted anti-DDoS key: <code>$ct_anti_ddos_key</code></p>";
    } else {
        echo "<p style='color:red'>❌ Failed to extract anti-DDoS key</p>";
        $ct_anti_ddos_key = "5eeda57c2163dd4b6fae0cd962d03da7";
        echo "<p style='color:orange'>⚠️ Using default key: <code>$ct_anti_ddos_key</code></p>";
    }
    
    // Create and set the cookie values
    $ct_headless = urlencode(base64_encode($ct_anti_ddos_key . ':false'));
    $cookie_header = "ct_anti_ddos_key=$ct_anti_ddos_key; ct_headless=$ct_headless";
    echo "<p>Setting cookies: <code>$cookie_header</code></p>";
    
    curl_setopt($ch, CURLOPT_COOKIE, $cookie_header);
    
    // Try again with anti-DDoS cookies
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "<p>HTTP Code after bypass: <strong>$httpCode</strong></p>";
}

// Step 2: Access login page to get token
echo "<h2>Step 2: Access Login Page</h2>";
curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/login/index.php');
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

echo "<p>Login page HTTP Code: <strong>$httpCode</strong></p>";
echo "<p>Final URL: <strong>" . htmlspecialchars($finalUrl) . "</strong></p>";

// Step 3: Find logintoken
echo "<h2>Step 3: Extracting Login Token</h2>";

// Try multiple extraction methods
$logintoken = null;

// Method 1: Exact pattern match
if (preg_match('/<input type="hidden" name="logintoken" value="([^"]+)">/', $response, $matches)) {
    $logintoken = $matches[1];
    echo "<p style='color:green'>✅ Method 1 - Exact pattern found token: <code>" . htmlspecialchars($logintoken) . "</code></p>";
}
// Method 2: More flexible pattern
else if (preg_match('/<input[^>]*name="logintoken"[^>]*value="([^"]+)"[^>]*>/', $response, $matches)) {
    $logintoken = $matches[1];
    echo "<p style='color:green'>✅ Method 2 - Flexible pattern found token: <code>" . htmlspecialchars($logintoken) . "</code></p>";
}
// Method 3: Manual string search
else {
    echo "<p style='color:orange'>⚠️ Regular expressions failed, trying manual search...</p>";
    
    // Find the login form
    $formStart = strpos($response, '<form class="login-form"');
    if ($formStart !== false) {
        echo "<p style='color:green'>✅ Found login form at position: $formStart</p>";
        
        $formEnd = strpos($response, '</form>', $formStart);
        if ($formEnd !== false) {
            // Extract form content
            $formContent = substr($response, $formStart, $formEnd - $formStart);
            
            // Search for logintoken within the form
            $tokenStart = strpos($formContent, 'name="logintoken"');
            if ($tokenStart !== false) {
                echo "<p style='color:green'>✅ Found 'name=\"logintoken\"' in form</p>";
                
                $valueStart = strpos($formContent, 'value="', $tokenStart);
                if ($valueStart !== false) {
                    $valueStart += 7; // Length of 'value="'
                    $valueEnd = strpos($formContent, '"', $valueStart);
                    
                    if ($valueEnd !== false) {
                        $logintoken = substr($formContent, $valueStart, $valueEnd - $valueStart);
                        echo "<p style='color:green'>✅ Method 3 - Manual search found token: <code>" . htmlspecialchars($logintoken) . "</code></p>";
                    }
                }
            }
        }
    }
}

if (!$logintoken) {
    echo "<p style='color:red'>❌ Could not extract logintoken by any method!</p>";
    
    // Save response for debugging
    $debugFile = "login_page_debug_" . time() . ".html";
    file_put_contents($debugFile, $response);
    echo "<p>Saved response to: <strong>$debugFile</strong></p>";
    
    echo "<h3>Response headers:</h3>";
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    echo "<pre>" . htmlspecialchars($headers) . "</pre>";
} else {
    echo "<div style='background-color:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-top:20px;'>";
    echo "<h3>✅ Success! Token Extraction Works</h3>";
    echo "<p>The login token was successfully extracted: <code>" . htmlspecialchars($logintoken) . "</code></p>";
    echo "<p>This confirms that the anti-DDoS handling and token extraction approach work properly.</p>";
    echo "</div>";
}

// Clean up
curl_close($ch);
if (file_exists($cookieFile)) {
    unlink($cookieFile);
}
?>

<h2>Recommended Code for proses_ganti_password.php</h2>
<p>Here's the key code section that should be implemented in your proses_ganti_password.php file:</p>

<pre style="background-color:#f8f9fa; padding:15px; border-radius:5px;">
// 1️⃣ First check for anti-DDoS protection
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

// 2️⃣ THEN get the login page and extract token
curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/login/index.php');
$response = curl_exec($ch);

// 3️⃣ Extract login token with exact pattern
if (preg_match('/<input type="hidden" name="logintoken" value="([^"]+)">/', $response, $matches)) {
    $logintoken = $matches[1];
    error_log("🎯 Found logintoken with EXACT match: $logintoken");
}
</pre>

<p>This approach handles the anti-DDoS protection properly before trying to access the login page, which is why it works in your test_anti_ddos.php script.</p>
