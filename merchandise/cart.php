<?php
session_start();

// Check if the user is logged in
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
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/marketplace.css">
</head>
<body class="bg-gray-50">
    <header class="site-header">
        <div class="header-content">
            <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="../kontak/index.php">Contact</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    <div class="marketplace-container">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">Your Cart Items</h2>
            <?php
            $total_price = 0;
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <div class="space-y-4">
                    <?php foreach ($_SESSION['cart'] as $item): 
                        $item_total = $item['price'] * $item['quantity'];
                        $total_price += $item_total; ?>
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <h3 class="product-title"><?php echo htmlspecialchars($item['name']); ?></h3>
                                <?php if (isset($item['size'])): ?>
                                    <span class="text-sm text-gray-500">Size: <?php echo htmlspecialchars($item['size']); ?></span>
                                <?php endif; ?>
                                <div class="product-price">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                            </div>
                            <div class="cart-controls">
                                <form method="post" action="update_cart.php" class="flex items-center gap-2">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                           min="0" class="form-control quantity-input">
                                    <button type="submit" class="buy-button">Update</button>
                                </form>
                                <form method="post" action="update_cart.php" class="flex items-center gap-2">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                    <input type="hidden" name="delete" value="1">
                                    <button type="submit" class="buy-button">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <h3>Total Price: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></h3>

                <!-- Delivery method selection -->
                <form method="post" action="checkout.php">
                    <label for="delivery_checkbox">Use Delivery?</label>
                    <input type="checkbox" id="delivery_checkbox" name="delivery_checkbox">
                    <div id="delivery_options" style="display: none;">
                        <label for="delivery_method">Select Delivery Method:</label>
                        <select id="delivery_method" name="delivery_method">
                            <option value="standard">Standard Delivery (Rp 10.000)</option>
                            <option value="express">Express Delivery (Rp 20.000)</option>
                        </select>
                        <br>
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address">
                        <br>
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="phone">
                        <br>
                    </div>
                    <button type="submit">Process Order</button>
                </form>
                <script>
                    const deliveryCheckbox = document.getElementById("delivery_checkbox");
                    const deliveryOptions = document.getElementById("delivery_options");

                    deliveryCheckbox.addEventListener("change", function() {
                        if (this.checked) {
                            deliveryOptions.style.display = "block";
                            document.getElementById("address").required = true;
                            document.getElementById("phone").required = true;
                        } else {
                            deliveryOptions.style.display = "none";
                            document.getElementById("address").required = false;
                            document.getElementById("phone").required = false;
                        }
                    });
                </script>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Merchandise Sales. All rights reserved.</p>
    </footer>
</body>
</html>
