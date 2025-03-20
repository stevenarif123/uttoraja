<?php
header('Content-Type: text/html; charset=utf-8');
echo "<h1>🔍 Session Debugging Tool</h1>";

echo "<h2>1. Testing Direct Access</h2>";
$cookieFile = tempnam(sys_get_temp_dir(), "DEBUG_COOKIE");
chmod($cookieFile, 0600);

try {
    // Step 1: Access login page
    echo "<h3>1.1 Accessing Login Page</h3>";
    $ch = curl_init('https://elearning.ut.ac.id/login/index.php');
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
    
    echo "<p>Login page HTTP code: <strong>$httpCode</strong></p>";
    
    // Extract logintoken
    $logintoken = null;
    if (preg_match('/<input[^>]*name=(["\'])logintoken\\1[^>]*value=(["\'])([^"\']+)\\2/i', $response, $matches)) {
        $logintoken = $matches[3];
        echo "<p style='color:green'>✅ Found logintoken: " . substr($logintoken, 0, 10) . "...</p>";
    } else {
        echo "<p style='color:red'>❌ Logintoken not found</p>";
        die("Cannot continue without logintoken");
    }
    
    // Step 2: Login with credentials (if provided)
    if (isset($_POST['username']) && isset($_POST['password'])) {
        echo "<h3>1.2 Attempting Login</h3>";
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        echo "<p>Username: $username</p>";
        echo "<p>Password: ******</p>";
        echo "<p>Logintoken: $logintoken</p>";
        
        $postData = http_build_query([
            'logintoken' => $logintoken,
            'username' => $username,
            'password' => $password,
            'anchor' => ''
        ]);
        
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/login/index.php',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HEADER => true,
            CURLOPT_COOKIEJAR => $cookieFile,
            CURLOPT_COOKIEFILE => $cookieFile,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                'Host: elearning.ut.ac.id',
                'Content-Type: application/x-www-form-urlencoded',
                'Origin: https://elearning.ut.ac.id',
                'Referer: https://elearning.ut.ac.id/login/index.php',
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        echo "<p>Login HTTP code: <strong>$httpCode</strong></p>";
        echo "<p>Final URL: <strong>$finalUrl</strong></p>";
        
        // Cookies analysis
        echo "<h4>Cookies After Login:</h4>";
        echo "<pre>";
        system("cat " . escapeshellarg($cookieFile));
        echo "</pre>";
        
        // Step 3: Access change_password page
        echo "<h3>1.3 Accessing Password Change Page</h3>";
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/login/change_password.php',
            CURLOPT_POST => false,
            CURLOPT_HTTPGET => true,
            CURLOPT_HEADER => true,
            CURLOPT_COOKIEFILE => $cookieFile
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        
        echo "<p>Password Change Page HTTP code: <strong>$httpCode</strong></p>";
        echo "<p>Final URL: <strong>$finalUrl</strong></p>";
        
        // Extract sesskey
        $sesskey = null;
        if (preg_match('/<input[^>]*name=(["\'])sesskey\\1[^>]*value=(["\'])([^"\']+)\\2/i', $response, $matches)) {
            $sesskey = $matches[3];
            echo "<p style='color:green'>✅ Found sesskey: $sesskey</p>";
            
            // Step 4: Submit password change
            echo "<h3>1.4 Submit Password Change</h3>";
            $oldPassword = $_POST['password'];
            $newPassword = $_POST['new_password'] ?? ($oldPassword . '123');
            
            echo "<p>Old Password: ******</p>";
            echo "<p>New Password: ******</p>";
            
            $postFields = http_build_query([
                'id' => 1,
                'sesskey' => $sesskey,
                '_qf__login_change_password_form' => 1,
                'password' => $oldPassword, 
                'newpassword1' => $newPassword,
                'newpassword2' => $newPassword,
                'submitbutton' => 'Save changes'
            ]);
            
            curl_setopt_array($ch, [
                CURLOPT_URL => 'https://elearning.ut.ac.id/login/change_password.php',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HEADER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_COOKIEFILE => $cookieFile,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Origin: https://elearning.ut.ac.id',
                    'Referer: https://elearning.ut.ac.id/login/change_password.php'
                ]
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            
            echo "<p>Password Change HTTP code: <strong>$httpCode</strong></p>";
            echo "<p>Final URL: <strong>$finalUrl</strong></p>";
            
            if (strpos($finalUrl, 'change_password_complete.php') !== false || 
                strpos($response, 'has been changed') !== false) {
                echo "<p style='color:green; font-weight:bold; font-size:large;'>✅ PASSWORD CHANGE SUCCESSFUL!</p>";
            } else {
                echo "<p style='color:red; font-weight:bold; font-size:large;'>❌ Password change FAILED</p>";
                
                // Look for error messages
                if (preg_match('/<div[^>]*class="[^"]*error[^"]*"[^>]*>(.*?)<\/div>/is', $response, $errMatches)) {
                    $errorMsg = strip_tags(trim($errMatches[1]));
                    echo "<p style='color:red'>Error: $errorMsg</p>";
                }
            }
        } else {
            echo "<p style='color:red'>❌ Sesskey not found - may not be logged in</p>";
            
            if (strpos($finalUrl, 'login/index.php') !== false) {
                echo "<p style='color:red'>⚠️ Redirected to login page - session not maintained</p>";
            }
            
            // Save response for debugging
            $debugFile = "debug_response_" . time() . ".html";
            file_put_contents($debugFile, $response);
            echo "<p>Saved response to: $debugFile</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}

// Cleanup
if (isset($ch)) {
    curl_close($ch);
}
if (file_exists($cookieFile)) {
    unlink($cookieFile);
}
?>

<h2>Test Login & Password Change</h2>
<form method="post" action="">
    <div style="margin-bottom: 15px;">
        <label for="username" style="display: block;">Username:</label>
        <input type="text" id="username" name="username" required style="width: 300px; padding: 8px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block;">Password:</label>
        <input type="password" id="password" name="password" required style="width: 300px; padding: 8px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="new_password" style="display: block;">New Password (optional):</label>
        <input type="password" id="new_password" name="new_password" style="width: 300px; padding: 8px;">
        <small>If not provided, old password + "123" will be used</small>
    </div>
    
    <div>
        <button type="submit" style="padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            Test Login & Password Change
        </button>
    </div>
</form>

<!DOCTYPE html>
<html>
<head>
    <title>Debug Logs</title>
    <style>
        pre {
            background: #f4f4f4;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow-x: auto;
        }
        .timestamp {
            color: #666;
            font-weight: bold;
        }
        .step {
            color: #0066cc;
            font-weight: bold;
        }
        .error {
            color: #cc0000;
        }
        .raw-response {
            max-height: 300px;
            overflow-y: auto;
        }
        .curl-info {
            background: #e8f5ff;
        }
    </style>
</head>
<body>
    <h1>🔍 Debug Logs</h1>
    
    <h2>Latest Response</h2>
    <?php
    if(file_exists('initial_response.html')) {
        echo "<div class='raw-response'><pre>";
        echo htmlspecialchars(file_get_contents('initial_response.html'));
        echo "</pre></div>";
    }
    ?>
    
    <h2>Debug Log</h2>
    <?php
    $log_file = 'debug_log_' . date('Y-m-d') . '.txt';
    
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        $entries = explode("\n\n", $content);
        
        foreach ($entries as $entry) {
            if (empty(trim($entry))) continue;
            
            // Highlight timestamps
            $entry = preg_replace('/\[(.*?)\]/', '<span class="timestamp">[$1]</span>', $entry);
            
            // Highlight step names
            $entry = preg_replace('/(Initial Request Headers|Initial Response Headers|Anti-DDoS Cookie|Registration Request|Registration Response)/', '<span class="step">$1</span>', $entry);
            
            // Highlight errors
            $entry = preg_replace('/(error|failed|not found)/i', '<span class="error">$1</span>', $entry);
            
            echo "<pre>" . htmlspecialchars_decode($entry) . "</pre>";
        }
    } else {
        echo "<p>No debug log found for today.</p>";
    }
    ?>

    <script>
        // Auto-refresh every 3 seconds
        setTimeout(function() {
            location.reload();
        }, 3000);
    </script>
</body>
</html>
