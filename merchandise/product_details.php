<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Product Details</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="../kontak/index.php">Contact</a>
            <a href="../jadwal/logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h2>Product Name</h2>
        <p>Description: Detailed description of the product goes here.</p>
        <p>Price: Rp 150.000</p>
        <button>Add to Cart</button>
    </div>
    <footer>
        <p>&copy; 2025 Merchandise Sales. All rights reserved.</p>
    </footer>
</body>
</html>
