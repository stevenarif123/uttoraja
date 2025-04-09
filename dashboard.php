<?php
require_once 'auth.php';
requireLogin();

// Set page title for navbar
$pageTitle = 'Dashboard';

// Update API URL to use HTTPS instead of HTTP
$apiUrl = 'https://uttoraja.com/pendaftaran/api/pendaftar';

// Add error handling for API call with cURL
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For development only
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    
    curl_close($ch);
    
    if ($httpCode !== 200) {
        throw new Exception("HTTP Error: " . $httpCode);
    }
    
    return $response;
}

try {
    $response = fetchData($apiUrl);
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Failed to parse JSON response");
    }
    
    // Get statistics
    $totalPendaftar = count($data);
    $newRegistrations = 0;
    $todayRegistrations = 0;
    $now = time();
    $oneWeekAgo = $now - (7 * 24 * 60 * 60);
    $today = strtotime(date('Y-m-d'));
    
    // Count faculties
    $faculties = [];
    
    foreach($data as $pendaftar) {
        $registrationDate = strtotime($pendaftar['created_at'] ?? date('Y-m-d'));
        
        if ($registrationDate >= $oneWeekAgo) {
            $newRegistrations++;
        }
        
        if ($registrationDate >= $today) {
            $todayRegistrations++;
        }
        
        if (!empty($pendaftar['jurusan'])) {
            $faculty = $pendaftar['jurusan'];
            if (!isset($faculties[$faculty])) {
                $faculties[$faculty] = 0;
            }
            $faculties[$faculty]++;
        }
    }
    
    // Find most popular faculty
    $popularFaculty = '';
    $popularFacultyCount = 0;
    foreach ($faculties as $faculty => $count) {
        if ($count > $popularFacultyCount) {
            $popularFaculty = $faculty;
            $popularFacultyCount = $count;
        }
    }
    
    // Get latest registrations for display
    $latestPendaftar = array_slice($data, 0, 4);
    
} catch (Exception $e) {
    $data = [];
    $error_message = $e->getMessage();
    $totalPendaftar = 0;
    $newRegistrations = 0;
    $todayRegistrations = 0;
    $popularFaculty = 'N/A';
    $popularFacultyCount = 0;
    $latestPendaftar = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UT Toraja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>
            
            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Stats Card 1: Total Pendaftar -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Total Pendaftar</h3>
                                <p class="text-3xl font-bold text-gray-800"><?php echo $totalPendaftar; ?></p>
                            </div>
                            <div class="bg-blue-500 text-white p-3 rounded-full">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span><?php echo $newRegistrations; ?> pendaftar minggu ini</span>
                        </p>
                    </div>
                    
                    <!-- Stats Card 2: New Registrations -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Pendaftar Baru</h3>
                                <p class="text-3xl font-bold text-gray-800"><?php echo $newRegistrations; ?></p>
                            </div>
                            <div class="bg-green-500 text-white p-3 rounded-full">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-green-500">
                            <i class="fas fa-arrow-up mr-1"></i>
                            <span><?php echo $todayRegistrations; ?> pendaftar hari ini</span>
                        </p>
                    </div>
                    
                    <!-- Stats Card 3: Popular Faculty -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-gray-500 text-sm uppercase">Fakultas Terpopuler</h3>
                                <p class="text-3xl font-bold text-gray-800"><?php echo $popularFaculty ?: 'N/A'; ?></p>
                            </div>
                            <div class="bg-purple-500 text-white p-3 rounded-full">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-600">
                            <span><?php echo $popularFacultyCount; ?> pendaftar semester ini</span>
                        </p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tindakan Cepat</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="pendaftaran/list/pendaftar.php" class="flex items-center p-3 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition duration-200">
                            <i class="fas fa-list mr-2"></i>
                            <span>Lihat Daftar Pendaftar</span>
                        </a>
                        <a href="pendaftaran/list/pendaftar.php?action=add" class="flex items-center p-3 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition duration-200">
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
                        <a href="pendaftaran/list/pendaftar.php" class="text-blue-600 hover:text-blue-800 text-sm">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">No</th>
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Nomor HP</th>
                                    <th class="py-3 px-6 text-left">Jurusan</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                <?php if (!empty($latestPendaftar)): ?>
                                    <?php foreach ($latestPendaftar as $index => $pendaftar): ?>
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-4 px-6"><?php echo $index + 1; ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nama_lengkap'] ?? '-'); ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nomor_hp'] ?? '-'); ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['jurusan'] ?? '-'); ?></td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <button onclick="showDetail('<?php echo $pendaftar['id']; ?>')" 
                                                            class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button onclick="sendWhatsApp('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap']); ?>')"
                                                            class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition duration-200">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center">Tidak ada data pendaftar terbaru</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/shared.js"></script>
    <script>
        // Simple functions for dashboard actions
        function showDetail(id) {
            window.location.href = `pendaftaran/list/pendaftar.php?action=view&id=${id}`;
        }

        function sendWhatsApp(phone, nama) {
            const message = `${getGreeting()}, ${nama}\n\nterima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja...`;
            const encodedMessage = encodeURIComponent(message);
            window.open(`https://wa.me/${phone}?text=${encodedMessage}`, '_blank');
        }

        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat pagi";
            if (hour < 15) return "Selamat siang";
            if (hour < 18) return "Selamat sore";
            return "Selamat malam";
        }
    </script>
</body>
</html>
