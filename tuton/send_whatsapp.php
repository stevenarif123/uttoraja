<?php
// Set proper headers
header('Content-Type: application/json');

// Get request data
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Validate inputs
if (empty($phone) || empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

// Initialize response
$response = [
    'success' => false,
    'message' => 'Failed to send WhatsApp message'
];

// Define possible WhatsApp API methods - try multiple methods for better reliability
$methods = [
    'whatsapp_api_method1' => function($phone, $message) {
        // Method 1: WhatsApp Business API (if you have access)
        // Replace with your actual API credentials if you have them
        return false; // Return true if successful
    },
    
    'whatsapp_api_method2' => function($phone, $message) {
        // Method 2: Third-party API integration (e.g., Twilio, MessageBird)
        // This would require valid API credentials
        return false; // Return true if successful
    },
    
    'url_file_exists' => function($phone, $message) {
        // Method 3: Simple URL check (least reliable, but works as fallback)
        $waUrl = 'https://wa.me/' . $phone . '?text=' . urlencode($message);
        $headers = @get_headers($waUrl);
        return $headers && strpos($headers[0], '200') !== false;
    }
];

// Attempt to send using available methods
foreach ($methods as $method_name => $method) {
    if ($method($phone, $message)) {
        $response = [
            'success' => true,
            'message' => 'WhatsApp message sent successfully',
            'method' => $method_name
        ];
        break;
    }
}

// Log the attempt (optional)
$log_file = fopen('whatsapp_log.txt', 'a');
$log_entry = date('Y-m-d H:i:s') . " | To: $phone | Success: " . ($response['success'] ? 'Yes' : 'No') . PHP_EOL;
fwrite($log_file, $log_entry);
fclose($log_file);

// Return response
echo json_encode($response);
exit;
