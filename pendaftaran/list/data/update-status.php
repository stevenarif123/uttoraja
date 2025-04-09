<?php
header('Content-Type: application/json');

// Path to status JSON file
$statusFile = __DIR__ . '/../data/status.json';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !$status) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

try {
    // Read current status data
    $statusData = json_decode(file_get_contents($statusFile), true) ?: ['pendaftar_status' => []];
    
    // Update status for this ID
    $statusData['pendaftar_status'][$id] = [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Save back to file
    if (file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT))) {
        echo json_encode([
            'success' => true,
            'message' => 'Status updated successfully'
        ]);
    } else {
        throw new Exception('Failed to write status data');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update status: ' . $e->getMessage()]);
}
