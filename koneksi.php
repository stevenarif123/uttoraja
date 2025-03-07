<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datamahasiswa";

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
?>
