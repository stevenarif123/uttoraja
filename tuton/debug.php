<?php
header('Content-Type: text/html; charset=utf-8');
?>
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
