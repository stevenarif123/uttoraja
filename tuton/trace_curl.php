<?php
/**
 * 🔍 Diagnostic tool to trace cURL requests and compare against working examples
 * This will help identify any differences between our requests and the sample in 2.txt
 */
header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔍 cURL Trace Comparison Tool</h1>";
echo "<p>This tool compares our requests with the known working example from 2.txt</p>";

// Step 1: Parse the sample request from 2.txt
echo "<h2>Step 1: Analyzing Sample Request</h2>";

$sampleFile = __DIR__ . '/gantipassword/2.txt';
$sampleData = null;

if (file_exists($sampleFile)) {
    $sampleContent = file_get_contents($sampleFile);
    echo "<p style='color:green'>✅ Sample file loaded successfully!</p>";
    
    // Parse headers from sample
    preg_match_all("/-H \\\$'([^']+)'/", $sampleContent, $matches);
    $sampleHeaders = $matches[1];
    
    echo "<h3>Sample Headers:</h3>";
    echo "<pre>";
    print_r($sampleHeaders);
    echo "</pre>";
    
    // Parse URL from sample
    preg_match("/\\\$'([^']+)'\$/", $sampleContent, $urlMatches);
    $sampleUrl = $urlMatches[1] ?? null;
    echo "<p>Target URL: <code>" . htmlspecialchars($sampleUrl ?? 'Not found') . "</code></p>";
    
    // Extract cookies from sample
    preg_match("/-b \\\$'([^']+)'/", $sampleContent, $cookieMatches);
    $sampleCookies = $cookieMatches[1] ?? null;
    if ($sampleCookies) {
        echo "<h3>Sample Cookies:</h3>";
        echo "<pre>" . htmlspecialchars($sampleCookies) . "</pre>";
    }
    
    // Look for the login form in the response
    if (strpos($sampleContent, 'RESPONSE:') !== false) {
        list(, $response) = explode('RESPONSE:', $sampleContent, 2);
        
        echo "<h3>Looking for login token in sample response:</h3>";
        
        if (preg_match('/<input type="hidden" name="logintoken" value="([^"]+)">/', $response, $matches)) {
            $token = $matches[1];
            echo "<p style='color:green; font-weight:bold;'>✅ Found login token: <code>" . htmlspecialchars($token) . "</code></p>";
            echo "<p style='color:green; font-weight:bold;'>✅ HTML pattern: <code>&lt;input type=\"hidden\" name=\"logintoken\" value=\"" . htmlspecialchars($token) . "\"&gt;</code></p>";
        } else {
            echo "<p style='color:red'>❌ Login token not found in sample response</p>";
        }
    }
} else {
    echo "<p style='color:red'>❌ Sample file not found at: " . htmlspecialchars($sampleFile) . "</p>";
}

// Step 2: Test our own request
echo "<h2>Step 2: Testing Our Request</h2>";

$cookieFile = tempnam(sys_get_temp_dir(), "CURL_TRACE");
$ch = curl_init('https://elearning.ut.ac.id/login/index.php');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => [
        'Host: elearning.ut.ac.id',
        'Sec-Ch-Ua: "Chromium";v="133", "Not(A:Brand";v="99"',
        'Sec-Ch-Ua-Mobile: ?0',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Accept-Language: en-GB,en;q=0.9',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7'
    ],
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

echo "<p>HTTP Code: <strong>$httpCode</strong></p>";
echo "<p>Effective URL: <strong>" . htmlspecialchars($effectiveUrl) . "</strong></p>";

// Look for login token
echo "<h3>Looking for login token in our response:</h3>";

$tokenPatterns = [
    // Exact pattern from the example
    '/<input type="hidden" name="logintoken" value="([^"]+)">/',
    // Generic pattern with double quotes
    '/<input[^>]*name="logintoken"[^>]*value="([^"]+)"[^>]*>/',
    // Generic pattern with single quotes
    "/<input[^>]*name='logintoken'[^>]*value='([^']+)'[^>]*>/"
];

$ourToken = null;
foreach ($tokenPatterns as $i => $pattern) {
    if (preg_match($pattern, $response, $matches)) {
        $ourToken = $matches[1];
        echo "<p style='color:green'>✅ Pattern $i found token: <code>" . htmlspecialchars($ourToken) . "</code></p>";
        
        // Show snippet of HTML around the token
        $pos = strpos($response, $matches[0]);
        $start = max(0, $pos - 50);
        $length = strlen($matches[0]) + 100;
        $snippet = substr($response, $start, $length);
        echo "<pre style='background-color:#f8f9fa;padding:10px;overflow:auto;'>" . 
             htmlspecialchars($snippet) . 
             "</pre>";
        break;
    }
}

if (!$ourToken) {
    echo "<p style='color:red'>❌ Login token not found in our response</p>";
    
    // Show first 200 characters of HTML
    echo "<h4>First 200 characters of response:</h4>";
    echo "<pre>" . htmlspecialchars(substr($response, 0, 200)) . "...</pre>";
    
    // Save full response for inspection
    $fullFile = __DIR__ . '/full_response.html';
    file_put_contents($fullFile, $response);
    echo "<p>Full response saved to: <code>" . htmlspecialchars($fullFile) . "</code></p>";
}

// Clean up
curl_close($ch);
@unlink($cookieFile);

// Step 3: Summary comparison
echo "<h2>Step 3: Summary and Recommendations</h2>";

if ($ourToken) {
    echo "<div style='background-color:#d4edda;color:#155724;padding:15px;border-radius:5px;'>";
    echo "<h3>✅ Login Token Extraction Works!</h3>";
    echo "<p>Our code should be able to extract the login token.</p>";
    
    echo "<p>Recommended pattern to use in proses_ganti_password.php:</p>";
    echo "<pre style='background-color:#f8f9fa;padding:10px;'>";
    echo htmlspecialchars('if (preg_match(\'/<input type="hidden" name="logintoken" value="([^"]+)">\/\', $response, $matches)) {
    $logintoken = $matches[1];
    error_log("🎯 Found logintoken with EXACT match: $logintoken");
}');
    echo "</pre>";
    echo "</div>";
} else {
    echo "<div style='background-color:#f8d7da;color:#721c24;padding:15px;border-radius:5px;'>";
    echo "<h3>❌ Login Token Extraction Failed</h3>";
    echo "<p>Check if there are differences in how we're making the HTTP request compared to the sample.</p>";
    
    echo "<p>Potential issues:</p>";
    echo "<ul>";
    echo "<li>Headers might be different</li>";
    echo "<li>Anti-DDoS protection might be active</li>";
    echo "<li>Cookie handling issues</li>";
    echo "<li>The server might be returning a different response format</li>";
    echo "</ul>";
    
    echo "<p>Try using the test_anti_ddos.php script to see if that helps.</p>";
    echo "</div>";
}
?>
