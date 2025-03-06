<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

$result = $conn->query("
    SELECT p.*, GROUP_CONCAT(CONCAT(ps.size, ':', ps.stock) SEPARATOR ', ') as size_stocks 
    FROM Products p 
    LEFT JOIN product_sizes ps ON p.id = ps.product_id 
    GROUP BY p.id 
    ORDER BY p.id DESC
");
$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background: #f5f5f5; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Product Management</h2>
        <a href="add_product.php" class="btn btn-add">Add New Product</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Student Price</th>
                    <th>Guest Price</th>
                    <th>Stock by Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <?php if (!empty($product['image'])): ?>
                            <img src="../uploads/<?php echo $product['image']; ?>" width="50">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td>Rp <?php echo number_format($product['price_student'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($product['price_guest'], 0, ',', '.'); ?></td>
                    <td>
                        <?php
                        if ($product['size_stocks']) {
                            $sizes = explode(', ', $product['size_stocks']);
                            foreach ($sizes as $size_stock) {
                                list($size, $stock) = explode(':', $size_stock);
                                echo "Size $size: $stock<br>";
                            }
                        } else {
                            echo "No stock information";
                        }
                        ?>
                    </td>
                    <td class="actions">
                        <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-edit">Edit</a>
                        <form method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
