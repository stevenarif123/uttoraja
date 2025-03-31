<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_daerah";

// Create connection
$conn_daerah = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn_daerah->connect_error) {
    die("Connection failed: " . $conn_daerah->connect_error);
}

// Set charset to utf8mb4
$conn_daerah->set_charset("utf8mb4");
?>
