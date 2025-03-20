<?php
// Test file to diagnose login issues
header('Content-Type: text/html; charset=utf-8');
echo "<h1>🔐 Login Test Tool</h1>";

// Process form submission
$result = null;
$loginAttempted = false;
$debugInfo = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    echo "<div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>";
    echo "<h3>🔄 Attempting login with:</h3>";
    echo "<p><strong>Username:</strong> " . htmlspecialchars($username) . "</p>";
    echo "<p><strong>Password:</strong> " . (isset($_POST['show_password']) ? htmlspecialchars($password) : '••••••••') . "</p>";
    
    $loginAttempted = true;
    $cookieFile = tempnam(sys_get_temp_dir(), "TESTLOGIN");
    
    try {
        // Step 1: Initial request to get token
        $ch = curl_init('https://elearning.ut.ac.id/login/index.php');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36'
        ]);
        
        $response = curl_exec($ch);
        
        // Get logintoken
        $logintoken = null;
        if (preg_match('/<input.*?name=["|\']logintoken["|\'].*?value=["|\']([^"|\']+)["|\'].*?>/is', $response, $matches)) {
            $logintoken = $matches[1];
            echo "<p style='color:green'>✅ Login token found: " . htmlspecialchars(substr($logintoken, 0, 10)) . "...</p>";
        } else {
            echo "<p style='color:red'>❌ Login token not found</p>";
            throw new Exception("Login token not found");
        }
        
        // Step 2: Login attempt
        $postData = [
            'logintoken' => $logintoken,
            'username' => $username,
            'password' => $password,
            'anchor' => ''
        ];
        
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/login/index.php',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HEADER => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_FOLLOWLOCATION => true
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        echo "<p>HTTP Response Code: <strong>" . $httpCode . "</strong></p>";
        echo "<p>Final URL: <strong>" . htmlspecialchars($finalUrl) . "</strong></p>";
        
        // Check cookies
        $cookies = [];
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
        if (!empty($matches[1])) {
            echo "<p>Cookies received:</p><ul>";
            foreach ($matches[1] as $cookie) {
                echo "<li>" . htmlspecialchars($cookie) . "</li>";
                $cookies[] = $cookie;
            }
            echo "</ul>";
        } else {
            echo "<p style='color:orange'>⚠️ No cookies received</p>";
        }
        
        // Check for login errors
        $error = null;
        if (strpos($response, 'Invalid login') !== false || 
            strpos($response, 'password was incorrect') !== false ||
            strpos($response, 'loginerror') !== false) {
            $error = "Invalid username or password detected";
            echo "<p style='color:red'>❌ Login failed: $error</p>";
            
            if (preg_match('/<div[^>]*class="[^"]*loginerror[^"]*"[^>]*>(.*?)<\/div>/is', $response, $errorMatches)) {
                $errorMsg = strip_tags(trim($errorMatches[1]));
                echo "<p style='color:red'>Error message: " . htmlspecialchars($errorMsg) . "</p>";
            }
        } else if (strpos($finalUrl, 'testsession') !== false || 
                  strpos($finalUrl, 'my') !== false ||
                  strpos($response, 'Log out') !== false) {
            echo "<p style='color:green'>✅ Login successful!</p>";
            
            // Verify by accessing profile page
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/user/profile.php',
                CURLOPT_HTTPGET => true,
                CURLOPT_POST => false
            ]);
            $profileResponse = curl_exec($ch);
            
            if (strpos($profileResponse, 'User profile') !== false) {
                echo "<p style='color:green'>✅ Profile page accessible</p>";
            } else {
                echo "<p style='color:orange'>⚠️ Profile page not accessible</p>";
            }
        } else {
            echo "<p style='color:orange'>⚠️ Login status unclear - no definite success or error indicators found</p>";
        }
        
        // Show raw response header snippet (first 500 chars)
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, min($headerSize, 500));
        echo "<h4>Response Header (first 500 chars):</h4>";
        echo "<pre style='background-color: #f0f0f0; padding: 10px; border-radius: 5px; overflow: auto; max-height: 200px;'>" . 
             htmlspecialchars($header) . 
             ($headerSize > 500 ? "...[truncated]" : "") . 
             "</pre>";
        
        // Save debug info for optional display
        $debugInfo = [
            'request_url' => 'https://elearning.ut.ac.id/login/index.php',
            'post_data' => $postData,
            'http_code' => $httpCode,
            'final_url' => $finalUrl,
            'cookies' => $cookies,
            'header' => $header,
            'full_response' => $response
        ];
        
        curl_close($ch);
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    // Clean up cookie file
    if (file_exists($cookieFile)) {
        unlink($cookieFile);
    }
    
    echo "</div>";
}
?>
<!-- Login test form -->
<form method="post" action="" style="max-width: 400px; margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
    <h2>🔑 Test Login Credentials</h2>
    
    <div style="margin-bottom: 15px;">
        <label for="username" style="display: block; margin-bottom: 5px; font-weight: bold;">Username (NIM):</label>
        <input type="text" name="username" id="username" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" 
               value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Password:</label>
        <input type="password" name="password" id="password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>
            <input type="checkbox" name="show_password" id="show-password"> Show password
        </label>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
            Test Login
        </button>
    </div>
</form>

<?php if ($loginAttempted && $debugInfo): ?>
<!-- Debug information (hidden by default) -->
<div style="margin-top: 30px;">
    <h3>
        <a href="#" onclick="document.getElementById('debug-info').style.display = document.getElementById('debug-info').style.display === 'none' ? 'block' : 'none'; return false;">
            🔍 Show/Hide Raw Debug Information
        </a>
    </h3>
    
    <div id="debug-info" style="display: none;">
        <h4>Full Response (first 5000 chars):</h4>
        <pre style="background-color: #f0f0f0; padding: 10px; border-radius: 5px; overflow: auto; max-height: 500px;"><?= htmlspecialchars(substr($debugInfo['full_response'], 0, 5000)) . (strlen($debugInfo['full_response']) > 5000 ? "...[truncated]" : "") ?></pre>
    </div>
</div>
<?php endif; ?>

<script>
document.getElementById('show-password').addEventListener('change', function() {
    var passwordInput = document.getElementById('password');
    passwordInput.type = this.checked ? 'text' : 'password';
});
</script>
