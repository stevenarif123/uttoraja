<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

// Fetch basic statistics
$result = $conn->query("SELECT COUNT(*) as total FROM Orders");
$totalOrders = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) as total FROM Products");
$totalProducts = $result->fetch_assoc()['total'];

// Get pending orders count
$result = $conn->query("SELECT COUNT(*) as total FROM Orders WHERE status = 'pending'");
$pendingOrders = $result->fetch_assoc()['total'];

// Get total users count
$result = $conn->query("SELECT COUNT(*) as total FROM Users");
$totalUsers = $result->fetch_assoc()['total'];

// Get recent orders
$result = $conn->query("
    SELECT o.*, u.name as customer_name
    FROM Orders o
    LEFT JOIN Users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
    LIMIT 5
");
$recentOrders = $result->fetch_all(MYSQLI_ASSOC);

// Get low stock products
$result = $conn->query("
    SELECT p.name, ps.size, ps.stock
    FROM products p 
    JOIN product_sizes ps ON p.id = ps.product_id 
    WHERE ps.stock < 10
    ORDER BY ps.stock ASC
    LIMIT 5
");
$lowStockProducts = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                        <a href="index.php" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="products.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                            <i class="fas fa-box mr-2"></i>Products
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
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
                    <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4">Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> 👋</span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_name']); ?>&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome to UTToraja Merchandise Dashboard! 🚀</h2>
                    <p class="text-gray-600">Here's what's happening with your store today.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Orders -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-shopping-bag text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Orders</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $totalOrders; ?></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="orders.php" class="text-sm text-blue-600 hover:text-blue-800">View all orders →</a>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $pendingOrders; ?></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="orders.php" class="text-sm text-yellow-600 hover:text-yellow-800">Process orders →</a>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-box text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $totalProducts; ?></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="products.php" class="text-sm text-green-600 hover:text-green-800">View all products →</a>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Registered Users</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $totalUsers; ?></p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="users.php" class="text-sm text-purple-600 hover:text-purple-800">View all users →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders & Low Stock -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Orders -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Recent Orders 📊</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-full">
                                <thead>
                                    <tr class="text-left text-xs font-semibold text-gray-500 bg-gray-50">
                                        <th class="px-6 py-3">Order ID</th>
                                        <th class="px-6 py-3">Customer</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php if (empty($recentOrders)): ?>
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-sm text-center text-gray-500">No recent orders found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentOrders as $order): ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm text-gray-600">#<?php echo $order['id']; ?></td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($order['customer_name'] ?? 'Guest'); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        <?php 
                                                        switch($order['status']) {
                                                            case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                                            case 'completed': echo 'bg-green-100 text-green-800'; break;
                                                            case 'canceled': echo 'bg-red-100 text-red-800'; break;
                                                            default: echo 'bg-gray-100 text-gray-800';
                                                        }
                                                        ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600"><?php echo date('d M Y', strtotime($order['order_date'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 text-right">
                            <a href="orders.php" class="text-sm font-medium text-blue-600 hover:text-blue-500">View all orders →</a>
                        </div>
                    </div>

                    <!-- Low Stock Alert -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Low Stock Alert ⚠️</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-full">
                                <thead>
                                    <tr class="text-left text-xs font-semibold text-gray-500 bg-gray-50">
                                        <th class="px-6 py-3">Product</th>
                                        <th class="px-6 py-3">Size</th>
                                        <th class="px-6 py-3">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php if (empty($lowStockProducts)): ?>
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-sm text-center text-gray-500">No low stock products</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($lowStockProducts as $product): ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($product['name']); ?></td>
                                                <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($product['size']); ?></td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        <?php echo $product['stock'] <= 3 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                                        <?php echo $product['stock']; ?> left
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 bg-gray-50 text-right">
                            <a href="products.php" class="text-sm font-medium text-blue-600 hover:text-blue-500">Manage inventory →</a>
                        </div>
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
