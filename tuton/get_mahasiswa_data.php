<?php
header('Content-Type: application/json');
require_once "../../koneksi.php";

try {
    if (!isset($_POST['nim'])) {
        throw new Exception('NIM tidak ditemukan');
    }

    $nim = filter_var($_POST['nim'], FILTER_SANITIZE_STRING);
    
    // Get complete mahasiswa data
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM mahasiswa WHERE NIM = ?");
    mysqli_stmt_bind_param($stmt, "s", $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Format date properly
        $row['TanggalLahir'] = date('Y-m-d', strtotime($row['TanggalLahir']));
        
        echo json_encode([
            'status' => 'success',
            'mahasiswa' => $row
        ]);
    } else {
        throw new Exception('Data mahasiswa tidak ditemukan');
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
