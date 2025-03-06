<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];
    $size = isset($_POST['size']) ? $_POST['size'] : null;
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Create unique key for product+size combination
    $cart_key = $product_id . (isset($_POST['size']) ? '_' . $_POST['size'] : '');

    // Check if product with same size exists
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id && (!$size || $item['size'] == $size)) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity,
            'size' => $size
        );
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
