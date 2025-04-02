<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

// Get current admin info
$admin_id = $_SESSION['admin_id'];
$admin = null;

$stmt = $conn->prepare("SELECT id, username, name, created_at FROM Admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

// Handle profile update
$success_message = '';
$error_message = '';

if (isset($_POST['update_profile'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    
    // Check if username already exists but isn't the current user
    $check = $conn->prepare("SELECT id FROM Admins WHERE username = ? AND id <> ?");
    $check->bind_param("si", $username, $admin_id);
    $check->execute();
    $username_exists = $check->get_result()->num_rows > 0;
    
    if ($username_exists) {
        $error_message = "Username already exists. Please choose another one. ⚠️";
    } else {
        // Update profile
        $stmt = $conn->prepare("UPDATE Admins SET name = ?, username = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $username, $admin_id);
        
        if ($stmt->execute()) {
            $_SESSION['admin_name'] = $name; // Update session
            $success_message = "Profile updated successfully! 🎉";
            
            // Refresh admin data
            $stmt = $conn->prepare("SELECT id, username, name, created_at FROM Admins WHERE id = ?");
            $stmt->bind_param("i", $admin_id);
            $stmt->execute();
            $admin = $stmt->get_result()->fetch_assoc();
        } else {
            $error_message = "Error updating profile. Please try again. 😞";
        }
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM Admins WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $current_hash = $result['password'];
    
    if (!password_verify($current_password, $current_hash)) {
        $error_message = "Current password is incorrect. 🔐";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match. ⚠️";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Password must be at least 6 characters long. ⚠️";
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE Admins SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $admin_id);
        
        if ($stmt->execute()) {
            $success_message = "Password updated successfully! 🔒";
        } else {
            $error_message = "Error updating password. Please try again. 😞";
        }
    }
}

// Handle site settings update
if (isset($_POST['update_settings'])) {
    // This would normally update a settings table
    // For demo purposes, we'll just show success
    $success_message = "Store settings updated successfully! ⚙️";
}

// Get store settings (in a real app, this would come from database)
$store_settings = [
    'site_name' => 'UTToraja Merchandise',
    'contact_email' => 'store@uttoraja.ac.id',
    'phone' => '+62 123 456 789',
    'address' => 'Jl. Kampus Universitas Toraja, Indonesia',
    'currency' => 'Rp',
    'tax_rate' => 10,
    'shipping_fee_standard' => 10000,
    'shipping_fee_express' => 20000
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
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
                    <h1 class="text-lg font-semibold text-gray-900">Settings</h1>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4"><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_name'] ?? 'Admin'); ?>&background=0D8ABC&color=fff" alt="Admin">
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Settings & Configuration ⚙️</h2>
                    <p class="text-gray-600">Manage your account and store settings</p>
                </div>

                <?php if ($success_message): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                        <p class="font-bold">Success! 🎉</p>
                        <p><?php echo $success_message; ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <p class="font-bold">Error! ⚠️</p>
                        <p><?php echo $error_message; ?></p>
                    </div>
                <?php endif; ?>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Admin Profile 👤</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 flex flex-col items-center mb-6 md:mb-0">
                                <div class="h-32 w-32 rounded-full bg-blue-600 flex items-center justify-center mb-4">
                                    <span class="text-4xl text-white font-bold"><?php echo substr($_SESSION['admin_name'] ?? 'A', 0, 1); ?></span>
                                </div>
                                <p class="text-xl font-semibold"><?php echo htmlspecialchars($admin['name'] ?? ''); ?></p>
                                <p class="text-sm text-gray-500">Administrator</p>
                                <p class="text-sm text-gray-500 mt-1">Member since <?php echo date('M Y', strtotime($admin['created_at'] ?? 'now')); ?></p>
                            </div>
                            
                            <div class="md:w-2/3 md:pl-8">
                                <form method="POST" class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($admin['name'] ?? ''); ?>"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                        <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    </div>
                                    
                                    <div>
                                        <button type="submit" name="update_profile"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-save mr-2"></i> Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Security Settings 🔒</h3>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST" class="space-y-6 max-w-lg">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Enter your current password">
                            </div>
                            
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Enter new password">
                            </div>
                            
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Confirm new password">
                            </div>
                            
                            <div>
                                <button type="submit" name="change_password"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-key mr-2"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Store Settings 🏪</h3>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700">Store Name</label>
                                    <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($store_settings['site_name']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($store_settings['contact_email']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($store_settings['phone']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Store Address</label>
                                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($store_settings['address']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency Symbol</label>
                                    <input type="text" id="currency" name="currency" value="<?php echo htmlspecialchars($store_settings['currency']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="tax_rate" class="block text-sm font-medium text-gray-700">Tax Rate (%)</label>
                                    <input type="number" id="tax_rate" name="tax_rate" value="<?php echo htmlspecialchars($store_settings['tax_rate']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="shipping_fee_standard" class="block text-sm font-medium text-gray-700">Standard Shipping Fee (Rp)</label>
                                    <input type="number" id="shipping_fee_standard" name="shipping_fee_standard" value="<?php echo htmlspecialchars($store_settings['shipping_fee_standard']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <div>
                                    <label for="shipping_fee_express" class="block text-sm font-medium text-gray-700">Express Shipping Fee (Rp)</label>
                                    <input type="number" id="shipping_fee_express" name="shipping_fee_express" value="<?php echo htmlspecialchars($store_settings['shipping_fee_express']); ?>"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div class="pt-5">
                                <button type="submit" name="update_settings"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i> Save Store Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="create_admin.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-user-plus mr-2"></i> Create New Admin Account
                    </a>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-sm text-center text-gray-500">© 2025 UTToraja Merchandise Admin Panel. All rights reserved. ⚙️</p>
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
        
        // Password validation
        document.querySelector('form[name="change_password"]')?.addEventListener('submit', function(event) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                event.preventDefault();
                alert('New passwords do not match! Please try again. ⚠️');
            } else if (newPassword.length < 6) {
                event.preventDefault();
                alert('Password must be at least 6 characters long! ⚠️');
            }
        });
    </script>
</body>
</html>
