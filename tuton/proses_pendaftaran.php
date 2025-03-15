<?php
header('Content-Type: application/json');
require_once "../../koneksi.php";

try {
    // Validate incoming data
    if (!isset($_POST['nim']) || !isset($_POST['email']) || !isset($_POST['birthdate']) || !isset($_POST['phone'])) {
        throw new Exception('Data tidak lengkap');
    }

    $nim = $_POST['nim'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];

    // Get mahasiswa data first
    $stmt = mysqli_prepare($koneksi, "SELECT Password, TanggalLahir, NomorHP, Email FROM mahasiswa WHERE NIM = ?");
    mysqli_stmt_bind_param($stmt, "s", $nim);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $password = $row['Password'];
        $tanggalLahir = $row['TanggalLahir'];
        $nomorHP = $row['NomorHP'];
        $dbEmail = $row['Email'];

        // Parse birthdate
        $date = new DateTime($tanggalLahir);
        $dd = $date->format('d');
        $mm = $date->format('m');
        $yyyy = $date->format('Y');

        // Initialize CURL for direct registration
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://elearning.ut.ac.id/apput/newuser/act.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'action' => 'newuser',
                'sesskey' => '01NQlr69K1',
                '_qf__newuseract_form' => '1',
                'nim_user' => $nim,
                'dd' => $dd,
                'mm' => $mm,
                'yyyy' => $yyyy,
                'email_user' => $dbEmail,
                'nomor_hp' => $nomorHP,
                'submitbutton' => 'KIRIM'
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        // Execute registration request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Process response
        if ($httpCode == 200) {
            // Update tuton table using only existing columns
            $stmt = mysqli_prepare($koneksi, "INSERT INTO tuton (NIM, Password) 
                                            VALUES (?, ?)
                                            ON DUPLICATE KEY UPDATE 
                                            Password = VALUES(Password)");
            mysqli_stmt_bind_param($stmt, "ss", $nim, $password);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => "Pendaftaran berhasil!<br>Password: $password",
                    'password' => $password
                ]);
            } else {
                throw new Exception('Gagal menyimpan data ke database');
            }
        } else {
            // Record failed attempt - just update Password to empty string
            $stmt = mysqli_prepare($koneksi, "INSERT INTO tuton (NIM, Password) 
                                            VALUES (?, '')
                                            ON DUPLICATE KEY UPDATE 
                                            Password = ''");
            mysqli_stmt_bind_param($stmt, "s", $nim);
            mysqli_stmt_execute($stmt);
            
            throw new Exception('Gagal menghubungi server pendaftaran');
        }
    } else {
        throw new Exception('Data mahasiswa tidak ditemukan');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
