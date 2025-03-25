<?php
require_once 'auth.php';

// Require login for this page
requireLogin();

// Get current user info
$currentUser = $auth->currentUser();

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'Semua field harus diisi.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Password baru dan konfirmasi password tidak sama.';
    } elseif (strlen($newPassword) < 8) {
        $error = 'Password baru harus minimal 8 karakter.';
    } else {
        $result = $auth->changePassword($currentUser['username'], $oldPassword, $newPassword);
        
        if ($result) {
            $success = 'Password berhasil diubah.';
        } else {
            $error = 'Password lama tidak valid.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - Admin UT Toraja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar bg-blue-800 text-white w-64 py-4 px-6">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">UT Toraja</h1>
                <p class="text-blue-200 text-sm">Admin Panel</p>
            </div>
            
            <nav>
                <ul>
                    <li class="mb-2">
                        <a href="index.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 text-blue-200 hover:text-white transition duration-200">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="../list/pendaftar.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 text-blue-200 hover:text-white transition duration-200">
                            <i class="fas fa-users w-6"></i>
                            <span>Pendaftar</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="change-password.php" class="flex items-center p-2 rounded-lg bg-blue-900 text-white">
                            <i class="fas fa-key w-6"></i>
                            <span>Ubah Password</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="login.php?logout=1" class="flex items-center p-2 rounded-lg hover:bg-red-600 text-blue-200 hover:text-white transition duration-200">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm py-4 px-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Ubah Password</h2>
                    
                    <div class="flex items-center">
                        <div class="mr-4 text-sm text-gray-600">
                            <i class="fas fa-user-circle mr-1"></i>
                            <?php echo htmlspecialchars($currentUser['name']); ?>
                        </div>
                        <a href="login.php?logout=1" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Change Password Content -->
            <main class="p-6">
                <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Ubah Password</h3>
                    
                    <?php if ($error): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p><?php echo $error; ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p><?php echo $success; ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="change-password.php">
                        <div class="mb-4">
                            <label for="old_password" class="block text-gray-700 text-sm font-bold mb-2">
                                <i class="fas fa-lock mr-2"></i>Password Lama
                            </label>
                            <div class="relative">
                                <input type="password" id="old_password" name="old_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-600" data-target="old_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">
                                <i class="fas fa-key mr-2"></i>Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-600" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter</p>
                        </div>
                        
                        <div class="mb-6">
                            <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">
                                <i class="fas fa-check-double mr-2"></i>Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="confirm_password" name="confirm_password" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 px-3 flex items-center text-gray-600" data-target="confirm_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const passwordIcon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
