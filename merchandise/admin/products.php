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
                        <a href="products.php" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
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
                    <h1 class="text-lg font-semibold text-gray-900">Product Management</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4">Admin</span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Products</h2>
                    <a href="add_product.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i>Add New Product
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500 bg-gray-100 border-b border-gray-200">
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Image</th>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Description</th>
                                    <th class="px-6 py-3">Student Price</th>
                                    <th class="px-6 py-3">Guest Price</th>
                                    <th class="px-6 py-3">Stock by Size</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($products as $product): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo $product['id']; ?></td>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($product['image'])): ?>
                                            <img src="../uploads/<?php echo $product['image']; ?>" alt="Product" class="h-12 w-12 object-cover rounded">
                                        <?php else: ?>
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate"><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp <?php echo number_format($product['price_student'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">Rp <?php echo number_format($product['price_guest'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php
                                        if ($product['size_stocks']) {
                                            $sizes = explode(', ', $product['size_stocks']);
                                            foreach ($sizes as $size_stock) {
                                                list($size, $stock) = explode(':', $size_stock);
                                                echo "<span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1'>
                                                        $size: $stock
                                                    </span>";
                                            }
                                        } else {
                                            echo "<span class='text-red-500'>No stock information</span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                                <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                        No products found. <a href="add_product.php" class="text-blue-600 hover:underline">Add your first product</a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
