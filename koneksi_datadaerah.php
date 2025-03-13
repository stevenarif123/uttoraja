<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "data_daerah";

$conn_daerah = mysqli_connect($host, $user, $pass, $db);

if (!$conn_daerah) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
