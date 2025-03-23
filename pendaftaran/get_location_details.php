<?php
/**
 * 📍 Location Details API
 * 
 * This script provides district (kecamatan) and regency (kabupaten) data
 * based on the selected kelurahan/lembang.
 */

// Initialize response array
$response = [
    'success' => false,
    'kecamatan' => '',
    'kabupaten' => ''
];

// Connect to database
require_once '../koneksi_datadaerah.php';

// Get parameters
$kelurahanName = isset($_GET['kelurahan_name']) ? $_GET['kelurahan_name'] : '';
$kemendagriCode = isset($_GET['kemendagri_code']) ? $_GET['kemendagri_code'] : '';

// Validate input
if (empty($kelurahanName) && empty($kemendagriCode)) {
    $response['message'] = 'Missing required parameters';
    echo json_encode($response);
    exit;
}

try {
    // Prepare query based on available parameters
    if (!empty($kemendagriCode)) {
        // If we have the kemendagri code (more reliable)
        $query = "
            SELECT 
                k.district_name as kecamatan_name, 
                kab.name as kabupaten_name
            FROM 
                kelurahan_lembang kl
                JOIN kecamatan k ON kl.kemendagri_code = k.kemendagri_code
                JOIN kabupaten kab ON k.kabupaten_id = kab.id
            WHERE 
                kl.kemendagri_code = ?
            LIMIT 1
        ";
        $stmt = $conn_daerah->prepare($query);
        $stmt->bind_param("s", $kemendagriCode);
    } else {
        // If we only have the kelurahan name
        $query = "
            SELECT 
                k.district_name as kecamatan_name, 
                kab.name as kabupaten_name
            FROM 
                kelurahan_lembang kl
                JOIN kecamatan k ON kl.kemendagri_code = k.kemendagri_code
                JOIN kabupaten kab ON k.kabupaten_id = kab.id
            WHERE 
                kl.area_name = ?
            LIMIT 1
        ";
        $stmt = $conn_daerah->prepare($query);
        $stmt->bind_param("s", $kelurahanName);
    }

    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response['success'] = true;
        $response['kecamatan'] = $row['kecamatan_name'];
        $response['kabupaten'] = $row['kabupaten_name'];
    } else {
        // If record not found, provide defaults based on name patterns
        if (stripos($kelurahanName, 'Rantepao') !== false || stripos($kelurahanName, 'Tallunglipu') !== false) {
            $response['success'] = true;
            $response['kecamatan'] = 'Rantepao';
            $response['kabupaten'] = 'Toraja Utara';
        } else if (stripos($kelurahanName, 'Makale') !== false || stripos($kelurahanName, 'Sangalla') !== false) {
            $response['success'] = true;
            $response['kecamatan'] = 'Makale';
            $response['kabupaten'] = 'Tana Toraja';
        } else {
            $response['message'] = 'Location not found in database';
        }
    }
} catch (Exception $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
} finally {
    // Close connection
    if (isset($conn_daerah)) {
        $conn_daerah->close();
    }
}

// Set content type and return JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
