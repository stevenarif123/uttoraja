<?php
require_once 'auth.php';
requireLogin();
require_once 'config/database.php';
require_once './data/status_data.php';

// Pagination configuration
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_index = ($page - 1) * $items_per_page;

// ✨ Get search term from GET request ✨
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

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

// Update function to manage status in JSON file
function updatePendaftarStatus($id, $status) {
    try {
        $statusFile = __DIR__ . '/data/status.json';
        
        // Read existing data
        $statusData = [];
        if (file_exists($statusFile)) {
            $statusData = json_decode(file_get_contents($statusFile), true) ?: [];
        }
        
        // Initialize pendaftar_status if not exists
        if (!isset($statusData['pendaftar_status'])) {
            $statusData['pendaftar_status'] = [];
        }
        
        // Update status
        $statusData['pendaftar_status'][$id] = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Write back to file
        file_put_contents($statusFile, json_encode($statusData, JSON_PRETTY_PRINT));
        return true;
    } catch(Exception $e) {
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
$apiUrl = 'https://uttoraja.com/pendaftaran/api/pendaftar/';

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
    $all_data = json_decode($response, true); // Fetch ALL data first
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Failed to parse JSON response");
    }

    // ✨ Filter data based on search term BEFORE pagination ✨
    $filtered_data = $all_data; // Start with all data
    if (!empty($search_term)) {
        $filtered_data = array_filter($all_data, function($pendaftar) use ($search_term) {
            // Case-insensitive search in relevant fields
            $nama = $pendaftar['nama_lengkap'] ?? '';
            $hp = $pendaftar['nomor_hp'] ?? '';
            $jurusan = $pendaftar['jurusan'] ?? '';
            return stripos($nama, $search_term) !== false ||
                   stripos($hp, $search_term) !== false ||
                   stripos($jurusan, $search_term) !== false;
        });
    }

    // Get total records for pagination *from filtered data*
    $total_records = count($filtered_data);
    $total_pages = ceil($total_records / $items_per_page);

    // Ensure page number is valid after filtering
    if ($page > $total_pages && $total_pages > 0) {
        $page = $total_pages; // Go to last page if current page is out of bounds
        $start_index = ($page - 1) * $items_per_page;
    } elseif ($page < 1) {
        $page = 1; // Go to first page if invalid
        $start_index = 0;
    }

    // Slice the *filtered* data array for the current page
    $data = array_slice($filtered_data, $start_index, $items_per_page);

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
    opacity: 0;                             /* Use opacity for transition */
    visibility: hidden;                     /* Use visibility for transition & accessibility */
    transition: opacity 0.3s ease, visibility 0.3s ease; /* Let's smoothly transition opacity */
    display: flex;                          /* Keep display as flex (or block) */
    align-items: flex-start;  /* Updated this from your input for consistency */
    justify-content: center; /* Updated this from your input for consistency */
    padding: 1rem;                          /* Updated this from your input for consistency */
    overflow-y: auto;                       /* Updated this from your input for consistency */
}

.modal.modal-visible {
    opacity: 1;                 /* Make it fully opaque */
    visibility: visible;        /* Make it visible */
    display: flex;              /* Ensure it's displayed as flex */
}

.modal.modal-visible .modal-dialog {
    transform: translateY(0) scale(1);
}

.modal .modal-dialog {
    transform: translateY(-20px) scale(0.95);
    transition: transform 0.3s ease;
}

/* Enhanced Sidebar Styles 📌 */
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
    height: 100vh; /* Ensure full height */
    overflow-y: hidden; /* ✨ Changed from auto to hidden ✨ */
    z-index: 40;
}

.main-content {
    margin-left: 16rem; /* Same as sidebar width */
    width: calc(100% - 16rem);
    min-height: 100vh;
    flex: 1;
}
</style>
<script>
/**
 * 🌟 UTTORAJA Pendaftaran Manager 🌟
 * Complete JavaScript implementation for pendaftar.php
 */

// ======== 📂 GLOBAL VARIABLES ========

// ✨ Use the API URL passed from PHP ✨
const API_BASE_URL = '<?php echo rtrim($apiUrl, '/'); ?>'; // Ensure no trailing slash initially
let deleteId = null;

// ======== 🎨 UI UTILITIES ========

/**
 * Notification system for user feedback
 * @param {string} message - Message to display
 * @param {string} type - Type of notification (success, error, info)
 */
function showNotification(message, type = 'info') {
    // Remove any existing notifications
    document.querySelectorAll('.notification-toast').forEach(note => note.remove());

    // Create new notification element
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
        'bg-blue-500'
    } text-white max-w-md`;
    notification.textContent = message;

    // Add to DOM
    document.body.appendChild(notification);

    // Auto-remove after delay
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.5s ease-out';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

/**
 * Get CSS class for status styling
 * @param {string} status - Status value
 * @returns {string} CSS class
 */
function getStatusClass(status) {
    const classes = {
        'belum_diproses': 'bg-gray-100',
        'sudah_dihubungi': 'bg-yellow-100',
        'berminat': 'bg-green-100',
        'tidak_berminat': 'bg-red-100',
        'pendaftaran_selesai': 'bg-blue-100'
    };
    return classes[status] || classes['belum_diproses'];
}

/**
 * Modal handling system
 */
const Modal = {
    /**
     * Opens a modal by ID
     * @param {string} modalId - ID of modal to open
     */
    open(modalId) {
        console.log('Opening modal:', modalId); // Debug log
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal not found:', modalId);
            return;
        }

        // Force a reflow to ensure transitions work
        void modal.offsetWidth;

        // Add class that handles all the visibility properties
        modal.classList.add('modal-visible');
        modal.classList.remove('hidden');

        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    },

    /**
     * Closes a modal by ID
     * @param {string} modalId - ID of modal to close
     */
    close(modalId) {
        console.log('Closing modal:', modalId); // Debug log
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal not found:', modalId);
            return;
        }

        // Remove visibility class
        modal.classList.remove('modal-visible');
        modal.classList.add('hidden'); // Re-add hidden for Tailwind compatibility if needed

        // Restore background scrolling
        document.body.style.overflow = '';
    }
};

// ======== 📊 DATA OPERATIONS ========

/**
 * Fetch pendaftar data
 * @param {number} id - Pendaftar ID
 * @returns {Promise<Object>} Pendaftar data
 */
async function fetchPendaftar(id) {
    try {
        // ✨ Use the dynamic API_BASE_URL ✨
        const response = await fetch(`${API_BASE_URL}/${id}`);
        if (!response.ok) throw new Error('Failed to fetch data');
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        showNotification('❌ Error fetching data: ' + error.message, 'error');
        throw error;
    }
}

/**
 * Update pendaftar status
 * @param {number} id - Pendaftar ID
 * @param {string} status - New status value
 * @returns {Promise<boolean>} Success state
 */
async function updateStatus(id, status) {
    try {
        const response = await fetch('data/update-status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id, status, update_status: true })
        });

        if (!response.ok) throw new Error('Failed to update status');

        const data = await response.json();
        if (data.success) {
            showNotification('✅ Status berhasil diperbarui', 'success');
            // Find the select element and update its background dynamically
            const selectElement = document.querySelector(`select.status-select[data-id="${id}"]`);
            if (selectElement) {
                selectElement.className = `status-select px-2 py-1 rounded border ${getStatusClass(status)}`;
            }
            return true;
        } else {
            throw new Error(data.message || 'Failed to update status');
        }
    } catch (error) {
        console.error('Status update error:', error);
        showNotification('❌ Gagal memperbarui status', 'error');
        return false;
    }
}

// ======== 🚀 FEATURE IMPLEMENTATIONS ========

/**
 * Show detailed pendaftar information
 * @param {number} id - Pendaftar ID
 */
async function showDetail(id) {
    try {
        // Fetch data
        const data = await fetchPendaftar(id);

        // Format helpers
        const formatDate = dateString => {
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

        const formatValue = value => value || '-';
        const formatGender = gender => {
            if (!gender) return '-';
            return gender.charAt(0).toUpperCase() + gender.slice(1);
        };

        const formatWorkingStatus = status => {
            if (status === null || status === undefined) return '-';
            return status ? 'Ya' : 'Tidak';
        };

        // Generate content
        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = `
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Personal Information -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded">
                        <h3 class="font-bold text-blue-800 mb-2">📋 Data Pribadi</h3>
                    </div>

                    <div class="font-bold">Nama Lengkap:</div>
                    <div>${formatValue(data.nama_lengkap)}</div>

                    <div class="font-bold">NIK:</div>
                    <div>${formatValue(data.nik)}</div>

                    <div class="font-bold">Tempat, Tanggal Lahir:</div>
                    <div>${formatValue(data.tempat_lahir)}, ${formatDate(data.tanggal_lahir)}</div>

                    <div class="font-bold">Nama Ibu Kandung:</div>
                    <div>${formatValue(data.ibu_kandung)}</div>

                    <div class="font-bold">Jenis Kelamin:</div>
                    <div>${formatGender(data.jenis_kelamin)}</div>

                    <div class="font-bold">Agama:</div>
                    <div>${formatValue(data.agama)}</div>

                    <!-- Contact Information -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">📱 Informasi Kontak</h3>
                    </div>

                    <div class="font-bold">Nomor HP:</div>
                    <div>${formatValue(data.nomor_hp)}</div>

                    <div class="font-bold">Alamat:</div>
                    <div>${formatValue(data.alamat)}</div>

                    <!-- Academic Information -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">🎓 Informasi Akademik</h3>
                    </div>

                    <div class="font-bold">Program Studi:</div>
                    <div>${formatValue(data.jurusan)}</div>

                    <div class="font-bold">Jalur Program:</div>
                    <div>${formatValue(data.jalur_program)}</div>

                    <!-- Additional Information -->
                    <div class="col-span-2 bg-blue-50 p-2 rounded mt-4">
                        <h3 class="font-bold text-blue-800 mb-2">ℹ️ Informasi Tambahan</h3>
                    </div>

                    <div class="font-bold">Status Bekerja:</div>
                    <div>${formatWorkingStatus(data.bekerja)}</div>

                    <div class="font-bold">Tempat Kerja:</div>
                    <div>${formatValue(data.tempat_kerja)}</div>

                    <div class="font-bold">Ukuran Baju:</div>
                    <div>${formatValue(data.ukuran_baju)}</div>

                    <div class="font-bold">Status Pendaftaran:</div>
                    <div class="px-2 py-1 rounded font-semibold inline-block ${getStatusClass(data.status)}">
                        ${(data.status?.replace(/_/g, ' ') || 'BELUM DIPROSES').toUpperCase()}
                    </div>
                </div>
            </div>
        `;

        // Open modal
        Modal.open('detailModal');
    } catch (error) {
        showNotification('❌ Gagal memuat detail pendaftar', 'error');
        console.error('Detail view error:', error);
    }
}

/**
 * Load edit form with pendaftar data
 * @param {number} id - Pendaftar ID
 */
async function editData(id) {
    try {
        // Fetch data
        const data = await fetchPendaftar(id);

        // Get form and reset
        const form = document.getElementById('editForm');
        if (!form) throw new Error('Edit form not found');
        form.reset();

        // Populate fields
        document.getElementById('editId').value = id;

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
                // Format date for date input
                input.value = data[field].split('T')[0];
            } else if (field === 'bekerja') {
                // Convert boolean/integer to string
                input.value = data[field] ? "1" : "0";
            } else {
                input.value = data[field] || '';
            }
        });

        // Open modal
        Modal.open('editModal');
    } catch (error) {
        showNotification('❌ Gagal memuat data untuk diedit', 'error');
        console.error('Edit form error:', error);
    }
}

/**
 * Save edited pendaftar data
 * @param {Event} event - Form submit event
 */
async function saveEditData(event) {
    event.preventDefault();

    const form = event.target;
    const id = document.getElementById('editId').value;
    const saveButton = document.getElementById('saveEditButton');
    const saveText = saveButton.querySelector('.save-text');
    const loadingText = saveButton.querySelector('.loading-text');

    try {
        // Show loading state
        form.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = true);
        saveText.classList.add('hidden');
        loadingText.classList.remove('hidden');

        // Create a new empty update object
        const updateData = { id: id };

        // Directly read all form field values and add them to the update data
        const formElements = form.querySelectorAll('[name]');
        formElements.forEach(element => {
            const name = element.name;
            if (name === 'id') return;

            let value = '';

            // Handle different input types
            if (element.type === 'checkbox') {
                value = element.checked ? '1' : '0';
            } else if (element.type === 'select-one' || element.type === 'select-multiple') {
                value = element.options[element.selectedIndex]?.value || '';
            } else {
                value = element.value;
            }

            // Special handling for boolean fields
            if (name === 'bekerja') {
                updateData[name] = value === '1' ? 1 : 0;
            } else {
                updateData[name] = value;
            }
        });

        // Send the update data to API
        const response = await fetch(`${API_BASE_URL}/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            },
            body: JSON.stringify(updateData)
        });

        // Handle response
        const responseData = await response.json();
        if (!response.ok) {
            throw new Error(responseData.message || 'Failed to update data');
        }

        showNotification('✨ Data berhasil diperbarui!', 'success');
        Modal.close('editModal');

        // Force reload to show updated data
        setTimeout(() => location.reload(), 500);
    } catch (error) {
        showNotification('❌ Gagal menyimpan: ' + error.message, 'error');
        console.error('Save error:', error);
    } finally {
        // Reset form state
        form.querySelectorAll('input, select, textarea, button').forEach(el => el.disabled = false);
        saveText.classList.remove('hidden');
        loadingText.classList.add('hidden');
    }
}

/**
 * Confirm pendaftar deletion
 * @param {number} id - Pendaftar ID
 */
function confirmDelete(id) {
    deleteId = id;
    Modal.open('deleteConfirmModal');
}

/**
 * Delete pendaftar
 */
async function deleteData() {
    if (!deleteId) return;

    try {
        const response = await fetch(`${API_BASE_URL}/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-API-KEY': 'pantanmandiri25'
            }
        });

        if (!response.ok) throw new Error('Failed to delete data');

        showNotification('✅ Data berhasil dihapus!', 'success');
        Modal.close('deleteConfirmModal');
        location.reload();
    } catch (error) {
        showNotification('❌ Gagal menghapus data', 'error');
        console.error('Delete error:', error);
    }
}

/**
 * Send initial WhatsApp message to pendaftar
 * @param {string} phone - Phone number
 * @param {string} name - Pendaftar name
 * @param {number} id - Pendaftar ID
 */
function sendInitialMessage(phone, name, id) {
    if (!phone) {
        showNotification('❌ Nomor telepon tidak tersedia', 'error');
        return;
    }

    // Format phone number for WhatsApp
    const formattedPhone = phone.startsWith('0') ? '62' + phone.slice(1) : phone;

    // Create message
    const message = `Halo ${name},\n\nPendaftaran di Universitas Terbuka Sentra Layanan Tana Toraja - Toraja Utara kembali dibuka. Jika tertarik untuk melanjutkan pendaftaran kami dapat memberikan berkas yang diperlukan untuk diisi. .\n\nSalam,\nTim UT Tana Toraja - Toraja Utara`;

    // Open WhatsApp
    const whatsappUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');

    // Update status
    updateStatus(id, 'sudah_dihubungi');
}

/**
 * Send payment instruction WhatsApp message
 * @param {string} phone - Phone number
 * @param {string} name - Pendaftar name
 * @param {string} programPath - Jalur Program (Reguler or Transfer Nilai)
 */
function sendPaymentMessage(phone, name, programPath) {
    if (!phone) {
        showNotification('❌ Nomor telepon tidak tersedia', 'error');
        return;
    }

    // Format phone number for WhatsApp
    const formattedPhone = phone.startsWith('0') ? '62' + phone.slice(1) : phone;

    // Get time-based greeting (GMT+8)
    const getGreeting = () => {
        const now = new Date();
        const utcHours = now.getUTCHours();
        const gmt8Hours = (utcHours + 8) % 24; // Convert to GMT+8

        if (gmt8Hours >= 5 && gmt8Hours < 12) {
            return "Selamat pagi";
        } else if (gmt8Hours >= 12 && gmt8Hours < 15) {
            return "Selamat siang";
        } else if (gmt8Hours >= 15 && gmt8Hours < 18) {
            return "Selamat sore";
        } else {
            return "Selamat malam";
        }
    };

    // Create message with dynamic greeting based on program path
    let message;
    if (programPath === 'Transfer Nilai') {
        message = `${getGreeting()}, ${name}

terima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:

1. Membayar uang pendaftaran Transfer Nilai/RPL sebesar Rp600.000 ke nomor rekening berikut:
Nama : Ribka Padang (Kepala SALUT Tana Toraja)
Bank : Mandiri
Nomor Rekening : 1700000588917

2. Melengkapi berkas data diri berupa:
- Foto diri Formal (dapat menggunakan foto HP)
- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)
- Foto Ijazah asli
- Mengisi formulir kelengkapan data lainnya (berkas kelengkapan data akan dikirimkan)`;
    } else {
        message = `${getGreeting()}, ${name}

terima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:

1. Membayar uang pendaftaran sebesar Rp200.000 ke nomor rekening berikut:
Nama : Ribka Padang (Kepala SALUT Tana Toraja)
Bank : Mandiri
Nomor Rekening : 1700000588917

2. Melengkapi berkas data diri berupa:
- Foto diri Formal (dapat menggunakan foto HP)
- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)
- Foto Ijazah dilegalisir cap basah atau Foto ijazah asli
- Mengisi formulir Keabsahan Data (dikirimkan)`;
    }

    // Open WhatsApp
    const whatsappUrl = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// ======== 🔄 EVENT LISTENERS ========
document.addEventListener('DOMContentLoaded', function() {
    // ESC key to close modals (keeping this for accessibility)
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal.modal-visible').forEach(modal => { // Only close visible modals
                Modal.close(modal.id);
            });
        }
    });

    // Form submission handlers
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', saveEditData);
    }
});

// Make all functions available globally
window.Modal = Modal;
window.showDetail = showDetail;
window.editData = editData;
window.confirmDelete = confirmDelete;
window.deleteData = deleteData;
window.sendInitialMessage = sendInitialMessage;
window.sendPaymentMessage = sendPaymentMessage;
window.showNotification = showNotification;
window.getStatusClass = getStatusClass;
window.updateStatus = updateStatus;
window.saveEditData = saveEditData; // Ensure saveEditData is globally accessible if needed outside the event listener
</script>
</head>
<body class="bg-gray-100">
    <div class="layout-container">
        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>
            
            <!-- Main content -->
            <div class="p-6">
                <div class="modal-content bg-white shadow-lg rounded-lg">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Daftar Pendaftar</h1>
                        <button onclick="Modal.open('addModal')" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Pendaftar
                        </button>
                    </div>

                    <!-- ✨ Search Form ✨ -->
                    <form method="GET" action="pendaftar.php" class="mb-6">
                        <div class="flex">
                            <input type="text"
                                   id="searchInput"
                                   name="search"
                                   placeholder="Cari nama, HP, atau jurusan..."
                                   class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="<?php echo htmlspecialchars($search_term); ?>">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

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
                                            <td class="py-4 px-6 row-number"><?php echo $start_index + $index + 1; ?></td>
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
                                                <div class="flex justify-center items-center space-x-2">
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
                                                        <button onclick="sendInitialMessage('<?php echo htmlspecialchars($pendaftar['nomor_hp'] ?? '', ENT_QUOTES); ?>', '<?php echo addslashes(htmlspecialchars($pendaftar['nama_lengkap'] ?? '', ENT_QUOTES)); ?>', <?php echo $pendaftar['id']; ?>)"
                                                                class="bg-purple-500 text-white px-3 py-1 rounded-lg hover:bg-purple-600 transition duration-200"
                                                                title="Kirim Pesan Awal (WA)">
                                                            <i class="fab fa-whatsapp"></i> 1
                                                        </button>
                                                        <button onclick="sendPaymentMessage('<?php echo htmlspecialchars($pendaftar['nomor_hp'] ?? '', ENT_QUOTES); ?>', '<?php echo addslashes(htmlspecialchars($pendaftar['nama_lengkap'] ?? '', ENT_QUOTES)); ?>', '<?php echo htmlspecialchars($pendaftar['jalur_program'] ?? 'Reguler', ENT_QUOTES); ?>')"
                                                                class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition duration-200"
                                                                title="Kirim Pesan Pembayaran (WA)">
                                                            <i class="fab fa-whatsapp"></i> 2
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr id="noDataRow">
                                        <td colspan="6" class="py-4 px-6 text-center">
                                            <?php if (!empty($search_term)): ?>
                                                Tidak ada data pendaftar yang cocok dengan pencarian "<?php echo htmlspecialchars($search_term); ?>"
                                            <?php else: ?>
                                                Tidak ada data pendaftar
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Showing <?php echo $total_records > 0 ? $start_index + 1 : 0; ?>-<?php echo min($start_index + $items_per_page, $total_records); ?> 
                            of <?php echo $total_records; ?> entries <?php echo !empty($search_term) ? '(filtered)' : ''; ?>
                        </div>
                        <div class="flex space-x-2">
                            <?php if ($page > 1): ?>
                                <?php $search_param = !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>
                                <!-- First Page Button -->
                                <a href="?page=1<?php echo $search_param; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors"
                                   title="First Page">
                                    <i class="fas fa-angles-left"></i>
                                </a>
                                
                                <!-- Previous Button -->
                                <a href="?page=<?php echo $page - 1; ?><?php echo $search_param; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-chevron-left mr-1"></i> Previous
                                </a>
                            <?php endif; ?>

                            <?php
                            // Show page numbers
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);

                            for ($i = $start_page; $i <= $end_page; $i++):
                                $search_param = !empty($search_term) ? '&search=' . urlencode($search_term) : '';
                            ?>
                                <a href="?page=<?php echo $i; ?><?php echo $search_param; ?>" 
                                   class="px-3 py-1 <?php echo $i === $page ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700'; ?> rounded hover:bg-blue-600 hover:text-white transition-colors">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <?php $search_param = !empty($search_term) ? '&search=' . urlencode($search_term) : ''; ?>
                                <!-- Next Button -->
                                <a href="?page=<?php echo $page + 1; ?><?php echo $search_param; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                                    Next <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                                
                                <!-- Last Page Button -->
                                <a href="?page=<?php echo $total_pages; ?><?php echo $search_param; ?>" 
                                   class="px-3 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors"
                                   title="Last Page">
                                    <i class="fas fa-angles-right"></i>
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
            <div class="modal-content bg-white shadow-lg rounded-lg">
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

                    <!-- ✨ Added Nomor HP field ✨ -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nomor HP <span class="text-red-500">*</span></label>
                        <input type="tel" name="nomor_hp" pattern="[0-9+]*" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
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

                    <!-- ✨ Added Jenis Kelamin field ✨ -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Agama</label>
                        <select name="agama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Protestan">Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
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
                            <option value="Transfer Nilai">Transfer Nilai</option>
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
                            <option value="Transfer Nilai">Transfer Nilai</option>
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
</body>
</html>
<?php endif; ?>