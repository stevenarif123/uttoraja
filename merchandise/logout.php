<?php
session_start();

// Unset session variables
unset($_SESSION['nim']);
unset($_SESSION['guest']);

// Destroy the session
session_destroy();

// Redirect to index.php
header('Location: index.php');
exit;
?>