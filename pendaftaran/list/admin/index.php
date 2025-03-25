<?php
require_once 'auth.php';

// Require login for this page
requireLogin();

// Get current user info
$currentUser = $auth->currentUser();

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
    <title>Admin Dashboard - UT Toraja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Fixed modal styles to match pendaftaran/list/index.php */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            display: none;
            overflow-y: auto;
        }
        
        .modal.show {
            display: block !important;
        }
        
        .modal-dialog {
            max-width: 800px;
            margin: 1.75rem auto;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .modal-content {
            position: relative;
            padding: 1rem;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .modal-body {
            padding: 1rem;
        }
        
        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
        }
        
        /* Loading spinner styles */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #3B82F6;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Content transition effects */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Page content container */
        #page-content {
            min-height: 500px;
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
                        <a href="#dashboard" class="flex items-center p-2 rounded-lg bg-blue-900 text-white nav-link" data-page="dashboard">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#pendaftar" class="flex items-center p-2 rounded-lg hover:bg-blue-700 text-blue-200 hover:text-white transition duration-200 nav-link" data-page="pendaftar">
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
                    <h2 id="page-title" class="text-xl font-bold text-gray-800">Dashboard</h2>
                    
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
            
            <!-- Main content area that will be dynamically replaced -->
            <div id="page-content" class="p-6">
                <!-- Dashboard content - This will be the default view -->
                <div id="dashboard-content" class="fade-in">
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
                            <a href="#pendaftar" class="flex items-center p-3 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-lg transition duration-200 nav-link" data-page="pendaftar">
                                <i class="fas fa-list mr-2"></i>
                                <span>Lihat Daftar Pendaftar</span>
                            </a>
                            <a href="#pendaftar-add" class="flex items-center p-3 bg-green-100 hover:bg-green-200 text-green-800 rounded-lg transition duration-200 nav-link" data-page="pendaftar-add">
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
                            <a href="#pendaftar" class="text-blue-600 hover:text-blue-800 text-sm nav-link" data-page="pendaftar">Lihat Semua</a>
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
                
                <!-- Loading indicator -->
                <div id="loading-spinner" class="hidden py-20 flex justify-center">
                    <div class="spinner"></div>
                </div>
                
                <!-- Pendaftar content will be loaded here dynamically -->
                <div id="pendaftar-content" class="hidden"></div>
            </div>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div id="detailModal" class="modal hidden">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pendaftar</h2>
                    <button type="button" onclick="closeModal('detailModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div id="detailContent" class="modal-body">
                    <!-- Content will be dynamically inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('detailModal')" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables and configurations
        const apiUrl = '<?php echo $apiUrl; ?>';
        const apiHeaders = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-API-KEY': 'pantanmandiri25'
        };
        
        // Store all data
        let allPendaftarData = <?php echo json_encode($data); ?>;
        
        // Function to ensure secure URLs
        function secureUrl(url) {
            if (window.location.protocol === 'https:' && url.startsWith('http:')) {
                return url.replace('http:', 'https:');
            }
            return url;
        }
        
        // Modal functions
        function openModal(modalId) {
            console.log('🔓 Opening modal:', modalId);
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.error('❌ Modal not found:', modalId);
                return;
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('show');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            console.log('🔒 Closing modal:', modalId);
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.error('❌ Modal not found:', modalId);
                return;
            }
            
            modal.classList.add('hidden');
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Function to find pendaftar by ID
        function findPendaftarById(id) {
            return allPendaftarData.find(p => p.id == id);
        }
        
        // Function to show detail
        function showDetail(id) {
            console.log('🔍 Showing details for ID:', id);
            try {
                const data = findPendaftarById(id);
                if (!data) {
                    throw new Error('Data tidak ditemukan');
                }

                const content = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Nama Lengkap:</span>
                            <p class="mt-1">${data.nama_lengkap || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Nomor HP:</span>
                            <p class="mt-1">${data.nomor_hp || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">NIK:</span>
                            <p class="mt-1">${data.nik || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Ibu Kandung:</span>
                            <p class="mt-1">${data.ibu_kandung || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Tempat Lahir:</span>
                            <p class="mt-1">${data.tempat_lahir || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Tanggal Lahir:</span>
                            <p class="mt-1">${data.tanggal_lahir || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Jurusan:</span>
                            <p class="mt-1">${data.jurusan || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Agama:</span>
                            <p class="mt-1">${data.agama || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Jenis Kelamin:</span>
                            <p class="mt-1">${data.jenis_kelamin || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Jalur Program:</span>
                            <p class="mt-1">${data.jalur_program || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Ukuran Baju:</span>
                            <p class="mt-1">${data.ukuran_baju || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Tempat Kerja:</span>
                            <p class="mt-1">${data.tempat_kerja || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <span class="font-bold text-gray-700">Status Bekerja:</span>
                            <p class="mt-1">${data.bekerja || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg col-span-2">
                            <span class="font-bold text-gray-700">Alamat:</span>
                            <p class="mt-1">${data.alamat || '-'}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg col-span-2">
                            <span class="font-bold text-gray-700">Pertanyaan:</span>
                            <p class="mt-1">${data.pertanyaan || '-'}</p>
                        </div>
                    </div>
                `;
                document.getElementById('detailContent').innerHTML = content;
                openModal('detailModal');
            } catch (error) {
                console.error('Detail Error:', error);
                alert('Gagal memuat data: ' + error.message);
            }
        }
        
        // WhatsApp function 
        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat pagi";
            if (hour < 15) return "Selamat siang";
            if (hour < 18) return "Selamat sore";
            return "Selamat malam";
        }
        
        function sendWhatsApp(phone, nama) {
            console.log('📱 Sending WhatsApp message to:', phone);
            const greeting = getGreeting();
            const message = `${greeting}, ${nama}
            
terima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:

1. Membayar uang pendaftaran sebesar Rp. 200.000 ke nomor rekening berikut:
Nama : Ribka Padang (Kepala SALUT Tana Toraja)
Bank : Mandiri
Nomor Rekening : 1700000588917

2. Melenkapi berkas data diri berupa:
- Foto diri Formal (dapat menggunakan foto HP)
- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)
- Foto Ijazah dilegalisir cap basah atau Foto ijazah asli
- Mengisi formulir Keabsahan Data (dikirimkan)`;

            const encodedMessage = encodeURIComponent(message);
            window.open(`https://wa.me/${phone}?text=${encodedMessage}`, '_blank');
        }
        
        // New function to load content dynamically 
        async function loadPage(pageName, params = {}) {
            console.log('📄 Loading page:', pageName, params);
            
            // Show loading spinner
            document.getElementById('loading-spinner').classList.remove('hidden');
            
            // Hide all content containers
            document.getElementById('dashboard-content').classList.add('hidden');
            document.getElementById('pendaftar-content').classList.add('hidden');
            
            // Update page title and active navigation
            document.getElementById('page-title').textContent = pageName === 'dashboard' ? 'Dashboard' : 'Pendaftar';
            
            // Update navigation active state
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.dataset.page === pageName) {
                    link.classList.add('bg-blue-900', 'text-white');
                    link.classList.remove('hover:bg-blue-700', 'text-blue-200');
                } else {
                    link.classList.remove('bg-blue-900', 'text-white');
                    link.classList.add('hover:bg-blue-700', 'text-blue-200');
                }
            });
            
            try {
                if (pageName === 'dashboard') {
                    // Show dashboard content
                    document.getElementById('dashboard-content').classList.remove('hidden');
                    document.getElementById('dashboard-content').classList.add('fade-in');
                } else if (pageName === 'pendaftar' || pageName === 'pendaftar-add') {
                    // Fetch pendaftar content
                    const response = await fetch('../?ajax=true' + (params.action ? `&action=${params.action}` : ''), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    
                    let content = await response.text();
                    
                    // Process the content to make it work within our dashboard
                    content = processAjaxContent(content);
                    
                    // Update the UI
                    const pendaftarContent = document.getElementById('pendaftar-content');
                    pendaftarContent.innerHTML = content;
                    pendaftarContent.classList.remove('hidden');
                    pendaftarContent.classList.add('fade-in');
                    
                    // Initialize any scripts that were loaded
                    initDynamicScripts();
                }
            } catch (error) {
                console.error('❌ Error loading page:', error);
                alert(`Gagal memuat halaman: ${error.message}`);
            } finally {
                // Hide loading spinner
                document.getElementById('loading-spinner').classList.add('hidden');
            }
        }
        
        // Process AJAX content to make it work in our dashboard
        function processAjaxContent(content) {
            // Extract only the main content from the response
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = content;
            
            // Find the main content container in the response
            const mainContent = tempDiv.querySelector('.container') || 
                                tempDiv.querySelector('main') || 
                                tempDiv.querySelector('body');
            
            if (!mainContent) {
                console.error('❌ Could not find main content in response');
                return '<div class="bg-red-100 p-4 rounded">Error: Failed to load content.</div>';
            }
            
            // Clean up the content
            let cleanedContent = mainContent.innerHTML;
            
            // Update API URLs to use HTTPS
            cleanedContent = cleanedContent.replace(/http:\/\/uttoraja\.com/g, 'https://uttoraja.com');
            
            // Fix links to be dynamic
            cleanedContent = cleanedContent.replace(/href="([^"]+)"/g, (match, url) => {
                if (url.startsWith('#')) return match;
                if (url.includes('pendaftar.php')) return 'href="#pendaftar" class="nav-link" data-page="pendaftar"';
                if (url.includes('?action=add')) return 'href="#pendaftar-add" class="nav-link" data-page="pendaftar-add"';
                return match;
            });
            
            return cleanedContent;
        }
        
        // Initialize dynamic scripts
        function initDynamicScripts() {
            console.log('🔄 Initializing dynamic scripts');
            
            // Reattach event handlers for dynamically loaded content with improved error handling
            document.querySelectorAll('#pendaftar-content button[onclick^="showDetail"]').forEach(btn => {
                try {
                    const originalOnClick = btn.getAttribute('onclick');
                    btn.removeAttribute('onclick');
                    
                    btn.addEventListener('click', function() {
                        console.log('🔍 Detail button clicked, original onclick:', originalOnClick);
                        const match = originalOnClick.match(/showDetail\((\d+)\)/);
                        if (match && match[1]) {
                            showDetail(match[1]);
                        } else {
                            console.warn('⚠️ Could not extract ID from onclick:', originalOnClick);
                        }
                    });
                } catch (e) {
                    console.error('❌ Error rewiring detail button:', e);
                }
            });
            
            document.querySelectorAll('#pendaftar-content button[onclick^="sendWhatsApp"]').forEach(btn => {
                try {
                    const originalOnClick = btn.getAttribute('onclick');
                    btn.removeAttribute('onclick');
                    
                    btn.addEventListener('click', function() {
                        console.log('📱 WhatsApp button clicked, original onclick:', originalOnClick);
                        const match = originalOnClick.match(/sendWhatsApp\('([^']+)',\s*'([^']+)'\)/);
                        if (match && match[1] && match[2]) {
                            sendWhatsApp(match[1], match[2]);
                        } else {
                            console.warn('⚠️ Could not extract phone/name from onclick:', originalOnClick);
                        }
                    });
                } catch (e) {
                    console.error('❌ Error rewiring WhatsApp button:', e);
                }
            });
            
            // Fix: Greatly improved edit button rewiring with detailed debug
            document.querySelectorAll('#pendaftar-content button[onclick^="editData"]').forEach(btn => {
                try {
                    const originalOnClick = btn.getAttribute('onclick');
                    console.log('🔄 Rewiring edit button with original onClick:', originalOnClick);
                    
                    btn.removeAttribute('onclick');
                    
                    // Attach direct click handler - this is crucial for the edit modal to work
                    btn.addEventListener('click', function(e) {
                        e.preventDefault(); // Prevent any default behavior
                        console.log('✏️ Edit button clicked, executing:', originalOnClick);
                        
                        const match = originalOnClick.match(/editData\((\d+)\)/);
                        if (match && match[1]) {
                            const id = match[1];
                            console.log('📝 Found ID for edit:', id);
                            
                            // Call our own editData function directly
                            editData(id);
                        } else {
                            console.warn('⚠️ Could not extract ID from onclick:', originalOnClick);
                            alert('Could not extract ID from edit button');
                        }
                    });
                    console.log('👍 Successfully rewired edit button');
                } catch (e) {
                    console.error('❌ Error rewiring edit button:', e);
                }
            });
            
            document.querySelectorAll('#pendaftar-content button[onclick^="confirmDelete"]').forEach(btn => {
                try {
                    const originalOnClick = btn.getAttribute('onclick');
                    btn.removeAttribute('onclick');
                    
                    btn.addEventListener('click', function() {
                        console.log('🗑️ Delete button clicked, original onclick:', originalOnClick);
                        const match = originalOnClick.match(/confirmDelete\((\d+)\)/);
                        if (match && match[1]) {
                            confirmDelete(match[1]);
                        } else {
                            console.warn('⚠️ Could not extract ID from onclick:', originalOnClick);
                        }
                    });
                } catch (e) {
                    console.error('❌ Error rewiring delete button:', e);
                }
            });
            
            // Handle search functionality in pendaftar list
            const searchInput = document.querySelector('#pendaftar-content #searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (typeof window.performSearch === 'function') {
                        window.performSearch(this.value);
                    }
                });
            }
            
            // Check if we need to create our own editData function if loaded from iframe
            if (typeof window.editData !== 'function') {
                console.log('🔧 Creating editData function for iframe context');
                window.editData = function(id) {
                    // Find the data first
                    const data = window.allPendaftarData.find(p => p.id == id);
                    if (!data) {
                        console.error('❌ Could not find pendaftar with ID:', id);
                        alert('Data tidak ditemukan');
                        return;
                    }
                    
                    console.log('🔄 Creating edit modal for iframe context');
                    // Create a temporary edit modal if it doesn't exist
                    let editModal = document.getElementById('editModal');
                    let editForm = document.getElementById('editForm');
                    
                    if (!editModal) {
                        console.log('🏗️ Creating temporary edit modal');
                        editModal = document.createElement('div');
                        editModal.id = 'editModal';
                        editModal.className = 'modal hidden';
                        editModal.innerHTML = `
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="text-2xl font-bold text-gray-800">Edit Pendaftar</h2>
                                        <button type="button" onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-times text-2xl"></i>
                                        </button>
                                    </div>
                                    <form id="editForm" class="modal-body">
                                        <!-- Form content will be dynamically inserted here -->
                                    </form>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(editModal);
                        editForm = document.getElementById('editForm');
                    }
                    
                    // Now do the standard edit operation
                    window.currentEditId = id;
                    
                    // Fill the form
                    const formContent = `
                        <input type="hidden" id="editId" value="${id}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Form fields here as in the original editData function -->
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                                <input type="text" id="editNama" name="nama_lengkap" value="${data.nama_lengkap || ''}" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <!-- Include all other fields from the original function -->
                            <!-- ... -->
                        </div>
                        <div class="flex justify-end space-x-4 pt-4 border-t mt-6">
                            <button type="button" onclick="closeModal('editModal')"
                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                Batal
                            </button>
                            <button type="submit" id="editSubmitBtn"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    `;
                    
                    editForm.innerHTML = formContent;
                    
                    // Attach submit handler
                    editForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        // Handle form submission as in the original handleEditFormSubmit function
                        console.log('📝 Edit form submitted (iframe)');
                        // ... rest of form handling logic
                    });
                    
                    // Show modal
                    editModal.style.display = 'block';
                    editModal.classList.remove('hidden');
                    editModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                };
            }
            
            // Add missing Add Pendaftar button handler if needed
            const addButton = document.querySelector('#pendaftar-content button[onclick^="showAddModal"]');
            if (addButton) {
                try {
                    addButton.removeAttribute('onclick');
                    addButton.addEventListener('click', function() {
                        console.log('➕ Add button clicked');
                        if (typeof showAddModal === 'function') {
                            showAddModal();
                        } else if (window.parent && window.parent.showAddModal) {
                            window.parent.showAddModal();
                        }
                    });
                } catch (e) {
                    console.error('❌ Error rewiring Add button:', e);
                }
            }
            
            console.log('✅ Dynamic scripts initialized');
        }
        
        // Handle hash-based navigation
        function handleHashChange() {
            const hash = window.location.hash.substring(1) || 'dashboard';
            const params = {};
            
            // Check for action parameters
            if (hash === 'pendaftar-add') {
                params.action = 'add';
                loadPage('pendaftar', params);
            } else {
                loadPage(hash, params);
            }
        }
        
        // Attach event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 DOM fully loaded and parsed');
            
            // Initially handle hash-based navigation
            handleHashChange();
            
            // Listen for hash changes
            window.addEventListener('hashchange', handleHashChange);
            
            // Attach click handlers to navigation links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.dataset.page;
                    window.location.hash = page;
                });
            });
            
            // Rewire buttons on the dashboard
            document.querySelectorAll('#dashboard-content button[onclick^="showDetail"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    const match = originalOnClick.match(/showDetail\((\d+)\)/);
                    if (match && match[1]) {
                        showDetail(match[1]);
                    }
                });
            });
            
            document.querySelectorAll('#dashboard-content button[onclick^="sendWhatsApp"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    const match = originalOnClick.match(/sendWhatsApp\('([^']+)',\s*'([^']+)'\)/);
                    if (match && match[1] && match[2]) {
                        sendWhatsApp(match[1], match[2]);
                    }
                });
            });
            
            console.log('✅ Event listeners attached');
        });
        
        // Enhanced editData function for the admin dashboard
        function editData(id) {
            console.log('✏️ Admin dashboard editData called with ID:', id);
            try {
                // Create a special edit modal for the admin dashboard that works with the loaded content
                const pendaftarContent = document.getElementById('pendaftar-content');
                if (pendaftarContent) {
                    console.log('📝 Getting pendaftar data from allPendaftarData');
                    const data = allPendaftarData.find(p => p.id == id);
                    if (!data) {
                        throw new Error('Data pendaftar tidak ditemukan');
                    }
                    
                    console.log('🔍 Found pendaftar data:', data);
                    
                    // First check if there's an editModal in the pendaftar content
                    let editModal = pendaftarContent.querySelector('#editModal');
                    let editForm = pendaftarContent.querySelector('#editForm');
                    
                    // If not found in pendaftar content, check main document
                    if (!editModal) editModal = document.getElementById('editModal');
                    if (!editForm) editForm = document.getElementById('editForm');
                    
                    // If still not found, create them
                    if (!editModal) {
                        console.log('🏗️ Creating edit modal on demand');
                        editModal = document.createElement('div');
                        editModal.id = 'editModal';
                        editModal.className = 'modal hidden';
                        editModal.innerHTML = `
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="text-2xl font-bold text-gray-800">Edit Pendaftar</h2>
                                        <button type="button" onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-times text-2xl"></i>
                                        </button>
                                    </div>
                                    <form id="editForm" class="modal-body">
                                        <!-- Form content will be dynamically inserted here -->
                                    </form>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(editModal);
                        editForm = document.getElementById('editForm');
                    }

                    console.log('📋 Creating form content');
                    // Create the form content
                    const formContent = `
                        <input type="hidden" id="editId" value="${id}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                                <input type="text" id="editNama" name="nama_lengkap" value="${data.nama_lengkap || ''}" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Nomor HP</label>
                                <input type="text" id="editNomorHP" name="nomor_hp" value="${data.nomor_hp || ''}" required
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">NIK</label>
                                <input type="text" id="editNIK" name="nik" value="${data.nik || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Ibu Kandung</label>
                                <input type="text" id="editIbuKandung" name="ibu_kandung" value="${data.ibu_kandung || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                                <input type="text" id="editTempatLahir" name="tempat_lahir" value="${data.tempat_lahir || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                                <input type="date" id="editTanggalLahir" name="tanggal_lahir" value="${data.tanggal_lahir || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Jurusan</label>
                                <input type="text" id="editJurusan" name="jurusan" value="${data.jurusan || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Agama</label>
                                <input type="text" id="editAgama" name="agama" value="${data.agama || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <select id="editJenisKelamin" name="jenis_kelamin" 
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="laki-laki" ${data.jenis_kelamin === 'laki-laki' ? 'selected' : ''}>Laki-laki</option>
                                    <option value="perempuan" ${data.jenis_kelamin === 'perempuan' ? 'selected' : ''}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Jalur Program</label>
                                <input type="text" id="editJalurProgram" name="jalur_program" value="${data.jalur_program || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Ukuran Baju</label>
                                <input type="text" id="editUkuranBaju" name="ukuran_baju" value="${data.ukuran_baju || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tempat Kerja</label>
                                <input type="text" id="editTempatKerja" name="tempat_kerja" value="${data.tempat_kerja || ''}"
                                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Status Bekerja</label>
                                <select id="editBekerja" name="bekerja"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="ya" ${data.bekerja === 'ya' ? 'selected' : ''}>Ya</option>
                                    <option value="tidak" ${data.bekerja === 'tidak' ? 'selected' : ''}>Tidak</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Alamat</label>
                                <textarea id="editAlamat" name="alamat" rows="3"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">${data.alamat || ''}</textarea>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Pertanyaan</label>
                                <textarea id="editPertanyaan" name="pertanyaan" rows="3"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">${data.pertanyaan || ''}</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4 pt-4 border-t mt-6">
                            <button type="button" onclick="closeModal('editModal')"
                                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                Batal
                            </button>
                            <button type="submit" id="editSubmitBtn"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    `;
                    
                    console.log('🔄 Setting form content and opening modal');
                    editForm.innerHTML = formContent;
                    
                    // Store current edit ID
                    window.currentEditId = id;
                    
                    // Open the modal with a direct approach
                    editModal.style.display = 'block';
                    editModal.classList.remove('hidden');
                    editModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                    
                    // Attach submit handler
                    console.log('🔌 Attaching submit handler');
                    editForm.removeEventListener('submit', handleEditFormSubmit);
                    editForm.addEventListener('submit', handleEditSubmitForAdmin);
                    
                    console.log('✅ Edit modal setup complete');
                } else {
                    console.warn('⚠️ pendaftar-content element not found');
                    alert('Pendaftar content not found in the DOM');
                }
            } catch (error) {
                console.error('❌ Edit Error:', error);
                alert('Gagal memuat form edit: ' + error.message);
            }
        }

        // Create a special submit handler for admin context
        function handleEditSubmitForAdmin(e) {
            e.preventDefault();
            console.log('📝 Edit form submitted from admin context');
            
            const id = window.currentEditId;
            console.log('🔄 Updating data with ID:', id);
            
            if (!id) {
                console.error('❌ No ID found for edit operation');
                alert('ID data tidak ditemukan');
                return;
            }
            
            // Get form data
            const form = e.target;
            const formData = {};
            
            // Collect all form fields
            const formElements = form.elements;
            for (let i = 0; i < formElements.length; i++) {
                const element = formElements[i];
                if (element.name && element.name !== '' && element.type !== 'submit' && element.type !== 'button') {
                    formData[element.name] = element.value;
                }
            }
            
            console.log('📤 Update data to send:', formData);
            
            try {
                // Create a direct PUT request
                const apiBaseUrl = apiUrl;
                const updateUrl = secureUrl(`${apiBaseUrl}/${id}`);
                
                fetch(updateUrl, {
                    method: 'PUT',
                    headers: apiHeaders,
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(responseText => {
                    console.log('✅ Update successful!');
                    closeModal('editModal');
                    alert('Data berhasil diperbarui! 🎉');
                    // Reload the page to refresh data
                    location.reload();
                })
                .catch(error => {
                    console.error('❌ Update Error:', error);
                    alert(`Gagal memperbarui data: ${error.message}`);
                });
            } catch (error) {
                console.error('❌ Update Request Error:', error);
                alert(`Gagal memproses permintaan: ${error.message}`);
            }
        }
    </script>
</body>
</html>
