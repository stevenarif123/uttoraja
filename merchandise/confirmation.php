<?php
session_start();

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Order Confirmation</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="../kontak/index.php">Contact</a>
            <a href="../jadwal/logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h2>Thank you for your order!</h2>
        <p>You will be redirected shortly.</p>
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 5000);
        </script>

    </div>
    <footer>
        <p>&copy; 2025 Merchandise Sales. All rights reserved.</p>
    </footer>
</body>
</html>
