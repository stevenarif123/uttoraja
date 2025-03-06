<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

// Handle status updates
if (isset($_POST['update_status'])) {
    $stmt = $conn->prepare("UPDATE Orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $_POST['status'], $_POST['order_id']);
    $stmt->execute();
}

// Fetch all orders with user details
$query = "SELECT o.*, u.name as customer_name, u.nim, u.role,
          GROUP_CONCAT(CONCAT(oi.quantity, 'x ', p.name) SEPARATOR ', ') as items,
          SUM(oi.quantity * oi.price) as total_amount
          FROM Orders o
          LEFT JOIN Users u ON o.user_id = u.id
          LEFT JOIN Order_Items oi ON o.id = oi.order_id
          LEFT JOIN Products p ON oi.product_id = p.id
          GROUP BY o.id
          ORDER BY o.order_date DESC";

$result = $conn->query($query);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background: #f5f5f5; }
        .pending { color: orange; }
        .completed { color: green; }
        .canceled { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Management</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td>
                        <?php echo htmlspecialchars($order['customer_name']); ?>
                        <?php if ($order['role'] == 'student'): ?>
                            <br>(NIM: <?php echo $order['nim']; ?>)
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($order['items']); ?></td>
                    <td>Rp <?php echo number_format($order['total_amount'], 0, ',', '.'); ?></td>
                    <td class="<?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="canceled" <?php echo $order['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
