<?php
    require_once '../koneksi.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nim = $_POST["nim"];
        $tanggal_lahir = $_POST["tanggal_lahir"];

        error_log("NIM: " . $nim, 3, "error_log");
        error_log("Tanggal Lahir: " . $tanggal_lahir, 3, "error_log");

        $sql = "SELECT status FROM modul WHERE nim = '$nim' AND tanggal_lahir = '$tanggal_lahir'";
        $result = $conn->query($sql);

        error_log("SQL: " . $sql, 3, "error_log");
        error_log("num_rows: " . $result->num_rows, 3, "error_log");

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = $row["status"];
        } else {
            $status = -1;
        }
        error_log("Status: " . $status, 3, "error_log");
        header('Content-Type: application/json');
        echo json_encode(['status' => $status]);
        exit();
    }
?>
