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
    <title>Products</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Our Products</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="../kontak/index.php">Contact</a>
            <a href="../jadwal/logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h2>Available Products</h2>
        <div class="product">
            <h3>Baju Almamater</h3>
            <p>Deskripsi: Baju almamater yang nyaman dan berkualitas.</p>
            <p>Harga: <?php echo isset($_SESSION['guest']) ? 'Rp 150.000' : 'Rp 120.000'; ?></p>
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_name" value="Baju Almamater">
                <input type="hidden" name="product_price" value="<?php echo isset($_SESSION['guest']) ? '150000' : '120000'; ?>">
                <button type="submit">Pesan Sekarang</button>
            </form>
        </div>
        <div class="product">
            <h3>T-Shirt</h3>
            <p>Deskripsi: T-Shirt casual untuk sehari-hari.</p>
            <p>Harga: <?php echo isset($_SESSION['guest']) ? 'Rp 100.000' : 'Rp 80.000'; ?></p>
            <button>Pesan Sekarang</button>
        </div>
        <!-- Add more products as needed -->
    </div>
    <footer>
        <p>&copy; 2025 Merchandise Sales. All rights reserved.</p>
    </footer>
</body>
</html>
