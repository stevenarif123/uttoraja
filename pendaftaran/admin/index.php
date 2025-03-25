<?php
require_once 'auth.php';

// Require login for this page
requireLogin();

// Get current user info
$currentUser = $auth->currentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UT Toraja</title>
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
                        <a href="index.php" class="flex items-center p-2 rounded-lg bg-blue-900 text-white">
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
                        <a href="change-password.php" class="flex items-center p-2 rounded-lg hover:bg-blue-700 text-blue-200 hover:text-white transition duration-200">
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
                    <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                    
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
            
            <!-- Dashboard Content -->
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Stats Card 1 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Total Pendaftar</h3>
                                <p class="text-3xl font-bold text-gray-800">127</p>
                            </div>
                            <div class="bg-blue-500 text-white p-3 rounded-full">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span>12% dari bulan lalu</span>
                        </p>
                    </div>
                    
                    <!-- Stats Card 2 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Pendaftar Baru</h3>
                                <p class="text-3xl font-bold text-gray-800">18</p>
                            </div>
                            <div class="bg-green-500 text-white p-3 rounded-full">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span>5 pendaftar hari ini</span>
                        </p>
                    </div>
                    
                    <!-- Stats Card 3 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Fakultas Terpopuler</h3>
                                <p class="text-3xl font-bold text-gray-800">FKIP</p>
                            </div>
                            <div class="bg-purple-500 text-white p-3 rounded-full">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">
                            <span>42 pendaftar semester ini</span>
                        </p>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tindakan Cepat</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="../list/pendaftar.php" class="flex items-center p-3 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition duration-200">
                            <i class="fas fa-list mr-2"></i>
                            <span>Lihat Daftar Pendaftar</span>
                        </a>
                        <a href="../list/pendaftar.php" class="flex items-center p-3 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span>Tambah Pendaftar Baru</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg transition duration-200">
                            <i class="fas fa-chart-bar mr-2"></i>
                            <span>Laporan Pendaftaran</span>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Registrations -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Pendaftar Terbaru</h3>
                        <a href="../list/pendaftar.php" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Andi Sulaiman</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Manajemen</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2023-05-15</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Budi Santoso</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Akuntansi</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2023-05-14</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Citra Amalia</td>
                                    <td class="px-6 py-4 whitespace-nowrap">PGSD</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2023-05-13</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">Diana Putri</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Ilmu Komunikasi</td>
                                    <td class="px-6 py-4 whitespace-nowrap">2023-05-12</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Belum Bayar</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
