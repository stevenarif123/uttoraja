<?php
// Update CORS headers to be more permissive for development
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-KEY, Authorization');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Credentials: true');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Set JSON content type
header('Content-Type: application/json');
// Set header agar respon JSON    
header('Content-Type: application/json');    

// Include koneksi.php    
include '../../koneksi.php';    

// Definisi API Key
$VALID_API_KEY = 'pantanmandiri25';

// Fungsi validasi API Key
function validateApiKey($providedKey) {
    
    global $VALID_API_KEY;
    return hash_equals($VALID_API_KEY, $providedKey);
}

// Fungsi untuk mendapatkan API Key dari request
function getApiKey() {
    // Coba dari header
    $apiKey = $_SERVER['HTTP_X_API_KEY'] ?? null;
    
    // Jika tidak ada di header, coba dari query parameter
    if (!$apiKey) {
        $apiKey = $_GET['api_key'] ?? null;
    }
    
    // Jika tidak ada di query parameter, coba dari request body
    if (!$apiKey && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $apiKey = $input['api_key'] ?? null;
    }
    
    return $apiKey;
}

// Debugging
error_log('Full REQUEST_URI: ' . $_SERVER['REQUEST_URI']);

// Parsing URI dengan metode yang lebih presisi
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$uriParts = explode('/', $requestUri);

// Debug URI Parts
error_log('Parsed URI Parts: ' . print_r($uriParts, true));

// Tentukan resource dengan lebih presisi
$resource = isset($uriParts[2]) ? strtok($uriParts[2], '?') : null;
$id = isset($uriParts[3]) ? $uriParts[3] : null;

// Tambahkan penanganan query parameter
$queryId = isset($_GET['id']) ? $_GET['id'] : null;

// Prioritaskan ID dari path URL, jika tidak ada gunakan dari query parameter
$finalId = $id ?: $queryId;

// Mendapatkan metode HTTP    
$method = $_SERVER['REQUEST_METHOD'];    

// Mendapatkan data JSON dari request body    
$input = json_decode(file_get_contents('php://input'), true);    

// Fungsi untuk mengirim respons JSON    
function sendResponse($data, $status = 200) {    
    http_response_code($status);    
    echo json_encode($data);
    exit;
}    

// Fungsi untuk mengeksekusi query dan mengembalikan hasil    
function executeQuery($conn, $query, $params = []) {    
    $stmt = $conn->prepare($query);    
    if ($stmt === false) {    
        sendResponse(['error' => 'Query preparation failed: ' . $conn->error], 500);    
    }    
    if (!empty($params)) {    
        $types = str_repeat('s', count($params));    
        $stmt->bind_param($types, ...$params);    
    }    
    if (!$stmt->execute()) {    
        sendResponse(['error' => 'Query execution failed: ' . $stmt->error], 500);    
    }    
    return $stmt;    
}    

// Route utama
try {
    // Validasi API Key untuk semua metode kecuali GET
    if ($method !== 'GET') {
        $apiKey = getApiKey();
        
        if (!$apiKey) {
            sendResponse([
                'error' => 'Unauthorized',
                'message' => 'API Key diperlukan'
            ], 401);
        }
        
        if (!validateApiKey($apiKey)) {
            sendResponse([
                'error' => 'Unauthorized',
                'message' => 'API Key tidak valid'
            ], 401);
        }
    }

    switch ($method) {
        case 'GET':
            if ($resource === 'pendaftar') {
                if ($finalId) {    
                    // Retrieve a specific entry by ID    
                    $query = "SELECT * FROM pendaftar WHERE id = ?";    
                    $stmt = executeQuery($conn, $query, [$finalId]);    
                    $result = $stmt->get_result();    
                    if ($result->num_rows > 0) {    
                        $data = $result->fetch_assoc();    
                        sendResponse($data);    
                    } else {    
                        sendResponse(['message' => 'Data tidak ditemukan', 'id' => $finalId], 404);    
                    }
                } else {    
                    // Retrieve all entries    
                    $query = "SELECT * FROM pendaftar";    
                    $result = mysqli_query($conn, $query);    
                    if ($result) {    
                        $data = [];    
                        while ($row = mysqli_fetch_assoc($result)) {    
                            $data[] = $row;    
                        }    
                        sendResponse($data);    
                    } else {    
                        sendResponse(['error' => 'Query execution failed: ' . mysqli_error($conn)], 500);    
                    }    
                }
                break;
            }
            // Default route untuk GET
            sendResponse([
                'message' => 'API is running', 
                'available_endpoints' => ['pendaftar']
            ]);
            break;

        case 'POST':
            if ($resource === 'pendaftar') {
                // Logika POST untuk menambah data
                if (!empty($input)) {    
                    // Sesuaikan dengan struktur kolom di database
                    $query = "INSERT INTO pendaftar (
                        nama_lengkap, nomor_hp, tempat_lahir, tanggal_lahir, 
                        ibu_kandung, nik, jurusan, agama, jenis_kelamin, 
                        jalur_program, alamat, ukuran_baju, tempat_kerja, bekerja
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";    
                    
                    $params = [
                        $input['nama_lengkap'] ?? null,
                        $input['nomor_hp'] ?? null,
                        $input['tempat_lahir'] ?? null,
                        $input['tanggal_lahir'] ?? null,
                        $input['ibu_kandung'] ?? null,
                        $input['nik'] ?? null,
                        $input['jurusan'] ?? null,
                        $input['agama'] ?? null,
                        $input['jenis_kelamin'] ?? null,
                        $input['jalur_program'] ?? null,
                        $input['alamat'] ?? null,
                        $input['ukuran_baju'] ?? null,
                        $input['tempat_kerja'] ?? null,
                        $input['bekerja'] ?? null
                    ];    
                    
                    $stmt = executeQuery($conn, $query, $params);    
                    $insertedId = mysqli_insert_id($conn);
                    sendResponse([
                        'message' => 'Data berhasil ditambahkan', 
                        'id' => $insertedId
                    ], 201);    
                } else {    
                    sendResponse(['error' => 'Data tidak lengkap'], 400);    
                }
                break;
            }
            // Default route untuk POST
            sendResponse([
                'message' => 'API is running', 
                'available_endpoints' => ['pendaftar']
            ]);
            break;

        case 'PUT':
            if ($resource === 'pendaftar') {
                // Logika PUT untuk update data
                if (!$finalId) {
                    sendResponse([
                        'error' => 'ID tidak boleh kosong', 
                        'message' => 'Gunakan /pendaftar/{id} atau ?id={id}'
                    ], 400);
                } 
                
                // Cek apakah data dengan ID tersebut ada
                $checkQuery = "SELECT * FROM pendaftar WHERE id = ?";
                $checkStmt = executeQuery($conn, $checkQuery, [$finalId]);
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows === 0) {
                    sendResponse([
                        'message' => 'Data tidak ditemukan',
                        'id' => $finalId
                    ], 404);
                }
                
                // Debug log for input data
                error_log('PUT Input data: ' . json_encode($input));

                // Pre-process input data to handle NULL values
                foreach ($input as $key => $value) {
                    // Special handling for the string "NULL" - convert to actual NULL
                    if ($value === "NULL") {
                        $input[$key] = null;
                    }
                }
                
                // Update data with processed values
                $query = "UPDATE pendaftar SET 
                    nama_lengkap = ?, nomor_hp = ?, tempat_lahir = ?, 
                    tanggal_lahir = ?, ibu_kandung = ?, nik = ?, 
                    jurusan = ?, agama = ?, jenis_kelamin = ?, 
                    jalur_program = ?, alamat = ?, ukuran_baju = ?, 
                    tempat_kerja = ?, bekerja = ? 
                    WHERE id = ?";
                $params = [
                    $input['nama_lengkap'] ?? null,
                    $input['nomor_hp'] ?? null,
                    $input['tempat_lahir'] ?? null,
                    $input['tanggal_lahir'] ?? null,
                    $input['ibu_kandung'] ?? null,
                    $input['nik'] ?? null,
                    $input['jurusan'] ?? null,
                    $input['agama'] ?? null,
                    $input['jenis_kelamin'] ?? null,
                    $input['jalur_program'] ?? null,
                    $input['alamat'] ?? null,
                    $input['ukuran_baju'] ?? null,
                    $input['tempat_kerja'] ?? null,
                    $input['bekerja'] ?? null,
                    $finalId
                ];
                
                // Debug log for prepared statement params
                error_log('PUT params: ' . json_encode($params));

                $stmt = executeQuery($conn, $query, $params);
                sendResponse([
                    'message' => 'Data berhasil diperbarui',
                    'id' => $finalId
                ]);
            }
            // Default route untuk PUT
            sendResponse([
                'message' => 'API is running',
                'available_endpoints' => ['pendaftar']
            ]);
            break;

        case 'DELETE':
            if ($resource === 'pendaftar') {
                // Cek apakah ID tersedia
                if (!$finalId) {
                    sendResponse([
                        'error' => 'ID tidak boleh kosong',
                        'message' => 'Gunakan /pendaftar/{id} atau ?id={id}'
                    ], 400);
                }

                // Periksa apakah data dengan ID tersebut ada
                $checkQuery = "SELECT * FROM pendaftar WHERE id = ?";
                $checkStmt = executeQuery($conn, $checkQuery, [$finalId]);
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows === 0) {
                    sendResponse([
                        'message' => 'Data tidak ditemukan',
                        'id' => $finalId
                    ], 404);
                }

                // Eksekusi penghapusan data
                $query = "DELETE FROM pendaftar WHERE id = ?";
                $stmt = executeQuery($conn, $query, [$finalId]);

                // Kirim respons berhasil
                sendResponse([
                    'message' => 'Data berhasil dihapus',
                    'id' => $finalId
                ]);
            }
            // Default route untuk DELETE
            sendResponse([
                'message' => 'Endpoint tidak ditemukan',
                'available_endpoints' => ['pendaftar']
            ], 404);
            break;

        default:
            sendResponse(['error' => 'Metode tidak didukung'], 405);
            break;
    }
} catch (Exception $e) {
    sendResponse(['error' => 'Terjadi kesalahan: ' . $e->getMessage()],  500);
}