<?php
session_start();
require_once 'koneksi.php';

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Calculate cart item count
$cartItemCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartItemCount += $item['quantity'];
    }
}

// Update the query to use product_sizes table
$query = "SELECT p.*, 
          GROUP_CONCAT(CONCAT(ps.size, ':', ps.stock) SEPARATOR ', ') as size_stocks,
          SUM(ps.stock) as total_stock 
          FROM Products p 
          LEFT JOIN product_sizes ps ON p.id = ps.product_id 
          GROUP BY p.id 
          HAVING total_stock > 0 
          ORDER BY p.id DESC";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchandise Sales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/marketplace.css">
</head>
<body class="bg-gray-50">
    <header class="site-header">
        <div class="header-content">
            <h1 class="text-2xl font-bold text-gray-900">Merchandise Store</h1>
            <nav class="nav-links">
                <a href="#" class="nav-link">Home</a>
                <a href="#" class="nav-link">Products</a>
                <a href="#" class="nav-link">Contact</a>
                <a href="logout.php" class="nav-link">Logout</a>
                <a href="cart.php" class="buy-button inline-flex items-center gap-2">
                    <span>Cart</span>
                    <span class="badge"><?php echo $cartItemCount; ?></span>
                </a>
            </nav>
        </div>
    </header>

    <div class="hero-section bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl mb-6">
                    Welcome to Our Merchandise Store
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                    Discover our exclusive collection of university merchandise. Show your pride with our premium quality products.
                </p>
                <?php if (isset($_SESSION['nim'])): ?>
                    <p class="mt-4 text-lg text-blue-200">
                        Welcome back, Student! Enjoy your special pricing.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="marketplace-container">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
            <p class="mt-4 text-gray-600">Browse our latest collection of exclusive merchandise</p>
        </div>

        <div class="categories-section mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="category-card bg-white p-6 rounded-lg shadow-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-lg font-semibold">T-Shirts</h3>
                <p class="text-gray-600">Comfortable and stylish designs</p>
            </div>
            <div class="category-card bg-white p-6 rounded-lg shadow-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-semibold">Accessories</h3>
                <p class="text-gray-600">Complete your collection</p>
            </div>
            <div class="category-card bg-white p-6 rounded-lg shadow-sm text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-indigo-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
                <h3 class="text-lg font-semibold">Special Offers</h3>
                <p class="text-gray-600">Limited time deals</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 mb-8">
            <div class="flex gap-4">
                <input type="text" class="form-control flex-1" placeholder="Search products...">
                <select class="form-control w-48">
                    <option value="">All Categories</option>
                    <option value="clothing">Clothing</option>
                    <option value="accessories">Accessories</option>
                </select>
            </div>
        </div>
        <div class="product-grid">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="product-image">
                        </div>
                        <div class="product-info">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="product-price">
                                Rp <?php echo number_format(isset($_SESSION['guest']) ? $product['price_guest'] : $product['price_student'], 0, ',', '.'); ?>
                            </div>
                            
                            <?php if ($product['total_stock'] > 0): ?>
                                <form method="post" action="add_to_cart.php" class="space-y-4">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo isset($_SESSION['guest']) ? $product['price_guest'] : $product['price_student']; ?>">
                                    
                                    <select name="size" required>
                                        <option value="">Select Size</option>
                                        <?php 
                                        $sizes = explode(', ', $product['size_stocks']);
                                        foreach ($sizes as $size_stock) {
                                            list($size, $stock) = explode(':', $size_stock);
                                            if ($stock > 0) {
                                                echo "<option value=\"" . htmlspecialchars($size) . "\">" . 
                                                     htmlspecialchars("$size (Stock: $stock)") . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    
                                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['total_stock']; ?>">
                                    <button type="submit" class="buy-button">
                                        <span class="mr-2">Add to Cart</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            <?php else: ?>
                                <p class="out-of-stock">Stok Habis</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer class="bg-white shadow-inner mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-600">&copy; 2025 Merchandise Sales. All rights reserved.</p>
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
