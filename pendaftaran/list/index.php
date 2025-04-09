<?php
require_once 'auth.php';
requireLogin();

// Set page title for navbar
$pageTitle = 'Dashboard';

// API URL with HTTPS
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
    
    // Calculate new registrations (last 7 days)
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
        
        // Count by faculty/jurusan
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
    
    // Get latest registrations for display - sort by ID in descending order
    usort($data, function($a, $b) {
        return $b['id'] - $a['id']; // Sort by ID descending
    });
    $latestPendaftar = array_slice($data, 0, 5); // Get 5 latest entries
    
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
    <style>
        /* Added fixed height and scrolling for content */
        .layout-container {
            min-height: 100vh;
            display: flex;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem; /* w-64 = 16rem */
            overflow-y: auto;
            z-index: 40;
        }
        
        .main-content {
            margin-left: 16rem; /* Same as sidebar width */
            width: calc(100% - 16rem);
            min-height: 100vh;
        }
        
        .content-container {
            padding: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="layout-container">
        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>
            
            <!-- Dashboard Content -->
            <div class="content-container">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Stats Card 1 -->
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
                    
                    <!-- Stats Card 2 -->
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
                    
                    <!-- Stats Card 3 -->
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
                        <a href="pendaftar.php" class="flex items-center p-3 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition duration-200">
                            <i class="fas fa-list mr-2"></i>
                            <span>Lihat Daftar Pendaftar</span>
                        </a>
                        <a href="pendaftar.php?action=add" class="flex items-center p-3 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span>Tambah Pendaftar Baru</span>
                        </a>
                        <a href="#" class="flex items-center p-3 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 rounded-lg transition duration-200">
                            <i class="fas fa-chart-bar mr-2"></i>
                            <span>Laporan Pendaftaran</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Registrations table -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Pendaftar Terbaru</h3>
                        <a href="pendaftar.php" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
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
                                                    <button onclick="showDetail(<?php echo $pendaftar['id']; ?>)" 
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
            window.location.href = `pendaftar.php?action=view&id=${id}`;
        }

        // Function to get greeting based on time of day
        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat pagi";
            if (hour < 15) return "Selamat siang";
            if (hour < 18) return "Selamat sore";
            return "Selamat malam";
        }

        // Function to format phone number
        function formatPhoneNumber(phone) {
            let formattedPhone = phone.replace(/\D/g, '');
            if (!formattedPhone.startsWith('62')) {
                formattedPhone = formattedPhone.startsWith('0') 
                    ? '62' + formattedPhone.substring(1) 
                    : '62' + formattedPhone;
            }
            return formattedPhone;
        }

        // Function to send WhatsApp message
        function sendWhatsApp(phone, nama) {
            const formattedPhone = formatPhoneNumber(phone);
            const message = `${getGreeting()}, ${nama}\n\nterima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:\n\n1. Membayar uang pendaftaran sebesar Rp. 200.000 ke nomor rekening berikut:\nNama: Ribka Padang (Kepala SALUT Tana Toraja)\nBank: Mandiri\nNomor Rekening: 1700000588917\n\n2. Melengkapi berkas data diri berupa:\n- Foto diri Formal (dapat menggunakan foto HP)\n- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)\n- Foto ijazah asli\n- Mengisi formulir Keabsahan Data (dikirimkan)`;
            window.open(`https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`, '_blank');
        }
    </script>
</body>
</html>
