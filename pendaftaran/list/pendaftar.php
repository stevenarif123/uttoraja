<?php
require_once 'auth.php';
requireLogin();
require_once 'config/database.php';
require_once './data/status_data.php';

// Pagination configuration
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_index = ($page - 1) * $items_per_page;

// Add this function to handle status classes
function getStatusClass($status) {
    $classes = [
        'belum_diproses' => 'bg-gray-100',
        'sudah_dihubungi' => 'bg-yellow-100',
        'berminat' => 'bg-green-100',
        'tidak_berminat' => 'bg-red-100',
        'pendaftaran_selesai' => 'bg-blue-100'
    ];
    return $classes[$status] ?? $classes['belum_diproses'];
}

// Add this function to retrieve stored status from JSON
function getStoredStatus($id) {
    $statusFile = __DIR__ . 'data/status.json';
    if (!file_exists($statusFile)) {
        return 'belum_diproses';
    }
    
    $statusData = json_decode(file_get_contents($statusFile), true);
    return $statusData['pendaftar_status'][$id]['status'] ?? 'belum_diproses';
}

// Add new function to update message status
function updatePendaftarStatus($id, $status) {
    try {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE pendaftar SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
        return true;
    } catch(PDOException $e) {
        error_log('Error updating status: ' . $e->getMessage());
        return false;
    }
}

// Add status update endpoint handler
if (isset($_POST['update_status'])) {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;
    
    if ($id && $status) {
        $success = updatePendaftarStatus($id, $status);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }
}

$statusHandler = new StatusDataHandler();
$statuses = $statusHandler->getAllStatuses();

// Set page title for navbar
$pageTitle = 'Daftar Pendaftar';

// Check if this is an AJAX request
$isAjax = isset($_GET['ajax']) && $_GET['ajax'] === 'true';

// Check for action parameter (e.g., add, edit, view)
$action = $_GET['action'] ?? null;

// Update API URL to use HTTPS instead of HTTP
$apiUrl = 'https://uttoraja.com/pendaftaran/api/pendaftar'; // Changed this line

// Add error handling for API call with cURL instead of file_get_contents
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
    
    // Get total records for pagination
    $total_records = count($data);
    $total_pages = ceil($total_records / $items_per_page);
    
    // Slice the data array for the current page
    $data = array_slice($data, $start_index, $items_per_page);
    
} catch (Exception $e) {
    $data = [];
    $error_message = $e->getMessage();
    $total_records = 0;
    $total_pages = 0;
}

// Fetch program study data
$programStudies = [];
try {
    $stmt = $pdo->query("SELECT nama_program_studi FROM prodi_admisi ORDER BY nama_program_studi ASC");
    $programStudies = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    error_log('Error fetching program studies: ' . $e->getMessage());
}

// Skip most of the header if this is an AJAX request
if (!$isAjax):
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftar - UT Toraja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/pendaftar.css"> <!-- Updated path to pendaftar.css -->
    <style>
        /* Fixed modal styles to ensure proper display */
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
        
        /* Pagination Styles */
        .pagination-link {
            padding: 0.75rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }
        
        .pagination-link.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination-link:not(.active) {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .pagination-link:not(.active):hover {
            background-color: #2563eb;
            color: white;
        }
        
        .pagination-info {
            font-size: 0.875rem;
            color: #4b5563;
        }
        
        /* Loading State */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            display: none;
        }
        
        .loading-spinner {
            animation: spin 1s linear infinite;
            height: 3rem;
            width: 3rem;
            color: white;
        }
        
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>
            
            <!-- Main content -->
            <div class="p-6">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Pendaftar</h1>
                        <button onclick="showAddModal()" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Pendaftar
                        </button>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="mb-6">
                        <input type="text" 
                               id="searchInput"
                               placeholder="Cari pendaftar..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">No</th>
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Nomor HP</th>
                                    <th class="py-3 px-6 text-left">Jurusan</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pendaftarTableBody" class="text-gray-600 text-sm">
                                <?php if (!empty($data)): ?>
                                    <?php foreach ($data as $index => $pendaftar): ?>
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-4 px-6 row-number"><?php echo $index + 1; ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nama_lengkap'] ?? '-'); ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nomor_hp'] ?? '-'); ?></td>
                                            <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['jurusan'] ?? '-'); ?></td>
                                            <td class="py-4 px-6">
                                                <select onchange="updateStatus(<?php echo $pendaftar['id']; ?>, this.value)" 
                                                        data-id="<?php echo $pendaftar['id']; ?>"
                                                        class="status-select px-2 py-1 rounded border <?php echo getStatusClass(getStoredStatus($pendaftar['id'])); ?>">
                                                    <option value="belum_diproses" <?php echo getStoredStatus($pendaftar['id']) === 'belum_diproses' ? 'selected' : ''; ?>>Belum Diproses</option>
                                                    <option value="sudah_dihubungi" <?php echo getStoredStatus($pendaftar['id']) === 'sudah_dihubungi' ? 'selected' : ''; ?>>Sudah Dihubungi</option>
                                                    <option value="berminat" <?php echo getStoredStatus($pendaftar['id']) === 'berminat' ? 'selected' : ''; ?>>Berminat</option>
                                                    <option value="tidak_berminat" <?php echo getStoredStatus($pendaftar['id']) === 'tidak_berminat' ? 'selected' : ''; ?>>Tidak Berminat</option>
                                                    <option value="pendaftaran_selesai" <?php echo getStoredStatus($pendaftar['id']) === 'pendaftaran_selesai' ? 'selected' : ''; ?>>Pendaftaran Selesai</option>
                                                </select>
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <button onclick="showDetail(<?php echo $pendaftar['id']; ?>)" 
                                                            class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button onclick="editData(<?php echo $pendaftar['id']; ?>)"
                                                            class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition duration-200">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="confirmDelete(<?php echo $pendaftar['id']; ?>)"
                                                            class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <div class="flex space-x-1">
                                                        <button onclick="sendInitialMessage('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap'] ?? ''); ?>', <?php echo $pendaftar['id']; ?>)"
                                                                class="bg-purple-500 text-white px-3 py-1 rounded-lg hover:bg-purple-600 transition duration-200"
                                                                title="Kirim Pesan Awal">
                                                            <i class="fab fa-whatsapp"></i> 1
                                                        </button>
                                                        <button onclick="sendWhatsApp('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap'] ?? ''); ?>', <?php echo $pendaftar['id']; ?>)"
                                                                class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition duration-200"
                                                                title="Kirim Pesan Pembayaran">
                                                            <i class="fab fa-whatsapp"></i> 2
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="noDataRow">
                                        <td colspan="6" class="py-4 px-6 text-center">Tidak ada data pendaftar</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Showing <?php echo $start_index + 1; ?>-<?php echo min($start_index + $items_per_page, $total_records); ?> 
                            of <?php echo $total_records; ?> entries
                        </div>
                        <div class="flex space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-left mr-1"></i> Previous
                                </a>
                            <?php endif; ?>

                            <?php
                            // Show page numbers
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);

                            for ($i = $start_page; $i <= $end_page; $i++):
                            ?>
                                <a href="?page=<?php echo $i; ?>" 
                                   class="px-3 py-1 <?php echo $i === $page ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700'; ?> rounded hover:bg-blue-600 hover:text-white transition-colors">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo $page + 1; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                                    Next <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Only include modals if not in AJAX mode or specifically requested -->
    <?php if (!$isAjax || isset($_GET['action'])): ?>
    <!-- Fix modal classes and structure -->
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

    <!-- Improved Edit Modal -->
    <div id="editModal" class="modal hidden">
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
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Agama</label>
                        <select id="editAgama" name="agama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Program Studi</label>
                        <select id="editJurusan" name="jurusan" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Program Studi</option>
                            <?php foreach($programStudies as $prodi): ?>
                            <option value="<?php echo htmlspecialchars($prodi); ?>"><?php echo htmlspecialchars($prodi); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jalur Program</label>
                        <select id="editJalurProgram" name="jalur_program" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Jalur Program</option>
                            <option value="RPL" ${data.jalur_program === 'RPL' ? 'selected' : ''}>RPL</option>
                            <option value="REGULER" ${data.jalur_program === 'REGULER' ? 'selected' : ''}>REGULER</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Ukuran Baju</label>
                        <select id="editUkuranBaju" name="ukuran_baju" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Ukuran Baju</option>
                            <option value="S" ${data.ukuran_baju === 'S' ? 'selected' : ''}>S</option>
                            <option value="M" ${data.ukuran_baju === 'M' ? 'selected' : ''}>M</option>
                            <option value="L" ${data.ukuran_baju === 'L' ? 'selected' : ''}>L</option>
                            <option value="XL" ${data.ukuran_baju === 'XL' ? 'selected' : ''}>XL</option>
                            <option value="XXL" ${data.ukuran_baju === 'XXL' ? 'selected' : ''}>XXL</option>
                            <option value="XXXL" ${data.ukuran_baju === 'XXXL' ? 'selected' : ''}>XXXL</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add new Add Modal -->
    <div id="addModal" class="modal hidden">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Pendaftar Baru</h2>
                    <button type="button" onclick="closeModal('addModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <form id="addForm" class="modal-body">
                    <!-- Form fields will be identical to edit form -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jalur Program</label>
                        <select name="jalur_program" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Jalur Program</option>
                            <option value="RPL">RPL</option>
                            <option value="Reguler">Reguler</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Ukuran Baju</label>
                        <select name="ukuran_baju" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Ukuran Baju</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add confirmation modal -->
    <div id="deleteConfirmModal" class="modal hidden">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-xl font-bold">Konfirmasi Hapus</h3>
                    <button type="button" onclick="closeModal('deleteConfirmModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-4">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal('deleteConfirmModal')" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </button>
                    <button onclick="deleteData()" 
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 ml-2">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (!$isAjax): // Only include full scripts if not AJAX request ?>
    <script>
        // Global variables for better organization
        let lastTimeout = null;
        let deleteId = null;
        let currentEditId = null;
        
        // Store all data in a global variable
        const allPendaftarData = <?php echo json_encode($data); ?>;

        // Function to find pendaftar by phone number
        function findPendaftarByPhone(phone) {
            if (!phone) return null;
            const cleanPhone = phone.replace(/\D/g, '');
            return allPendaftarData.find(p => p.nomor_hp && p.nomor_hp.replace(/\D/g, '') === cleanPhone);
        }

        // Function to find pendaftar by ID
        function findPendaftarById(id) {
            return allPendaftarData.find(p => p.id === id);
        }

        // Message status update function
        async function updateMessageSent(id, messageType) {
            try {
                const response = await fetch(`${window.location.origin}/pendaftaran/api/update-message-sent.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, messageType })
                });

                if (!response.ok) throw new Error('Failed to update message status');
                console.log('✅ Message status updated successfully');
            } catch (error) {
                console.error('❌ Error updating message status:', error);
            }
        }

        // Initialize search functionality when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('pendaftarTableBody');
            
            if (searchInput && tableBody) {
                const rows = Array.from(tableBody.getElementsByTagName('tr'));
                const noDataRow = document.getElementById('noDataRow');
                
                const performSearch = function(searchTerm) {
                    searchTerm = searchTerm.toLowerCase().trim();
                    let visibleCount = 0;

                    rows.forEach((row) => {
                        if (row.id === 'noDataRow') return;
                        const text = row.textContent.toLowerCase();
                        const shouldShow = text.includes(searchTerm);
                        row.style.display = shouldShow ? '' : 'none';
                        if (shouldShow) {
                            visibleCount++;
                            const rowNumber = row.querySelector('.row-number');
                            if (rowNumber) rowNumber.textContent = visibleCount;
                        }
                    });

                    if (noDataRow) {
                        noDataRow.style.display = visibleCount === 0 ? '' : 'none';
                    }
                };

                const debounceSearch = function(fn, delay) {
                    return function() {
                        const context = this;
                        const args = arguments;
                        clearTimeout(lastTimeout);
                        lastTimeout = setTimeout(() => fn.apply(context, args), delay);
                    };
                };

                const debouncedSearch = debounceSearch(performSearch, 300);

                searchInput.addEventListener('input', function() {
                    debouncedSearch(this.value);
                });

                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        performSearch('');
                    }
                });
            }
        });
    </script>
    <?php endif; ?>
    
    <!-- Add missing JavaScript functions -->
    <script>
        // Modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        
        function showDetail(id) {
            // Implementation for showing details modal
            document.getElementById('detailModal').classList.remove('hidden');
        }
        
        function editData(id) {
            // Implementation for editing data
            currentEditId = id;
            document.getElementById('editModal').classList.remove('hidden');
        }
        
        function confirmDelete(id) {
            deleteId = id;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }
        
        function deleteData() {
            // Implementation for deleting data
            closeModal('deleteConfirmModal');
        }
        
        function showAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        
        function updateStatus(id, status) {
            // Implementation for updating status
        }
        
        function sendInitialMessage(phone, name, id) {
            // Implementation for sending initial WhatsApp message
        }
        
        function sendWhatsApp(phone, name, id) {
            // Implementation for sending WhatsApp message
        }
    </script>
</body>
</html>
<?php endif; ?>