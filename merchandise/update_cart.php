<?php
session_start();

if (isset($_POST['product_name'])) {
    $product_name = $_POST['product_name'];

    if (isset($_POST['delete'])) {
        // Delete item from cart
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['name'] === $product_name) {
                unset($_SESSION['cart'][$index]);
                break;
            }
        }
    } elseif (isset($_POST['quantity'])) {
        // Update quantity
        $new_quantity = (int)$_POST['quantity'];
        $new_quantity = max(0, $new_quantity); // Prevent negative quantities

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $product_name) {
                if ($new_quantity > 0) {
                    $item['quantity'] = $new_quantity;
                } else {
                    // Remove item if quantity is set to 0
                    unset($_SESSION['cart'][array_search($item, $_SESSION['cart'])]);
                }
                break;
            }
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}

header('Location: cart.php');
exit;
?>