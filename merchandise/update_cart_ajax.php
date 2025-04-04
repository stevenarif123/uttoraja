<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Initialize response with more detailed price information
$response = [
    'success' => false,
    'message' => '',
    'cart_total' => 0,
    'item_count' => 0,
    'item_total' => 0,
    'formatted_cart_total' => '',
    'formatted_item_total' => '',
    'item_price' => 0,
    'formatted_item_price' => ''
];

// Handle AJAX update requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_item_id']) && isset($_POST['quantity'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $new_quantity = (int)$_POST['quantity'];
    
    if ($new_quantity <= 0) {
        // Remove item if quantity is 0 or negative
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['cart_item_id'] === $cart_item_id) {
                unset($_SESSION['cart'][$key]);
                $response['success'] = true;
                $response['message'] = 'Item removed from cart';
                break;
            }
        }
        // Re-index the array after removal
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    } else {
        // Update quantity
        $item_updated = false;
        $stock_available = true;
        $price_item = 0;
        $individual_price = 0;
        
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['cart_item_id'] === $cart_item_id) {
                // Check stock availability before updating
                if (isset($item['size'])) {
                    $stock_stmt = $conn->prepare("SELECT stock FROM product_sizes WHERE product_id = ? AND size = ?");
                    if ($stock_stmt) {
                        $stock_stmt->bind_param('is', $item['product_id'], $item['size']);
                        $stock_stmt->execute();
                        $stock_result = $stock_stmt->get_result();
                        
                        if ($stock_result->num_rows > 0) {
                            $stock_row = $stock_result->fetch_assoc();
                            if ($stock_row['stock'] < $new_quantity) {
                                $response['success'] = false;
                                $response['message'] = 'Not enough stock available. Only ' . $stock_row['stock'] . ' items left.';
                                $stock_available = false;
                                break;
                            }
                        }
                        $stock_stmt->close();
                    }
                }
                
                if ($stock_available) {
                    $_SESSION['cart'][$key]['quantity'] = $new_quantity;
                    $item_updated = true;
                    $individual_price = $_SESSION['cart'][$key]['price'];
                    $price_item = $individual_price * $new_quantity;
                    $response['item_total'] = $price_item;
                    $response['item_price'] = $individual_price;
                    break;
                }
            }
        }
        
        if ($item_updated) {
            $response['success'] = true;
            $response['message'] = 'Cart updated successfully';
        }
    }
    
    // Calculate new cart totals
    $cart_total = 0;
    $item_count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
        $item_count += $item['quantity'];
    }
    
    $response['cart_total'] = $cart_total;
    $response['item_count'] = $item_count;
    $response['formatted_cart_total'] = number_format($cart_total, 0, ',', '.');
    $response['formatted_item_total'] = number_format($response['item_total'], 0, ',', '.');
    $response['formatted_item_price'] = isset($response['item_price']) ? number_format($response['item_price'], 0, ',', '.') : '';
}

echo json_encode($response);
exit;
