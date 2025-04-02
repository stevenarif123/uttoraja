<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

// Handle user status toggle
$success_message = '';
$error_message = '';

if (isset($_POST['toggle_status'])) {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $new_status = $_POST['new_status'] === '1' ? 1 : 0;
    
    if ($user_id) {
        try {
            $stmt = $conn->prepare("UPDATE Users SET active = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_status, $user_id);
            
            if ($stmt->execute()) {
                $status_text = $new_status ? 'activated' : 'deactivated';
                $success_message = "User account successfully $status_text! 🎉";
            } else {
                throw new Exception("Database error");
            }
        } catch (Exception $e) {
            $error_message = "Error updating user status: " . $e->getMessage() . " 😞";
        }
    }
}

// Filtering and search
$role_filter = isset($_GET['role']) ? $_GET['role'] : '';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

// Build query based on filters
$query = "SELECT * FROM Users WHERE 1=1";

if (!empty($role_filter)) {
    $query .= " AND role = '$role_filter'";
}

if (!empty($search_term)) {
    $query .= " AND (name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR nim LIKE '%$search_term%')";
}

$query .= " ORDER BY id DESC";

$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Get user statistics
$total_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN role = 'student' THEN 1 ELSE 0 END) as students,
    SUM(CASE WHEN role = 'guest' THEN 1 ELSE 0 END) as guests
    FROM Users";
$stats = $conn->query($total_query)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
                        <a href="users.php" class="block py-2.5 px-4 rounded bg-blue-600 text-white">
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
                    <h1 class="text-lg font-semibold text-gray-900">User Management</h1>
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
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Registered Users 👥</h2>
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

                <!-- User Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Users</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $stats['total'] ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-indigo-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                <i class="fas fa-user-graduate text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Students</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $stats['students'] ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Guests</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo $stats['guests'] ?? 0; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filter and Search -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <form method="GET" class="flex flex-wrap gap-4 items-end">
                        <div class="w-full md:w-auto">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Filter by Role</label>
                            <select id="role" name="role" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">All Users</option>
                                <option value="student" <?php echo ($role_filter === 'student') ? 'selected' : ''; ?>>Students</option>
                                <option value="guest" <?php echo ($role_filter === 'guest') ? 'selected' : ''; ?>>Guests</option>
                            </select>
                        </div>
                        
                        <div class="w-full md:w-auto flex-grow">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Users</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>"
                                    class="block w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Search by name, email or NIM">
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button type="submit" class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-filter mr-2"></i> Apply Filters
                            </button>
                            
                            <a href="users.php" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-times mr-2"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500 bg-gray-100 border-b border-gray-200">
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Role</th>
                                    <th class="px-6 py-3">NIM</th>
                                    <th class="px-6 py-3">Birth Date</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                        No users found. 🔍
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo $user['id']; ?></td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $user['role'] == 'student' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'; ?>">
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo !empty($user['nim']) ? $user['nim'] : '-'; ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo date('d M Y', strtotime($user['tanggal_lahir'])); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo isset($user['active']) && $user['active'] == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                                <?php echo isset($user['active']) && $user['active'] == 1 ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <form method="POST" class="inline-flex">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="new_status" value="<?php echo isset($user['active']) && $user['active'] == 1 ? '0' : '1'; ?>">
                                                <button type="submit" name="toggle_status" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white <?php echo isset($user['active']) && $user['active'] == 1 ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'; ?> focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <?php echo isset($user['active']) && $user['active'] == 1 ? '<i class="fas fa-user-slash mr-2"></i> Deactivate' : '<i class="fas fa-user-check mr-2"></i> Activate'; ?>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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
                <p class="text-sm text-center text-gray-500">© 2025 UTToraja Merchandise Admin Panel. All rights reserved. 👥</p>
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
