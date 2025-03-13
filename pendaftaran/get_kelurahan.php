<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_daerah";

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    error_log("Koneksi database berhasil");
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Sorry, there was a problem connecting to the database.");
}

header('Content-Type: application/json');

try {
    // Check connection
    if (!$conn) {
        throw new Exception("Database connection failed");
    }

    // Use the correct query based on existing database structure
    $query = "SELECT 
        kl.area_name,
        kl.area_type,
        k.district_name,
        kb.name as kabupaten_name
    FROM kelurahan_lembang kl
    JOIN kecamatan k ON kl.kemendagri_code = k.kemendagri_code
    JOIN kabupaten kb ON k.kabupaten_id = kb.id
    ORDER BY kl.area_name";
    
    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Query error: " . $conn->error);
    }
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'area_name' => $row['area_name'],
            'area_type' => $row['area_type'],
            'district_name' => $row['district_name'],
            'kabupaten_name' => $row['kabupaten_name'],
            'display_name' => $row['area_name'] . ' (' . $row['area_type'] . ')'
        ];
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => true,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
