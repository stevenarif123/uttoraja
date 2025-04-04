<?php
session_start();
include 'koneksi.php';

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle removing items from cart
if (isset($_GET['remove']) && isset($_SESSION['cart'])) {
    $remove_id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['cart_item_id'] === $remove_id) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['message'] = ['type' => 'success', 'text' => '🗑️ Item removed from cart.'];
            break;
        }
    }
    // Re-index the array after removal
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}

// Calculate cart totals
$cart_total = 0;
$item_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_total += $item['price'] * $item['quantity'];
    $item_count += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - UTToraja Store</title>
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
                <a href="cart.php" class="relative text-primary-600 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
        <!-- Page title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Shopping Cart 🛒</h1>
            <p class="text-gray-500">Review your <span class="item-count"><?php echo $item_count; ?></span> items and proceed to checkout</p>
        </div>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="max-w-3xl mx-auto mb-8 p-4 <?php echo $_SESSION['message']['type'] === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?> rounded-md">
                <?php echo $_SESSION['message']['text']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <!-- Empty cart state -->
            <div class="flex flex-col items-center justify-center py-16">
                <div class="bg-gray-100 rounded-full p-6 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Your cart is empty 🛍️</h3>
                <p class="text-gray-500 mb-6 text-center">Looks like you haven't added any products to your cart yet.</p>
                <a href="products.php" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-6 rounded transition">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            
            <!-- Cart with items - NEW RESPONSIVE DESIGN -->
            <div class="max-w-5xl mx-auto">
                <!-- Replaced form with div since we're handling updates with AJAX -->
                <div>
                    <!-- Desktop View (hidden on mobile) -->
                    <div class="hidden md:block bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($_SESSION['cart'] as $item): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded bg-gray-100">
                                                        <?php if (!empty($item['image']) && file_exists("../uploads/" . $item['image'])): ?>
                                                            <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-full w-full object-contain">
                                                        <?php else: ?>
                                                            <div class="h-full w-full flex items-center justify-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-300">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                                </svg>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></div>
                                                        <?php if (!empty($item['size'])): ?>
                                                            <div class="text-sm text-gray-500">Size: <?php echo htmlspecialchars($item['size']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center max-w-[120px]">
                                                    <div class="flex border border-gray-300 rounded-md items-center">
                                                        <button type="button" class="decrease-qty px-2 py-1 text-gray-600 hover:bg-gray-100 focus:outline-none">-</button>
                                                        <input type="number" name="quantities[<?php echo htmlspecialchars($item['cart_item_id']); ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="w-12 text-center border-0 focus:ring-0" />
                                                        <button type="button" class="increase-qty px-2 py-1 text-gray-600 hover:bg-gray-100 focus:outline-none">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900" data-item-id="<?php echo htmlspecialchars($item['cart_item_id']); ?>">
                                                    Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="cart.php?remove=<?php echo urlencode($item['cart_item_id']); ?>" class="text-red-600 hover:text-red-900">
                                                    Remove
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile View (shown only on mobile) -->
                    <div class="md:hidden space-y-4 mb-6">
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
                                <div class="flex items-start space-x-4 mb-4">
                                    <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded bg-gray-100">
                                        <?php if (!empty($item['image']) && file_exists("../uploads/" . $item['image'])): ?>
                                            <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-full w-full object-contain">
                                        <?php else: ?>
                                            <div class="h-full w-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-300">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <?php if (!empty($item['size'])): ?>
                                            <p class="text-sm text-gray-500">Size: <?php echo htmlspecialchars($item['size']); ?></p>
                                        <?php endif; ?>
                                        <p class="text-sm text-primary-600 font-medium mt-1">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 mr-3">Qty:</span>
                                        <div class="flex border border-gray-300 rounded-md items-center">
                                            <button type="button" class="decrease-qty px-2 py-1 text-gray-600 hover:bg-gray-100 focus:outline-none">-</button>
                                            <input type="number" name="quantities[<?php echo htmlspecialchars($item['cart_item_id']); ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="w-12 text-center border-0 focus:ring-0" />
                                            <button type="button" class="increase-qty px-2 py-1 text-gray-600 hover:bg-gray-100 focus:outline-none">+</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900" data-item-id="<?php echo htmlspecialchars($item['cart_item_id']); ?>">
                                            Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>
                                        </div>
                                        <a href="cart.php?remove=<?php echo urlencode($item['cart_item_id']); ?>" class="text-red-600 hover:text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex justify-between items-center font-medium">
                                <span>Subtotal (<span class="item-count"><?php echo $item_count; ?></span> items):</span>
                                <span class="cart-subtotal">Rp <?php echo number_format($cart_total, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                        
                        <!-- Removed Update Cart button -->
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                        <div class="w-full md:w-1/2">
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary 📋</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                        <span class="text-gray-600">Items (<span class="item-count"><?php echo $item_count; ?></span>):</span>
                                        <span class="text-gray-900 font-medium cart-subtotal">Rp <?php echo number_format($cart_total, 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                                        <span class="text-gray-600">Estimated Shipping:</span>
                                        <span class="text-gray-500">Calculated at checkout</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-gray-900 font-medium">Total:</span>
                                        <span class="text-xl text-primary-600 font-semibold cart-total" id="total-price">Rp <?php echo number_format($cart_total, 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <a href="checkout.php" class="block w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded text-center transition">
                                        Proceed to Checkout 🚀
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/2 flex flex-col gap-4">
                            <div class="hidden md:flex justify-end">
                                <!-- Removed Update Cart button, kept only Continue Shopping -->
                                <a href="products.php" class="text-primary-600 hover:text-primary-700 font-medium inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                    Continue Shopping
                                </a>
                            </div>
                            
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-blue-800">ℹ️ Dynamic Cart Updates</h4>
                                        <p class="mt-1 text-sm text-blue-700">Your cart updates in real-time as you change quantities. All changes are saved automatically!</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Continue shopping button for mobile -->
                            <div class="md:hidden">
                                <a href="products.php" class="block text-center w-full py-3 text-primary-600 font-medium">
                                    ← Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12">
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
            
            // Quantity controls with dynamic updates
            const decreaseButtons = document.querySelectorAll('.decrease-qty');
            const increaseButtons = document.querySelectorAll('.increase-qty');
            const quantityInputs = document.querySelectorAll('input[type="number"][name^="quantities"]');
            
            decreaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input[type="number"]');
                    const currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                        updateCartItem(input);
                    }
                });
            });
            
            increaseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input[type="number"]');
                    input.value = parseInt(input.value) + 1;
                    updateCartItem(input);
                });
            });
            
            // Handle direct input changes (when user types a number)
            quantityInputs.forEach(input => {
                input.addEventListener('change', function() {
                    updateCartItem(this);
                });
            });
            
            // Function to update cart via AJAX - Enhanced with better price updates
            function updateCartItem(inputElement) {
                const cartItemId = inputElement.name.match(/quantities\[(.*?)\]/)[1];
                const newQuantity = parseInt(inputElement.value);
                
                if (isNaN(newQuantity) || newQuantity < 1) {
                    inputElement.value = 1;
                    return;
                }
                
                // Show loading state
                const rowElement = inputElement.closest('tr') || inputElement.closest('.bg-white.rounded-lg');
                if (rowElement) {
                    rowElement.classList.add('opacity-50');
                }
                
                // Create form data for the AJAX request
                const formData = new FormData();
                formData.append('cart_item_id', cartItemId);
                formData.append('quantity', newQuantity);
                
                // Send AJAX request
                fetch('update_cart_ajax.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cart data updated:', data); // Debug info
                        
                        // Update individual item total using data attributes
                        const itemTotalElements = document.querySelectorAll(`[data-item-id="${cartItemId}"]`);
                        itemTotalElements.forEach(el => {
                            el.textContent = `Rp ${data.formatted_item_total}`;
                        });
                        
                        // Update ALL cart subtotal instances
                        const subtotalElements = document.querySelectorAll('.cart-subtotal');
                        subtotalElements.forEach(el => {
                            el.textContent = `Rp ${data.formatted_cart_total}`;
                        });
                        
                        // Update ALL total price instances including the main total
                        const totalElements = document.querySelectorAll('.cart-total');
                        totalElements.forEach(el => {
                            el.textContent = `Rp ${data.formatted_cart_total}`;
                        });
                        
                        // Update the "total-price" element specifically 
                        const totalPriceElement = document.getElementById('total-price');
                        if (totalPriceElement) {
                            totalPriceElement.textContent = `Rp ${data.formatted_cart_total}`;
                        }
                        
                        // Update item count everywhere
                        const itemCountElements = document.querySelectorAll('.item-count');
                        itemCountElements.forEach(el => {
                            el.textContent = data.item_count;
                        });
                        
                        // If item was removed (quantity set to 0), reload the page
                        if (newQuantity <= 0) {
                            location.reload();
                        }
                        
                        // Show mini notification
                        showNotification('🛒 Cart updated successfully!', 'success');
                    } else {
                        // Show error message
                        showNotification(data.message || 'Error updating cart', 'error');
                        // Reset to previous quantity if stock issue
                        if (data.message && data.message.includes('stock')) {
                            inputElement.value = inputElement.defaultValue;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error updating cart:', error);
                    showNotification('⚠️ Failed to update cart. Please try again.', 'error');
                })
                .finally(() => {
                    // Remove loading state
                    if (rowElement) {
                        rowElement.classList.remove('opacity-50');
                    }
                });
            }
            
            // Simple notification function
            function showNotification(message, type = 'success') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
                    type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 
                    'bg-red-50 text-red-800 border border-red-200'
                } transition-all duration-500 transform translate-x-full opacity-0`;
                notification.textContent = message;
                
                // Add to DOM
                document.body.appendChild(notification);
                
                // Trigger animation to show
                setTimeout(() => {
                    notification.classList.remove('translate-x-full', 'opacity-0');
                }, 10);
                
                // Remove after delay
                setTimeout(() => {
                    notification.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>