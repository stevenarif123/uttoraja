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

// Calculate cart total
$cartTotal = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartTotal += $item['price'] * $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/marketplace.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="site-header">
        <div class="header-content">
            <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
            <nav class="nav-links">
                <a href="index.php" class="nav-link">Home</a>
                <a href="products.php" class="nav-link">Products</a>
                <a href="../kontak/index.php" class="nav-link">Contact</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </div>
    </header>

    <div class="marketplace-container flex-grow">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
                <div class="p-6 bg-blue-600">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Checkout Process
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                        <div class="ml-4 text-lg font-medium">Delivery Details</div>
                    </div>
                    
                    <form method="post" action="" class="space-y-6">
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="mb-4 flex items-start">
                                <input type="checkbox" id="delivery_checkbox" name="delivery_checkbox" class="mt-1" checked>
                                <label for="delivery_checkbox" class="ml-2 text-gray-800">I want my order to be delivered</label>
                            </div>
                            
                            <div id="delivery_options" class="space-y-4">
                                <div>
                                    <label for="delivery_method" class="block text-sm font-medium text-gray-700 mb-2">Select Delivery Method</label>
                                    <select id="delivery_method" name="delivery_method" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="standard">Standard Delivery (Rp 10.000) - 3-5 days</option>
                                        <option value="express">Express Delivery (Rp 20.000) - 1-2 days</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                                    <textarea id="address" name="address" rows="3" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your complete delivery address"></textarea>
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 08123456789">
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                                <div class="ml-4 text-lg font-medium">Order Summary</div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">Rp <?php echo number_format($cartTotal, 0, ',', '.'); ?></span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Delivery Cost</span>
                                    <span id="delivery_cost" class="font-medium">Rp 10.000</span>
                                </div>
                                <div class="flex justify-between py-2 text-lg font-bold">
                                    <span>Total</span>
                                    <span id="total_cost">Rp <?php echo number_format($cartTotal + 10000, 0, ',', '.'); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-6 bg-gray-50">
                            <div class="flex items-center mb-6">
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                                <div class="ml-4 text-lg font-medium">Confirm Order</div>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-gray-600">By clicking "Place Order" you agree to our terms of service and privacy policy.</p>
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-white shadow-inner py-8 mt-auto">
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryCheckbox = document.getElementById('delivery_checkbox');
            const deliveryOptions = document.getElementById('delivery_options');
            const deliveryMethodSelect = document.getElementById('delivery_method');
            const deliveryCostDisplay = document.getElementById('delivery_cost');
            const totalCostDisplay = document.getElementById('total_cost');
            
            // Initial subtotal value (from PHP)
            const subtotal = <?php echo $cartTotal; ?>;
            
            function updateTotalCost() {
                let deliveryCost = 0;
                
                if (deliveryCheckbox.checked) {
                    deliveryCost = deliveryMethodSelect.value === 'standard' ? 10000 : 20000;
                    deliveryCostDisplay.textContent = `Rp ${deliveryCost.toLocaleString('id-ID')}`;
                } else {
                    deliveryCostDisplay.textContent = 'Rp 0';
                }
                
                const totalCost = subtotal + deliveryCost;
                totalCostDisplay.textContent = `Rp ${totalCost.toLocaleString('id-ID')}`;
            }
            
            deliveryCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    deliveryOptions.style.display = 'block';
                } else {
                    deliveryOptions.style.display = 'none';
                }
                updateTotalCost();
            });
            
            deliveryMethodSelect.addEventListener('change', updateTotalCost);
            
            // Initial update
            updateTotalCost();
        });
    </script>
</body>
</html>
