<?php
session_start();
include 'koneksi.php'; 

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Initialize variables
$status = 'pending'; 
$delivery_cost = 10000; // Biaya pengiriman default
$order_reference = "UTT" . time() . rand(1000, 9999);
$user_type = isset($_SESSION['nim']) ? 'student' : 'guest'; // Track if user is student or guest

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delivery_method = $_POST['delivery_method'] ?? 'standard';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $email = $_POST['email'] ?? '';
    $payment_method = $_POST['payment_method'] ?? 'cash';
    
    // Get customer name - if logged in as student use session name, otherwise use form input
    if (isset($_SESSION['nim']) && isset($_SESSION['name'])) {
        $customer_name = $_SESSION['name'];
    } else {
        $customer_name = $_POST['customer_name'] ?? 'Guest';
    }

    // Replace any usage of $_POST['name'] with $_POST['customer_name'] to match the form field:
    $customerName = $_POST['customer_name'] ?? '';

    // Set delivery cost based on selected method
    if ($delivery_method === 'standard') {
        $delivery_cost = 10000; // Pengiriman standar
    } elseif ($delivery_method === 'express') {
        $delivery_cost = 20000; // Pengiriman ekspres
    }

    // Calculate total amount
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $total_amount = $subtotal + $delivery_cost;
    
    // Insert order into the database - using the enhanced schema
    $stmt = $conn->prepare("INSERT INTO orders (reference_number, user_id, customer_name, order_date, status, payment_method, 
                           delivery_method, delivery_cost, total_amount, address, phone, email, notes, user_type) 
                           VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    $user_id = isset($_SESSION['nim']) ? $_SESSION['nim'] : null; // Use NULL for guest
    $stmt->bind_param("sissssddsssss", $order_reference, $user_id, $customer_name, $status, $payment_method, 
                     $delivery_method, $delivery_cost, $total_amount, $address, $phone, $email, $notes, $user_type);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the last inserted order ID

        // Insert order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, selected_size) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        
        foreach ($_SESSION['cart'] as $item) {
            $quantity = $item['quantity'];
            $product_id = $item['product_id'];
            $product_price = $item['price'];
            $size = $item['size'] ?? '';
            $stmt->bind_param("iiids", $order_id, $product_id, $quantity, $product_price, $size);
            $stmt->execute();
        }

        // Add to order tracking (optional, if you implemented the tracking table)
        $tracking_stmt = $conn->prepare("INSERT INTO order_tracking (order_id, status, notes) VALUES (?, ?, ?)");
        if ($tracking_stmt) {
            $tracking_note = "Order placed successfully";
            $tracking_stmt->bind_param("iss", $order_id, $status, $tracking_note);
            $tracking_stmt->execute();
        }

        // Store order reference in session for confirmation page
        $_SESSION['order_reference'] = $order_reference;
        
        // Clear the cart after successful order
        $_SESSION['cart'] = [];

        // Redirect to confirmation page
        $_SESSION['message'] = ['type' => 'success', 'text' => '✅ Pesanan berhasil dibuat! Reference #' . $order_reference];
        header('Location: confirmation.php');
        exit;
    } else {
        $error_message = "Terjadi masalah dalam memproses pesanan Anda. Silakan coba lagi. 😥";
    }
}

// Calculate cart subtotal
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

// Add delivery cost to get the total
$total = $subtotal + $delivery_cost;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - UTToraja Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <!-- Top navigation bar -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="index.php" class="font-bold text-xl text-primary-600">UTToraja Store</a>
            <nav class="hidden md:flex space-x-6">
                <a href="index.php" class="text-gray-500 hover:text-primary-600 transition">Home</a>
                <a href="products.php" class="text-gray-500 hover:text-primary-600 transition">Shop</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 transition">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-primary-600 transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </a>
                <button id="mobile-menu-button" class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile navigation menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 py-4">
            <div class="container mx-auto px-4 flex flex-col space-y-3">
                <a href="index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Home</a>
                <a href="products.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Shop</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Contact</a>
                <a href="../jadwal/logout.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Logout</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <!-- Checkout Progress Indicator -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="flex justify-between items-center">
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">1</div>
                    <span class="text-xs mt-1 font-medium text-primary-600">Cart</span>
                </div>
                <div class="flex-1 h-1 bg-primary-200 mx-1">
                    <div class="bg-primary-600 h-1 w-full"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">2</div>
                    <span class="text-xs mt-1 font-medium text-primary-600">Checkout</span>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-1"></div>
                <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 font-medium">3</div>
                    <span class="text-xs mt-1 text-gray-400">Confirmation</span>
                </div>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Purchase 🛒</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="mb-6 p-4 bg-red-50 text-red-800 border border-red-100 rounded-md">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="lg:flex lg:gap-8">
            <!-- Shipping & Payment Form (Left Side) -->
            <div class="lg:w-2/3 mb-8 lg:mb-0">
                <form method="post" action="" id="checkout-form">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information 📦</h2>
                        
                        <div class="space-y-4">
                            <?php if (!isset($_SESSION['nim'])): ?>
                            <!-- Show name field for guest users only -->
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Your Name <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" required 
                                       class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                       placeholder="Enter your full name">
                                <p class="mt-1 text-xs text-gray-500">You're ordering as a guest 🧑‍🦱</p>
                            </div>
                            <?php else: ?>
                            <!-- Show student status for logged-in students -->
                            <div class="px-3 py-2 bg-green-50 text-green-800 rounded-md">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                                    </svg>
                                    <p class="text-sm font-medium">Ordering as Student: <?php echo htmlspecialchars($_SESSION['name']); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div>
                                <label for="delivery_method" class="block text-sm font-medium text-gray-700 mb-1">Delivery Method</label>
                                <select id="delivery_method" name="delivery_method" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="standard">Standard Delivery - Rp 10.000 (3-5 days)</option>
                                    <option value="express">Express Delivery - Rp 20.000 (1-2 days)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                                <textarea id="address" name="address" required rows="3" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Enter your complete address with street, building number, city and postal code"></textarea>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" required class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Format: 08xxxx">
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (for receipt)</label>
                                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="your@email.com">
                                </div>
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="2" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Any special instructions for delivery"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Method 💳</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center p-4 border border-gray-200 rounded-md">
                                <input type="radio" id="cash" name="payment_method" value="cash" checked class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <label for="cash" class="ml-3 block text-sm font-medium text-gray-700">
                                    Cash on Delivery
                                </label>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-auto text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9.75m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 01-.75.75h-.75m-6-1.5H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m10.875-1.5H21a.75.75 0 00.75-.75v-.75m0 0H3.375m0 0h-.375a1.125 1.125 0 01-1.125-1.125V9.75M8.25 4.5h7.5v2.25H8.25V4.5z" />
                                </svg>
                            </div>
                            
                            <div class="flex items-center p-4 border border-gray-200 rounded-md bg-gray-50">
                                <input type="radio" id="bank" name="payment_method" value="bank" disabled class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <label for="bank" class="ml-3 block text-sm font-medium text-gray-400">
                                    Bank Transfer (Coming Soon)
                                </label>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-auto text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008h-.008V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            
                            <div class="flex items-center p-4 border border-gray-200 rounded-md bg-gray-50">
                                <input type="radio" id="ewallet" name="payment_method" value="ewallet" disabled class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                <label for="ewallet" class="ml-3 block text-sm font-medium text-gray-400">
                                    E-Wallet (Coming Soon)
                                </label>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-auto text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" id="place-order-btn" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9.75m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 01-.75.75h-.75m-6-1.5H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m10.875-1.5H21a.75.75 0 00.75-.75v-.75m0 0H3.375m0 0h-.375a1.125 1.125 0 01-1.125-1.125V9.75M8.25 4.5h7.5v2.25H8.25V4.5z" />
                        </svg>
                        Place Order
                    </button>
                    
                    <p class="text-xs text-gray-500 text-center">
                        By placing your order, you agree to our <a href="#" class="text-primary-600 hover:underline">Terms of Service</a> and <a href="#" class="text-primary-600 hover:underline">Privacy Policy</a>.
                    </p>
                </form>
            </div>
            
            <!-- Order Summary (Right Side) -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Order Summary 📋</h2>
                    
                    <div class="mb-6">
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="flex py-3 border-b border-gray-100">
                                <div class="h-16 w-16 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <?php if (!empty($item['size'])): ?>
                                        <p class="text-xs text-gray-500">Size: <?php echo htmlspecialchars($item['size']); ?></p>
                                    <?php endif; ?>
                                    <div class="mt-1 flex justify-between">
                                        <span class="text-xs text-gray-500">Qty: <?php echo $item['quantity']; ?></span>
                                        <span class="text-sm font-medium">Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="space-y-3 py-3 border-b border-gray-100 mb-3">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Shipping</span>
                            <span id="shipping-cost">Rp <?php echo number_format($delivery_cost, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span id="total-price">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <a href="cart.php" class="inline-flex items-center text-primary-600 hover:text-primary-800 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Return to cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12 mt-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <p class="text-sm text-gray-500">© 2025 UTToraja Store. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Delivery cost and total calculation
            const deliveryMethodSelect = document.getElementById('delivery_method');
            const shippingCostDisplay = document.getElementById('shipping-cost');
            const totalPriceDisplay = document.getElementById('total-price');
            const subtotal = <?php echo $subtotal; ?>;
            
            deliveryMethodSelect.addEventListener('change', function() {
                const deliveryCost = this.value === 'express' ? 20000 : 10000;
                const total = subtotal + deliveryCost;
                
                shippingCostDisplay.textContent = `Rp ${deliveryCost.toLocaleString('id-ID')}`;
                totalPriceDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            });
            
            // Form validation
            const checkoutForm = document.getElementById('checkout-form');
            const placeOrderBtn = document.getElementById('place-order-btn');
            
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(e) {
                    const address = document.getElementById('address').value.trim();
                    const phone = document.getElementById('phone').value.trim();
                    
                    if (!address) {
                        e.preventDefault();
                        alert('Please enter your delivery address');
                        return false;
                    }
                    
                    if (!phone) {
                        e.preventDefault();
                        alert('Please enter your phone number');
                        return false;
                    }
                    
                    // Phone validation - simple check for numeric and minimum length
                    if (!/^[0-9]{10,15}$/.test(phone.replace(/\D/g, ''))) {
                        e.preventDefault();
                        alert('Please enter a valid phone number (10-15 digits)');
                        return false;
                    }
                    
                    // Disable button to prevent double submission
                    placeOrderBtn.disabled = true;
                    placeOrderBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                    
                    return true;
                });
            }
        });
    </script>
</body>
</html>
