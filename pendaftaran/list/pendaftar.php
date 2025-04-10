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
    $statusFile = __DIR__ . '/data/status.json';
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

// Handle AJAX requests for details
if (isset($_GET['action']) && $_GET['action'] === 'get_detail' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {
        $query = "SELECT * FROM pendaftar WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) {
            http_response_code(404);
            echo json_encode(['error' => 'Data not found']);
            exit;
        }
        
        // Get status from status.json
        $statusData = $statusHandler->getAllStatuses();
        $data['status'] = $statusData['pendaftar_status'][$id]['status'] ?? 'belum_diproses';
        
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

// Update API URL to use the deployed server endpoint
$apiUrl = 'http://uttoraja.com/pendaftaran/api/pendaftar/';

// Use the existing fetchData function but with updated error handling
function fetchData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
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
/* Enhanced Modal Styles 🎨 */
.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    display: flex;
    align-items: flex-start; /* Changed from center to allow scrolling */
    justify-content: center;
    padding: 1rem;
    overflow-y: auto; /* Enable scrolling on modal */
}

.modal-dialog {
    width: 100%;
    max-width: 800px;
    margin: 2rem auto;
    background: white;
    border-radius: 1rem;
    transform: translateY(-30px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Update form submission handling */
</style>
<script>
// Fix modal opening and closing issues
const Modal = {
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }
    },
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = ''; // Restore scrolling
        }
    }
};

// Fix edit form not saving data
async function saveEditData(event) {
    event.preventDefault();
    const form = event.target;
    const id = document.getElementById('editId').value;
    const saveButton = document.getElementById('saveEditButton');
    
    try {
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch(`http://uttoraja.com/pendaftaran/api/pendaftar/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to update data');
        }

        showNotification('✅ Data updated successfully!', 'success');
        Modal.close('editModal');
        location.reload(); // Refresh page to show updated data
    } catch (error) {
        console.error('Save error:', error);
        showNotification('❌ ' + error.message, 'error');
    } finally {
        saveButton.disabled = false;
        saveButton.innerHTML = 'Save Changes';
    }
}

// Fix scrolling issues in modals
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                Modal.close(modal.id);
            }
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal.flex').forEach(modal => {
                Modal.close(modal.id);
            });
        }
    });
});

// Fix page becoming unclickable by ensuring proper modal state
document.querySelectorAll('[data-modal-open]').forEach(button => {
    button.addEventListener('click', function() {
        const modalId = button.getAttribute('data-modal-open');
        Modal.open(modalId);
    });
});

document.querySelectorAll('[data-modal-close]').forEach(button => {
    button.addEventListener('click', function() {
        const modalId = button.getAttribute('data-modal-close');
        Modal.close(modalId);
    });
});
</script>
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
                        <button onclick="Modal.open('addModal')" 
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
                                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                        Edit
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
                                                        <button onclick="sendPaymentMessage('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap'] ?? ''); ?>')"
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
    <!-- Replace existing detailModal div with this optimized version -->
    <div id="detailModal" class="modal hidden" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded-lg">
                <div class="modal-header flex justify-between items-center border-b p-4">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pendaftar</h2>
                    <button type="button" onclick="Modal.close('detailModal')" 
                            class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div id="detailContent" class="modal-body overflow-y-auto">
                    <!-- Content will be dynamically inserted here -->
                </div>
                <div class="modal-footer border-t p-4">
                    <button type="button" onclick="Modal.close('detailModal')" 
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated Edit Modal -->
    <div id="editModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="modal-content relative bg-white rounded-lg shadow dark:bg-gray-700 w-full max-w-2xl">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Data Pendaftar
                </h3>
                <button type="button" onclick="Modal.close('editModal')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>

            <!-- Modal body -->
            <form id="editForm" method="post" class="p-6 space-y-6">
                <input type="hidden" id="editId" name="id">
                
                <!-- Personal Information -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-3 text-gray-700">Data Pribadi 👤</h4>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
                        <input type="text" name="nik" pattern="[0-9]*" maxlength="16" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Ibu Kandung</label>
                        <input type="text" name="ibu_kandung" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-3 text-gray-700 mt-4">Informasi Kontak 📞</h4>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nomor HP <span class="text-red-500">*</span></label>
                        <input type="tel" name="nomor_hp" pattern="[0-9]*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                        <textarea name="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    </div>

                    <!-- Academic Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-3 text-gray-700 mt-4">Informasi Akademik 📚</h4>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Program Studi <span class="text-red-500">*</span></label>
                        <select name="jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="">Pilih Program Studi</option>
                            <?php foreach ($programStudies as $prodi): ?>
                                <option value="<?php echo htmlspecialchars($prodi); ?>"><?php echo htmlspecialchars($prodi); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Jalur Program</label>
                        <select name="jalur_program" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Jalur Program</option>
                            <option value="RPL">RPL</option>
                            <option value="Reguler">Reguler</option>
                        </select>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-span-2">
                        <h4 class="text-lg font-semibold mb-3 text-gray-700 mt-4">Informasi Tambahan ℹ️</h4>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Status Bekerja</label>
                        <select name="bekerja" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="0">Tidak Bekerja</option>
                            <option value="1">Bekerja</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tempat Kerja</label>
                        <input type="text" name="tempat_kerja" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Ukuran Baju</label>
                        <select name="ukuran_baju" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Ukuran</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                            <option value="XXXL">XXXL</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Agama</label>
                        <select name="agama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-2 border-t pt-4 mt-4">
                    <button type="button" onclick="Modal.close('editModal')" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Cancel
                    </button>
                    <button type="submit" id="saveEditButton"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <span class="save-text">Save Changes</span>
                        <span class="loading-text hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add new Add Modal -->
    <div id="addModal" class="modal hidden">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Pendaftar Baru</h2>
                    <button type="button" onclick="Modal.close('addModal')" class="text-gray-500 hover:text-gray-700">
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
                    <button type="button" onclick="Modal.close('deleteConfirmModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-4">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button onclick="Modal.close('deleteConfirmModal')" 
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
// Simplified Modal object
const Modal = {
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            // Force reflow for transition
            modal.offsetHeight;
            modal.classList.remove('hidden');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    },
    
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.addEventListener('transitionend', () => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }, { once: true });
            document.body.style.overflow = '';
        }
    }
};

// API interactions
const API = {
    baseUrl: 'http://uttoraja.com/pendaftaran/api/pendaftar',
    
    async get(id) {
        const response = await fetch(`${this.baseUrl}/${id}`);
        if (!response.ok) throw new Error('Failed to fetch data');
        return response.json();
    },
    
    async update(id, data) {
        const response = await fetch(`${this.baseUrl}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            },
            body: JSON.stringify(data)
        });
        if (!response.ok) throw new Error('Failed to update data');
        return response.json();
    }
};

// Feature handlers
async function showDetail(id) {
    try {
        const response = await fetch(`http://uttoraja.com/pendaftaran/api/pendaftar/${id}`);
        if (!response.ok) throw new Error('Failed to fetch data');
        const data = await response.json();

        // Format date properly
        const formatDate = (dateString) => {
            if (!dateString) return '-';
            try {
                return new Date(dateString).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (e) {
                return dateString;
            }
        };

        // Format gender properly
        const formatGender = (gender) => {
            if (!gender) return '-';
            return gender.charAt(0).toUpperCase() + gender.slice(1);
        };

        // Format working status
        const formatWorkingStatus = (status) => {
            if (status === null || status === undefined) return '-';
            return status ? 'Ya' : 'Tidak';
        };

        // Format empty values
        const formatValue = (value) => value || '-';

        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = `
            <div class="space-y-4 p-4">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Personal Information Section -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded">
                        <h3 class="font-bold text-blue-800 mb-2">Data Pribadi</h3>
                    </div>

                    <div class="font-bold">Nama Lengkap:</div>
                    <div>${formatValue(data.nama_lengkap)}</div>
                    
                    <div class="font-bold">Tempat, Tanggal Lahir:</div>
                    <div>${formatValue(data.tempat_lahir)}, ${formatDate(data.tanggal_lahir)}</div>

                    <div class="font-bold">NIK:</div>
                    <div>${formatValue(data.nik)}</div>

                    <div class="font-bold">Nama Ibu Kandung:</div>
                    <div>${formatValue(data.ibu_kandung)}</div>

                    <div class="font-bold">Jenis Kelamin:</div>
                    <div>${formatGender(data.jenis_kelamin)}</div>

                    <div class="font-bold">Agama:</div>
                    <div>${formatValue(data.agama)}</div>

                    <!-- Contact Information Section -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">Informasi Kontak</h3>
                    </div>

                    <div class="font-bold">Nomor HP:</div>
                    <div>${formatValue(data.nomor_hp)}</div>

                    <div class="font-bold">Alamat:</div>
                    <div>${formatValue(data.alamat)}</div>

                    <!-- Academic Information Section -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">Informasi Akademik</h3>
                    </div>

                    <div class="font-bold">Program Studi:</div>
                    <div>${formatValue(data.jurusan)}</div>
                    
                    <div class="font-bold">Jalur Program:</div>
                    <div>${formatValue(data.jalur_program)}</div>

                    <!-- Additional Information Section -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">Informasi Tambahan</h3>
                    </div>

                    <div class="font-bold">Status Bekerja:</div>
                    <div>${formatWorkingStatus(data.bekerja)}</div>

                    <div class="font-bold">Tempat Kerja:</div>
                    <div>${formatValue(data.tempat_kerja)}</div>

                    <div class="font-bold">Ukuran Baju:</div>
                    <div>${formatValue(data.ukuran_baju)}</div>

                    <div class="font-bold">Status Pendaftaran:</div>
                    <div class="font-semibold ${getStatusClass(data.status)}">
                        ${(data.status?.replace(/_/g, ' ') || 'BELUM DIPROSES').toUpperCase()}
                    </div>

                    ${data.pertanyaan ? `
                        <div class="font-bold">Pertanyaan:</div>
                        <div>${data.pertanyaan}</div>
                    ` : ''}
                </div>
            </div>
        `;

        Modal.open('detailModal');
    } catch (error) {
        console.error('Error:', error);
        showNotification('❌ Gagal memuat detail pendaftar', 'error');
    }
}

async function editData(id) {
    try {
        const response = await fetch(`http://uttoraja.com/pendaftaran/api/pendaftar/${id}`);
        if (!response.ok) throw new Error('Failed to fetch data');
        const data = await response.json();

        const form = document.getElementById('editForm');
        if (!form) return;

        // Reset form first
        form.reset();

        // Populate all form fields
        const fields = [
            'nama_lengkap', 'nomor_hp', 'nik', 'tempat_lahir', 'tanggal_lahir',
            'ibu_kandung', 'jenis_kelamin', 'agama', 'jurusan', 'jalur_program',
            'bekerja', 'tempat_kerja', 'ukuran_baju', 'alamat'
        ];

        fields.forEach(field => {
            const input = form.elements[field];
            if (!input) return;

            // Handle special cases
            if (field === 'tanggal_lahir' && data[field]) {
                // Ensure date is in YYYY-MM-DD format for input[type="date"]
                input.value = data[field].split('T')[0];
            } else if (field === 'bekerja') {
                // Convert boolean/integer to string for select
                input.value = data[field] ? "1" : "0";
            } else {
                input.value = data[field] || '';
            }
        });

        // Set hidden ID field
        document.getElementById('editId').value = id;

        // Show modal
        Modal.open('editModal');
    } catch (error) {
        console.error('Error loading edit data:', error);
        showNotification('❌ Gagal memuat data untuk diedit', 'error');
    }
}

// Helper functions
function getStatusClass(status) {
    return {
        'belum_diproses': 'bg-gray-100',
        'sudah_dihubungi': 'bg-yellow-100',
        'berminat': 'bg-green-100',
        'tidak_berminat': 'bg-red-100',
        'pendaftaran_selesai': 'bg-blue-100'
    }[status] || 'bg-gray-100';
}

// Add to script section
async function saveEditData(event) {
    event.preventDefault();
    const form = event.target;
    const id = document.getElementById('editId').value;
    const saveButton = document.getElementById('saveEditButton');
    const saveText = saveButton.querySelector('.save-text');
    const loadingText = saveButton.querySelector('.loading-text');

    try {
        // Disable form and show loading
        form.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = true);
        saveText.classList.add('hidden');
        loadingText.classList.remove('hidden');

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const response = await fetch(`http://uttoraja.com/pendaftaran/api/pendaftar/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error('Failed to update data');
        
        showNotification('✅ Data berhasil diperbarui!', 'success');
        Modal.close('editModal');
        location.reload();
    } catch (error) {
        console.error('Error saving data:', error);
        showNotification('❌ Gagal menyimpan perubahan', 'error');
        
        // Re-enable form on error
        form.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = false);
        saveText.classList.remove('hidden');
        loadingText.classList.add('hidden');
    }
}

// Add form submit handler
document.getElementById('editForm')?.addEventListener('submit', saveEditData);

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', e => {
            if (e.target === modal) Modal.close(modal.id);
        });
    });

    // Close modal on escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
                Modal.close(modal.id);
            });
        }
    });

    // Handle close buttons
    document.querySelectorAll('[onclick^="closeModal"]').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const modalId = button.getAttribute('onclick').match(/'([^']+)'/)[1];
            Modal.close(modalId);
        });
    });

    // Update onclick attributes to use Modal object
    document.querySelectorAll('[onclick^="openModal"]').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const modalId = button.getAttribute('onclick').match(/'([^']+)'/)[1];
            Modal.open(modalId);
        });
    });
});

// Make functions globally available
window.Modal = Modal;
window.showDetail = showDetail;
window.editData = editData;
window.getStatusClass = getStatusClass;
</script>
    <?php endif; ?>
</body>
</html>
<?php endif; ?>