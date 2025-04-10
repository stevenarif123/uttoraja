<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

require_once '../../koneksi.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || !isset($input['status'])) {
        throw new Exception('Missing required parameters');
    }

    $id = (int)$input['id'];
    $status = $input['status'];

    // Validate status
    $validStatuses = ['belum_diproses', 'sudah_dihubungi', 'berminat', 'tidak_berminat', 'pendaftaran_selesai'];
    if (!in_array($status, $validStatuses)) {
        throw new Exception('Invalid status value');
    }

    // Update database
    $query = "UPDATE pendaftar SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $id);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update status in database');
    }

    // Update status.json
    $statusFile = __DIR__ . '/../list/data/status.json';
    $statusData = [];
    
    if (file_exists($statusFile)) {
        $jsonContent = file_get_contents($statusFile);
        if ($jsonContent !== false) {
            $statusData = json_decode($jsonContent, true) ?: [];
        }
    }

    if (!isset($statusData['pendaftar_status'])) {
        $statusData['pendaftar_status'] = [];
    }

    $statusData['pendaftar_status'][$id] = [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if (!file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT))) {
        throw new Exception('Failed to write status to JSON file');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Status updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>