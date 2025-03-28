<?php
session_start();
require_once 'koneksi.php';

// Redirect to products page
header('Location: products.php');
exit;
?>
