<?php
session_start();
include 'koneksi.php'; // Include database connection

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Initialize variables
$status = 'pending'; // Initialize status
$delivery_cost = 0;

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delivery_method = null;
    $address = null;
    $phone = null;
    $delivery_cost = 0;

    if (isset($_POST['delivery_checkbox'])) {
        $delivery_method = $_POST['delivery_method'] ?? null;
        $address = $_POST['address'] ?? null;
        $phone = $_POST['phone'] ?? null;

        // Set delivery cost based on selected method
        if ($delivery_method === 'standard') {
            $delivery_cost = 10000;
        } elseif ($delivery_method === 'express') {
            $delivery_cost = 20000;
        }
    }


    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO Orders (user_id, order_date, status, delivery_method, delivery_cost, address, phone) VALUES (?, NOW(), ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $user_id = isset($_SESSION['guest']) ? null : $_SESSION['nim']; // Use NULL for guest

    $stmt->bind_param("isssis", $user_id, $status, $delivery_method, $delivery_cost, $address, $phone);
    $stmt->execute();

    $order_id = $stmt->insert_id; // Get the last inserted order ID

    // Insert order items
    $stmt = $conn->prepare("INSERT INTO Order_Items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    foreach ($_SESSION['cart'] as $item) {
        $quantity = $item['quantity'];
        $product_id = $item['id'];
        $product_price = $item['price'];
        $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product_price);
        $stmt->execute();
    }

    // Clear the cart after successful order
     unset($_SESSION['cart']);

    // Redirect to confirmation page
    header('Location: confirmation.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="products.php">Products</a>
            <a href="../kontak/index.php">Contact</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h2>Order Summary</h2>
        <form method="post" action="">
            <label for="delivery_method">Select Delivery Method:</label>
            <select id="delivery_method" name="delivery_method" required>
                <option value="standard">Standard Delivery (Rp 10.000)</option>
                <option value="express">Express Delivery (Rp 20.000)</option>
            </select>
            <br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <br>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <button type="submit">Confirm Order</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2025 Merchandise Sales. All rights reserved.</p>
    </footer>
</body>
</html>
