<?php
header('Content-Type: text/html; charset=utf-8');
echo "<h1>🛡️ Anti-DDoS Protection Test</h1>";

// Create temporary cookie file
$cookieFile = tempnam(sys_get_temp_dir(), "ANTIDDOS");
chmod($cookieFile, 0600);

echo "<h2>Step 1: Initial Request</h2>";
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
    
    // Step 2: Set the anti-DDoS cookies and retry
    echo "<h2>Step 2: Bypass Anti-DDoS Protection</h2>";
    
    // Create the cookie values
    $ct_headless = urlencode(base64_encode($ct_anti_ddos_key . ':false'));
    $cookie_header = "ct_anti_ddos_key=$ct_anti_ddos_key; ct_headless=$ct_headless";
    echo "<p>Setting cookies: <code>$cookie_header</code></p>";
    
    // Set the cookies and retry
    curl_setopt($ch, CURLOPT_COOKIE, $cookie_header);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: elearning.ut.ac.id',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.5',
        'Connection: keep-alive',
        'Upgrade-Insecure-Requests: 1'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "<p>HTTP Response Code after bypass: <strong>$httpCode</strong></p>";
    
    if ($httpCode == 200) {
        echo "<p style='color:green'>✅ Successfully bypassed anti-DDoS protection!</p>";
    } else {
        echo "<p style='color:red'>❌ Failed to bypass anti-DDoS protection.</p>";
    }
    
    // Save cookies to file
    echo "<p>Cookies stored in: <code>$cookieFile</code></p>";
    $cookies = file_get_contents($cookieFile);
    echo "<pre>" . htmlspecialchars($cookies) . "</pre>";
}
else if ($httpCode == 200) {
    echo "<p style='color:green'>✅ No anti-DDoS protection detected!</p>";
}
else {
    echo "<p style='color:red'>❌ Unexpected response code: $httpCode</p>";
}

// Step 3: Show login page
echo "<h2>Step 3: Access Login Page</h2>";
curl_setopt($ch, CURLOPT_URL, 'https://elearning.ut.ac.id/login/index.php');
$loginResponse = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "<p>Login page HTTP code: <strong>$loginHttpCode</strong></p>";

// Check for login form
if (strpos($loginResponse, '<form class="login-form"') !== false) {
    echo "<p style='color:green'>✅ Login form found!</p>";
    
    // Extract logintoken
    if (preg_match('/<input type="hidden" name="logintoken" value="([^"]+)"/', $loginResponse, $matches)) {
        $loginToken = $matches[1];
        echo "<p style='color:green'>✅ Login token found: <code>$loginToken</code></p>";
    } else {
        echo "<p style='color:red'>❌ Login token not found</p>";
    }
} else {
    echo "<p style='color:red'>❌ Login form not found</p>";
}

curl_close($ch);
?>

<h2>Test Login Form</h2>
<p>Use this form to test login with the extracted values:</p>

<form action="https://elearning.ut.ac.id/login/index.php" method="post" target="_blank">
    <div style="margin-bottom: 10px;">
        <label for="logintoken">Login Token:</label><br>
        <input type="text" id="logintoken" name="logintoken" value="<?= isset($loginToken) ? htmlspecialchars($loginToken) : '' ?>" style="width: 100%;">
    </div>
    
    <div style="margin-bottom: 10px;">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" style="width: 100%;">
    </div>
    
    <div style="margin-bottom: 10px;">
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" style="width: 100%;">
    </div>
    
    <div>
        <input type="submit" value="Test Login" style="padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
    </div>
</form>

<script>
// Auto-extract anti-DDoS cookie from current page (if available)
document.addEventListener('DOMContentLoaded', function() {
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();
        if (cookie.startsWith('ct_anti_ddos_key=')) {
            document.getElementById('ct_anti_ddos_key').value = cookie.substring('ct_anti_ddos_key='.length);
            break;
        }
    }
});
</script>
