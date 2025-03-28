<?php
session_start();
include 'koneksi.php';

// Initialize message variable
$message = '';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (
        isset($_POST['product_id']) && 
        isset($_POST['product_name']) && 
        isset($_POST['product_price']) && 
        isset($_POST['quantity'])
    ) {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
        $size = isset($_POST['size']) ? filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING) : null;
        
        // Additional validation
        if (!$product_id || !$product_name || !$price || $quantity < 1) {
            $message = '❌ Invalid product information.';
        } else {
            // Check if product exists and is active
            $stmt = $conn->prepare("SELECT * FROM Products WHERE id = ? AND active = 1");
            if ($stmt) {
                $stmt->bind_param('i', $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 0) {
                    $message = '❌ Product not found or is no longer available.';
                } else {
                    $product = $result->fetch_assoc();
                    
                    // Check stock if size is provided
                    if ($size) {
                        $stock_stmt = $conn->prepare("SELECT stock FROM product_sizes WHERE product_id = ? AND size = ?");
                        $stock_stmt->bind_param('is', $product_id, $size);
                        $stock_stmt->execute();
                        $stock_result = $stock_stmt->get_result();
                        
                        if ($stock_result->num_rows > 0) {
                            $stock_row = $stock_result->fetch_assoc();
                            if ($stock_row['stock'] < $quantity) {
                                $message = '❌ Sorry, we only have ' . $stock_row['stock'] . ' items in stock for this size.';
                                $stock_stmt->close();
                                $stmt->close();
                                $_SESSION['message'] = ['type' => 'error', 'text' => $message];
                                header('Location: product_details.php?id=' . $product_id);
                                exit;
                            }
                        }
                        $stock_stmt->close();
                    }
                    
                    // Generate a unique cart item ID (product_id and size combination)
                    $cart_item_id = $product_id . '_' . ($size ? $size : 'default');
                    
                    // Check if this item is already in cart
                    $item_exists = false;
                    foreach ($_SESSION['cart'] as $key => $item) {
                        if ($item['cart_item_id'] === $cart_item_id) {
                            // Update quantity
                            $_SESSION['cart'][$key]['quantity'] += $quantity;
                            $item_exists = true;
                            break;
                        }
                    }
                    
                    if (!$item_exists) {
                        // Add new item to cart
                        $_SESSION['cart'][] = [
                            'cart_item_id' => $cart_item_id,
                            'product_id' => $product_id,
                            'name' => $product_name,
                            'price' => $price,
                            'quantity' => $quantity,
                            'size' => $size,
                            'image' => $product['image']
                        ];
                    }
                    
                    $message = '✅ Item added to your cart successfully!';
                }
                $stmt->close();
            } else {
                $message = '❌ Database error. Please try again later.';
            }
        }
    } else {
        $message = '❌ Missing required product information.';
    }
    
    // Set message and redirect
    $_SESSION['message'] = ['type' => 'success', 'text' => $message];
    header('Location: cart.php');
    exit;
} else {
    // If accessed directly without POST data
    $_SESSION['message'] = ['type' => 'error', 'text' => '❌ Invalid request.'];
    header('Location: products.php');
    exit;
}
?>
