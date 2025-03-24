<?php
/**
 * Module Status Checking API 📦
 * 
 * This script handles requests to check the status of a student's module delivery
 * It validates the input, checks the database, and returns the results in JSON format
 */

// Initialize response array
$response = [
    'status' => 'error',
    'message' => '',
    'data' => null
];

// Set headers to prevent caching and specify JSON response
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Check if required parameters exist
if (!isset($_POST['nim']) || !isset($_POST['tanggal_lahir'])) {
    $response['message'] = 'Missing required parameters';
    echo json_encode($response);
    exit;
}

// Get and sanitize input
$nim = filter_input(INPUT_POST, 'nim', FILTER_SANITIZE_STRING);
$birthDate = filter_input(INPUT_POST, 'tanggal_lahir', FILTER_SANITIZE_STRING);

// Basic validation
if (strlen($nim) !== 9 || !preg_match('/^\d+$/', $nim)) {
    $response['message'] = 'NIM harus terdiri dari 9 digit angka';
    echo json_encode($response);
    exit;
}

// Validate date format DD/MM/YYYY
if (!preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $birthDate, $matches)) {
    $response['message'] = 'Format tanggal lahir tidak valid. Gunakan format DD/MM/YYYY';
    echo json_encode($response);
    exit;
}

// Extract date parts
$day = (int)$matches[1];
$month = (int)$matches[2];
$year = (int)$matches[3];

// Check if date is valid
if (!checkdate($month, $day, $year)) {
    $response['message'] = 'Tanggal lahir tidak valid';
    echo json_encode($response);
    exit;
}

// Convert date format from DD/MM/YYYY to YYYY-MM-DD for database
$formattedDate = sprintf('%04d-%02d-%02d', $year, $month, $day);

try {
    // Include database connection
    require_once '../koneksi.php';
    
    // Query to check if student exists and validate birth date
    $checkStudentQuery = "SELECT * FROM mahasiswa WHERE nim = ? AND tanggal_lahir = ?";
    $checkStmt = $conn->prepare($checkStudentQuery);
    
    if (!$checkStmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $checkStmt->bind_param("ss", $nim, $formattedDate);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    // If student not found or birth date doesn't match
    if ($result->num_rows === 0) {
        $response['message'] = 'Data mahasiswa tidak ditemukan atau tanggal lahir tidak sesuai';
        echo json_encode($response);
        exit;
    }
    
    // Student data found, get module status
    $studentData = $result->fetch_assoc();
    
    // Query to get module shipping information
    $moduleQuery = "SELECT * FROM pengiriman_modul WHERE nim = ? ORDER BY tanggal_kirim DESC LIMIT 1";
    $moduleStmt = $conn->prepare($moduleQuery);
    
    if (!$moduleStmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $moduleStmt->bind_param("s", $nim);
    $moduleStmt->execute();
    $moduleResult = $moduleStmt->get_result();
    
    // Prepare response data
    $responseData = [
        'name' => $studentData['nama'],
        'program' => $studentData['program_studi'],
        'status' => 'Belum Tersedia',
        'shipDate' => null,
        'arrivalDate' => null
    ];
    
    // If module shipping data found
    if ($moduleResult->num_rows > 0) {
        $moduleData = $moduleResult->fetch_assoc();
        
        $responseData['status'] = $moduleData['status'];
        
        // Format dates
        if ($moduleData['tanggal_kirim']) {
            $shipDate = new DateTime($moduleData['tanggal_kirim']);
            $responseData['shipDate'] = $shipDate->format('d F Y');
        }
        
        // Calculate estimated arrival date (ship date + 5 days) or use actual arrival date
        if ($moduleData['status'] === 'Dalam Perjalanan' && $moduleData['tanggal_kirim']) {
            $estArrival = new DateTime($moduleData['tanggal_kirim']);
            $estArrival->modify('+5 days');
            $responseData['arrivalDate'] = $estArrival->format('d F Y');
        } elseif ($moduleData['status'] === 'Sudah Tersedia' && $moduleData['tanggal_tiba']) {
            $arrivalDate = new DateTime($moduleData['tanggal_tiba']);
            $responseData['arrivalDate'] = $arrivalDate->format('d F Y');
        }
    }
    
    // Success response
    $response['status'] = 'success';
    $response['message'] = 'Data modul berhasil ditemukan';
    $response['data'] = $responseData;
    
    // Close statements
    $checkStmt->close();
    $moduleStmt->close();
    $conn->close();
    
} catch (Exception $e) {
    // Log error for system administrators
    error_log('Module check error: ' . $e->getMessage());
    
    // Handle any errors with generic message for security
    $response['message'] = 'Terjadi kesalahan pada sistem. Silakan coba lagi nanti atau hubungi administrator.';
}

// Return response as JSON
echo json_encode($response);
exit;
?>
