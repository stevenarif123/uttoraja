<?php
session_start();
require_once '../koneksi.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $price_student = filter_input(INPUT_POST, 'price_student', FILTER_VALIDATE_FLOAT);
        $price_guest = filter_input(INPUT_POST, 'price_guest', FILTER_VALIDATE_FLOAT);
        
        // Handle size options and stock
        $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
        $stocks = isset($_POST['stocks']) ? $_POST['stocks'] : [];
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
            }
        }

        $conn->begin_transaction();

        // Insert product
        $stmt = $conn->prepare("INSERT INTO Products (name, description, price_student, price_guest, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdds", $name, $description, $price_student, $price_guest, $image);
        
        if (!$stmt->execute()) {
            throw new Exception("Error adding product");
        }
        
        $product_id = $conn->insert_id;

        // Insert sizes and stock
        $stmt = $conn->prepare("INSERT INTO product_sizes (product_id, size, stock) VALUES (?, ?, ?)");
        
        foreach ($sizes as $index => $size) {
            if (!empty($size) && isset($stocks[$index]) && $stocks[$index] > 0) {
                $stmt->bind_param("isi", $product_id, $size, $stocks[$index]);
                if (!$stmt->execute()) {
                    throw new Exception("Error adding size and stock");
                }
            }
        }

        $conn->commit();
        $message = "Product added successfully! 🎉";
        $message_type = "success";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error: " . $e->getMessage() . " 😞";
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
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
                        <a href="index.php" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
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
                    <h1 class="text-lg font-semibold text-gray-900">Add New Product</h1>
                </div>
                <div class="flex items-center">
                    <a href="products.php" class="mr-4 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Products
                    </a>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_name'] ?? 'Admin'); ?>&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
                <?php if ($message): ?>
                    <div class="<?php echo $message_type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'; ?> p-4 mb-4 border-l-4" role="alert">
                        <p class="font-bold"><?php echo $message_type === 'success' ? 'Success! 🎉' : 'Error! ⚠️'; ?></p>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Product 🛍️</h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Image -->
                            <div class="md:row-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image 📷</label>
                                <div class="flex flex-col items-center">
                                    <div id="image-preview" class="h-48 w-48 rounded-lg bg-gray-200 flex items-center justify-center mb-4">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                    <label class="w-full flex flex-col items-center px-4 py-2 bg-white text-blue-600 rounded-lg shadow-sm border border-blue-600 cursor-pointer hover:bg-blue-50">
                                        <span class="mt-2 text-base leading-normal">Select Image</span>
                                        <input type="file" name="image" id="image-upload" class="hidden" accept="image/*">
                                    </label>
                                    <p class="mt-2 text-xs text-gray-500">Recommended size: 500x500px</p>
                                </div>
                            </div>
                            
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                                <input type="text" id="name" name="name" required
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter product name">
                            </div>
                            
                            <!-- Product Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea id="description" name="description" rows="4" required
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Describe your product"></textarea>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Price -->
                            <div>
                                <label for="price_student" class="block text-sm font-medium text-gray-700 mb-1">Student Price (Rp)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" id="price_student" name="price_student" min="0" required
                                        class="block w-full pl-10 pr-12 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="0">
                                </div>
                            </div>
                            
                            <!-- Guest Price -->
                            <div>
                                <label for="price_guest" class="block text-sm font-medium text-gray-700 mb-1">Guest Price (Rp)</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" id="price_guest" name="price_guest" min="0" required
                                        class="block w-full pl-10 pr-12 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sizes and Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Sizes and Stock 📊</label>
                            <div id="size-inputs" class="space-y-3">
                                <div class="size-stock-pair flex items-center space-x-3">
                                    <input type="text" name="sizes[]" placeholder="Size (e.g., S)"
                                        class="block w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <input type="number" name="stocks[]" min="0" placeholder="Stock"
                                        class="block w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <button type="button" class="remove-size text-red-600 hover:text-red-800" title="Remove size">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="addSizeStockFields()" class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus mr-2"></i> Add Size
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <a href="products.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus mr-2"></i> Create Product
                            </button>
                        </div>
                    </form>
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
        
        // Add size-stock field pairs
        function addSizeStockFields() {
            const container = document.querySelector('#size-inputs');
            const pair = document.createElement('div');
            pair.className = 'size-stock-pair flex items-center space-x-3';
            
            pair.innerHTML = `
                <input type="text" name="sizes[]" placeholder="Size (e.g., S)"
                    class="block w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <input type="number" name="stocks[]" min="0" placeholder="Stock"
                    class="block w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <button type="button" class="remove-size text-red-600 hover:text-red-800" title="Remove size">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(pair);
            
            // Add event listener to the new remove button
            pair.querySelector('.remove-size').addEventListener('click', function() {
                container.removeChild(pair);
            });
        }
        
        // Add event listeners to existing remove buttons
        document.querySelectorAll('.remove-size').forEach(button => {
            button.addEventListener('click', function() {
                const pair = this.parentNode;
                pair.parentNode.removeChild(pair);
            });
        });
        
        // Image preview functionality
        document.getElementById('image-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover rounded-lg">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
