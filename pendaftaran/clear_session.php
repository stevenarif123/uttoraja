<?php
session_start();

// Clear specific session variables related to registration
if(isset($_SESSION['registration_success'])) {
    unset($_SESSION['registration_success']);
}

// You could also clear other registration-related session variables here
// For example:
// unset($_SESSION['registration_data']);

// Return success response
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
