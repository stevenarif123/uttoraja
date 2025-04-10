<?php
header('Content-Type: application/json');

// Path to status JSON file
$statusFile = __DIR__ . '/status.json';

// Create directory if it doesn't exist
if (!is_dir(dirname($statusFile))) {
    mkdir(dirname($statusFile), 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON: ' . json_last_error_msg()]);
    exit;
}

$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !$status) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

try {
    // Read current status data
    $statusData = [];
    if (file_exists($statusFile)) {
        $jsonContent = file_get_contents($statusFile);
        if ($jsonContent !== false) {
            $statusData = json_decode($jsonContent, true) ?: [];
        }
    }
    
    // Initialize pendaftar_status if not exists
    if (!isset($statusData['pendaftar_status'])) {
        $statusData['pendaftar_status'] = [];
    }
    
    // Update status for this ID
    $statusData['pendaftar_status'][$id] = [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Save back to file with proper permissions
    if (file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT), LOCK_EX)) {
        // Set proper file permissions
        chmod($statusFile, 0666);
        
        echo json_encode([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    } else {
        throw new Exception('Failed to write status data');
    }
} catch (Exception $e) {
    error_log('Status update error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update status: ' . $e->getMessage()]);
}
