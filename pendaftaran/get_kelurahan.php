<?php
require_once '../koneksi_datadaerah.php';

try {
    // Modified query to ensure proper joins and error handling 🔄
    $query = "SELECT 
        kl.area_name,
        kl.area_type,
        kc.district_name as kecamatan,
        kb.name as kabupaten
    FROM kelurahan_lembang kl
    LEFT JOIN kecamatan kc ON kl.kemendagri_code = kc.kemendagri_code
    LEFT JOIN kabupaten kb ON kc.kabupaten_id = kb.id
    ORDER BY kl.area_name";

    $result = $conn_daerah->query($query);
    
    if (!$result) {
        throw new Exception("Database query failed: " . $conn_daerah->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        // Ensure all required data is present
        if (!$row['area_name'] || !$row['kecamatan'] || !$row['kabupaten']) {
            continue; // Skip incomplete records
        }
        $data[] = array(
            'area_name' => $row['area_name'],
            'area_type' => $row['area_type'],
            'district_name' => $row['kecamatan'],
            'kabupaten_name' => $row['kabupaten']
        );
    }

    if (empty($data)) {
        throw new Exception("No valid kelurahan data found");
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $data]);

} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}

$conn_daerah->close();
