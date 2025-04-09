<?php
// Include auth file from the correct path
require_once __DIR__ . '/pendaftaran/list/auth.php';

// Get current user info
$currentUser = $auth->currentUser();

// Add any other logic needed for the index page
// ...
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT Toraja</title>
</head>
<body>
    <?php if ($auth->isLoggedIn()): ?>
        <!-- Content for logged in users -->
    <?php else: ?>
        <!-- Content for guests -->
    <?php endif; ?>
</body>
</html>
