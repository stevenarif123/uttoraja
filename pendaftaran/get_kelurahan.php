<?php
require_once '../koneksi.php';

try {
    $query = "SELECT kl.area_name, kl.area_type, k.district_name, kb.name as kabupaten_name
              FROM kelurahan_lembang kl
              JOIN kecamatan k ON kl.kemendagri_code = k.kemendagri_code
              JOIN kabupaten kb ON k.kabupaten_id = kb.id
              ORDER BY kl.area_name";
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception($conn->error);
    }
    
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
