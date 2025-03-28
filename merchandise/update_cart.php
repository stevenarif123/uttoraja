<?php
session_start();
include 'koneksi.php';

// Periksa jika pengguna sudah login atau tamu
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Periksa jika ada data POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    $response = ['success' => false, 'message' => ''];

    if (!$item_id || !$quantity) {
        $response['message'] = 'Data tidak valid';
        echo json_encode($response);
        exit;
    }

    // Perbarui kuantitas di keranjang
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['cart_item_id'] === $item_id) {
                // Periksa stok sebelum memperbarui
                if (isset($item['size'])) {
                    $stmt = $conn->prepare("SELECT stock FROM product_sizes WHERE product_id = ? AND size = ?");
                    $stmt->bind_param('is', $item['product_id'], $item['size']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $stock = $result->fetch_assoc()['stock'];
                        if ($quantity > $stock) {
                            $response['message'] = "Stok tidak mencukupi. Stok tersedia: $stock";
                            echo json_encode($response);
                            exit;
                        }
                    }
                }
                
                $item['quantity'] = $quantity;
                $response['success'] = true;
                $response['message'] = 'Keranjang berhasil diperbarui';
                $response['total'] = number_format($item['price'] * $quantity, 0, ',', '.');
                break;
            }
        }
    }

    echo json_encode($response);
    exit;
}

// Jika bukan request POST, redirect ke halaman keranjang
header('Location: cart.php');
exit;
?>