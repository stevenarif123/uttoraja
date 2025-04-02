<?php
session_start();
require_once '../koneksi.php';

// Check if admin is logged in (for security)
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    
    // Validation
    if (empty($username) || empty($password) || empty($name)) {
        $message = "All fields are required! 📝";
        $message_type = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match! ⚠️";
        $message_type = "error";
    } else {
        try {
            // Check if username already exists
            $check = $conn->prepare("SELECT id FROM Admins WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $result = $check->get_result();
            
            if ($result->num_rows > 0) {
                $message = "Username already exists! Please choose another username. ⚠️";
                $message_type = "error";
            } else {
                // Hash password and create admin
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO Admins (username, password, name) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hashed_password, $name);
                
                if ($stmt->execute()) {
                    $message = "Admin account created successfully! 🎉";
                    $message_type = "success";
                    
                    // Clear the form after successful submission
                    $username = $password = $confirm_password = $name = "";
                } else {
                    $message = "Error creating admin account: " . $conn->error . " 😞";
                    $message_type = "error";
                }
            }
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage() . " 😞";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin Account</title>
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
                        <a href="settings.php" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
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
                    <h1 class="text-lg font-semibold text-gray-900">Create Admin Account</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4"><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_name'] ?? 'Admin'); ?>&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-sm overflow-hidden">
                <?php if ($message): ?>
                    <div class="<?php echo $message_type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'; ?> p-4 mb-4 border-l-4" role="alert">
                        <p class="font-bold"><?php echo $message_type === 'success' ? 'Success!' : 'Error!'; ?></p>
                        <p><?php echo $message; ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="rounded-full bg-blue-100 p-3">
                            <i class="fas fa-user-plus text-3xl text-blue-600"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">Create New Admin 👤</h2>
                    
                    <form method="POST" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="name" type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter full name">
                            </div>
                        </div>
                        
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-at text-gray-400"></i>
                                </div>
                                <input id="username" type="text" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Choose a username">
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" type="password" name="password" required
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Enter password">
                            </div>
                        </div>
                        
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="confirm_password" type="password" name="confirm_password" required
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Confirm password">
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-plus-circle mr-2"></i> Create Admin Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-sm text-center text-gray-500">© 2025 UTToraja Merchandise Admin Panel. All rights reserved. 🔒</p>
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
        
        // Password confirmation validation
        document.querySelector('form').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Passwords do not match! Please try again.');
            }
        });
    </script>
</body>
</html>
