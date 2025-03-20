<?php
/**
 * 🔍 Simple tool to check if login token extraction works
 * This helps isolate and diagnose token extraction issues
 */
header('Content-Type: text/html; charset=utf-8');
echo "<h1>🔐 Login Token Extraction Test</h1>";

// Create temporary cookie file
$cookieFile = tempnam(sys_get_temp_dir(), "TOKEN_TEST");
chmod($cookieFile, 0600);

echo "<h2>Step 1: Initial Request (with anti-DDoS handling)</h2>";
$ch = curl_init('https://elearning.ut.ac.id/');
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

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "<p>HTTP Response Code: <strong>$httpCode</strong></p>";

// Check for anti-DDoS challenge
$ct_anti_ddos_key = null;
if ($httpCode == 403 && strpos($response, 'ct_anti_ddos_key') !== false) {
    echo "<p style='color:orange'>⚠️ Anti-DDoS protection detected!</p>";
    
    // Extract the anti-DDoS key
    if (preg_match('/document\.cookie\s*=\s*"ct_anti_ddos_key"\s*\+\s*"="\s*\+\s*escape\("([^"]+)"\)/', $response, $matches)) {
        $ct_anti_ddos_key = $matches[1];
        echo "<p style='color:green'>✅ Extracted anti-DDoS key: <code>$ct_anti_ddos_key</code></p>";
    } else {
        echo "<p style='color:red'>❌ Failed to extract anti-DDoS key</p>";
        // Default key from your sample
        $ct_anti_ddos_key = "5eeda57c2163dd4b6fae0cd962d03da7";
        echo "<p style='color:orange'>⚠️ Using default key: <code>$ct_anti_ddos_key</code></p>";
    }
    
    // Set the anti-DDoS cookies and retry
    echo "<h2>Anti-DDoS Bypass Attempt</h2>";
    
    // Create the cookie values
    $ct_headless = urlencode(base64_encode($ct_anti_ddos_key . ':false'));
    $cookie_header = "ct_anti_ddos_key=$ct_anti_ddos_key; ct_headless=$ct_headless";
    echo "<p>Setting cookies: <code>$cookie_header</code></p>";
    
    // Set the cookies and retry
    curl_setopt($ch, CURLOPT_COOKIE, $cookie_header);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "<p>HTTP Response Code after bypass: <strong>$httpCode</strong></p>";
}

// Step 2: Get login page
echo "<h2>Step 2: Access Login Page</h2>";

// Try different methods
echo "<h3>Method A: Direct Access with GET</h3>";
curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/login/index.php');
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Host: elearning.ut.ac.id',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'Accept-Language: en-GB,en;q=0.9',
    'Referer: https://elearning.ut.ac.id/',
    'Connection: keep-alive',
    'Cache-Control: max-age=0',
    'Upgrade-Insecure-Requests: 1'
]);

$responseA = curl_exec($ch);
$httpCodeA = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "<p>Method A - HTTP Code: <strong>$httpCodeA</strong></p>";

// Check for logintoken - Method A
echo "<h4>Looking for logintoken in Method A:</h4>";
$tokenFound = false;

// Different token extraction methods
$tokenPatterns = [
    '/<input type="hidden" name="logintoken" value="([^"]+)">/',
    '/<input[^>]*name="logintoken"[^>]*value="([^"]+)"[^>]*>/',
    "/<input[^>]*name='logintoken'[^>]*value='([^']+)'[^>]*>/"
];

foreach ($tokenPatterns as $i => $pattern) {
    if (preg_match($pattern, $responseA, $matches)) {
        $token = $matches[1];
        echo "<p style='color:green'>✅ Pattern $i found token: <code>" . htmlspecialchars($token) . "</code></p>";
        $tokenFound = true;
        break;
    }
}

// Manual search for token
if (!$tokenFound) {
    echo "<p style='color:orange'>⚠️ Regular expressions didn't find token. Trying manual search...</p>";
    
    // Look for login form
    $formPos = strpos($responseA, '<form class="login-form"');
    if ($formPos !== false) {
        echo "<p style='color:green'>✅ Found login form starting at position: $formPos</p>";
        
        // Now find logintoken within the form section
        $tokenPos = strpos($responseA, 'name="logintoken"', $formPos);
        if ($tokenPos !== false) {
            echo "<p style='color:green'>✅ Found 'name=\"logintoken\"' at position: $tokenPos</p>";
            
            $valueStart = strpos($responseA, 'value="', $tokenPos);
            if ($valueStart !== false) {
                $valueStart += 7; // Length of 'value="'
                $valueEnd = strpos($responseA, '"', $valueStart);
                if ($valueEnd !== false) {
                    $token = substr($responseA, $valueStart, $valueEnd - $valueStart);
                    echo "<p style='color:green'>✅ Manually extracted token: <code>" . htmlspecialchars($token) . "</code></p>";
                    $tokenFound = true;
                }
            }
        } else {
            echo "<p style='color:red'>❌ 'name=\"logintoken\"' not found in form</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Login form not found</p>";
    }
}

// Show form structure if token not found
if (!$tokenFound) {
    echo "<h4>Login Form Content:</h4>";
    // Extract login form
    if (preg_match('/<form[^>]*class="login-form"[^>]*>(.*?)<\/form>/s', $responseA, $formMatches)) {
        echo "<pre>" . htmlspecialchars($formMatches[0]) . "</pre>";
    } else {
        echo "<p style='color:red'>❌ Could not extract login form</p>";
    }
    
    // Save full response for debugging
    $debugFile = __DIR__ . '/login_page_debug.html';
    file_put_contents($debugFile, $responseA);
    echo "<p>Full HTML saved to: <code>" . htmlspecialchars($debugFile) . "</code></p>";
}

// Clean up
curl_close($ch);
@unlink($cookieFile);

echo "<h2>Summary</h2>";
if ($tokenFound) {
    echo "<div style='background-color:#d4edda;color:#155724;padding:15px;border-radius:5px;'>";
    echo "<h3>✅ Login Token Extraction Works!</h3>";
    echo "<p>The anti-DDoS handling and token extraction steps are successful.</p>";
    echo "</div>";
} else {
    echo "<div style='background-color:#f8d7da;color:#721c24;padding:15px;border-radius:5px;'>";
    echo "<h3>❌ Login Token Extraction Failed</h3>";
    echo "<p>Review the debug HTML file to understand why token extraction isn't working.</p>";
    echo "</div>";
}
?>
