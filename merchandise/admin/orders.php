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
    if ($stmt->execute()) {
        $success_message = "Order status updated successfully! 🎉";
    } else {
        $error_message = "Failed to update order status. Please try again. 😞";
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 py-6 flex-shrink-0 hidden md:block">
        <div class="px-6">
            <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="products.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-box mr-2"></i>Products
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
                            <i class="fas fa-shopping-cart mr-2"></i>Orders
                        </a>
                    </li>
                    <li>
                        <a href="users.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-users mr-2"></i>Users
                        </a>
                    </li>
                    <li>
                        <a href="settings.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top navbar -->
        <header class="bg-white shadow-sm z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <button class="md:hidden mr-4 text-gray-500 hover:text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">Order Management</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4"><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Order List 📦</h2>
                </div>

                <?php if (isset($success_message)): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                        <p class="font-bold">Success! 🎉</p>
                        <p><?php echo $success_message; ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <p class="font-bold">Error! ⚠️</p>
                        <p><?php echo $error_message; ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500 bg-gray-100 border-b border-gray-200">
                                    <th class="px-6 py-3">Order ID</th>
                                    <th class="px-6 py-3">Customer</th>
                                    <th class="px-6 py-3">Items</th>
                                    <th class="px-6 py-3">Total</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Order Date</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-600">#<?php echo $order['id']; ?></td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-gray-900"><?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></div>
                                        <?php if (!empty($order['nim'])): ?>
                                            <div class="text-xs text-gray-500">NIM: <?php echo $order['nim']; ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($order['role'])): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo $order['role'] == 'student' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'; ?>">
                                                <?php echo ucfirst($order['role']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate"><?php echo htmlspecialchars($order['items'] ?? 'No items'); ?></td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp <?php echo number_format($order['total_amount'] ?? 0, 0, ',', '.'); ?></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                            <?php 
                                            switch($order['status']) {
                                                case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                                case 'completed': echo 'bg-green-100 text-green-800'; break;
                                                case 'canceled': echo 'bg-red-100 text-red-800'; break;
                                                default: echo 'bg-gray-100 text-gray-800';
                                            }
                                            ?>">
                                            <?php 
                                            switch($order['status']) {
                                                case 'pending': echo '⏳ '; break;
                                                case 'completed': echo '✅ '; break;
                                                case 'canceled': echo '❌ '; break;
                                                default: echo '❓ ';
                                            }
                                            echo ucfirst($order['status']); 
                                            ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo date('d M Y H:i', strtotime($order['order_date'])); ?></td>
                                    <td class="px-6 py-4">
                                        <form method="POST" class="flex items-center space-x-2">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="canceled" <?php echo $order['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                            </select>
                                            <button type="submit" name="update_status" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        No orders found. 📭
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-sm text-center text-gray-500">© 2025 UTToraja Merchandise Admin Panel. All rights reserved. 🛒</p>
            </div>
        </footer>
    </div>
    
    <script>
        // Mobile navigation toggle
        document.querySelector('.md\\:hidden').addEventListener('click', function() {
            const sidebar = document.querySelector('.bg-gray-800');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('fixed');
            sidebar.classList.toggle('inset-0');
            sidebar.classList.toggle('z-40');
            sidebar.classList.toggle('w-64');
        });
    </script>
</body>
</html>
