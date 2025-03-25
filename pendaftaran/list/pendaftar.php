<?php
// Require authentication
require_once '../admin/auth.php';
requireLogin();

// Update API URL to use HTTPS instead of HTTP
$apiUrl = 'https://uttoraja.com/pendaftaran/api/pendaftar';

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
} catch (Exception $e) {
    $data = [];
    $error_message = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/pendaftar.css">
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
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
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
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pendaftarTableBody" class="text-gray-600 text-sm">
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $index => $pendaftar): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-4 px-6 row-number"><?php echo $index + 1; ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nama_lengkap']); ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nomor_hp']); ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['jurusan']); ?></td>
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
                                            <button onclick="sendWhatsApp('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap']); ?>')"
                                                    class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition duration-200">
                                                <i class="fab fa-whatsapp"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="noDataRow">
                                <td colspan="5" class="py-4 px-6 text-center">Tidak ada data pendaftar</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                    <!-- Will be populated by JavaScript -->
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

    <script>
        // Global variables for better organization and preventing undefined errors
        let lastTimeout = null; // Fix for the undefined lastTimeout variable
        let deleteId = null;
        
        // Define API URL and headers - ensure HTTPS protocol is used
        const apiUrl = '<?php echo $apiUrl; ?>';
        
        // Add a function to ensure all URLs use HTTPS when the page is loaded via HTTPS
        function secureUrl(url) {
            // If we're on HTTPS, make sure the URL also uses HTTPS
            if (window.location.protocol === 'https:' && url.startsWith('http:')) {
                return url.replace('http:', 'https:');
            }
            return url;
        }
        
        const apiHeaders = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-API-KEY': 'pantanmandiri25'
        };

        // Store all data in a global variable
        const allPendaftarData = <?php echo json_encode($data); ?>;
        
        // Initialize window variables early to prevent undefined errors
        window.currentEditId = null;
        window.config = {
            apiUrl: secureUrl(apiUrl),  // Ensure config uses secure URL
            apiHeaders: apiHeaders
        };

        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat pagi";
            if (hour < 15) return "Selamat siang";
            if (hour < 18) return "Selamat sore";
            return "Selamat malam";
        }

        function generateWhatsAppMessage(nama) {
            return `${getGreeting()}, ${nama}
            
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
        }

        // Improved fetch API function with HTTPS security and detailed logging
        async function fetchApi(url, options = {}) {
            try {
                // Ensure URL uses HTTPS if page is served over HTTPS
                const secureApiUrl = secureUrl(url);
                
                console.log('🚀 API Request:', { 
                    url: secureApiUrl, 
                    method: options.method || 'GET',
                    headers: options.headers || apiHeaders,
                    body: options.body || null
                });
                
                const response = await fetch(secureApiUrl, {
                    ...options,
                    headers: {
                        ...apiHeaders,
                        ...options.headers
                    }
                });
                
                const responseText = await response.text();
                console.log('📥 API Response Status:', response.status);
                console.log('📥 API Response Text:', responseText);
                
                let responseData;
                try {
                    responseData = JSON.parse(responseText);
                } catch (e) {
                    console.error('❌ JSON Parse Error:', e);
                    throw new Error(`Invalid JSON response: ${responseText.substring(0, 100)}...`);
                }
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}, Message: ${responseData.message || responseText}`);
                }
                
                return responseData;
            } catch (error) {
                console.error('❌ API Error:', error);
                throw error;
            }
        }
        
        // Function to find pendaftar by ID
        function findPendaftarById(id) {
            return allPendaftarData.find(p => p.id == id);
        }

        // Modal functions - moved up to ensure they're available early
        function openModal(modalId) {
            console.log('🔓 Opening modal:', modalId);
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.error('❌ Modal not found:', modalId);
                return;
            }
            
            // Remove hidden class
            modal.classList.remove('hidden');
            
            // Add show class and set display to block
            modal.classList.add('show');
            modal.style.display = 'block';
            
            // Prevent background scrolling
            document.body.style.overflow = 'hidden';
            
            console.log('✅ Modal opened:', modalId);
        }

        function closeModal(modalId) {
            console.log('🔒 Closing modal:', modalId);
            const modal = document.getElementById(modalId);
            if (!modal) {
                console.error('❌ Modal not found:', modalId);
                return;
            }
            
            // Add hidden class
            modal.classList.add('hidden');
            
            // Remove show class and set display to none
            modal.classList.remove('show');
            modal.style.display = 'none';
            
            // Allow background scrolling again
            document.body.style.overflow = 'auto';
            
            console.log('✅ Modal closed:', modalId);
        }
        
        // Updated showDetail function
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

        // Updated edit function
        function editData(id) {
            console.log('✏️ Editing data for ID:', id);
            try {
                const data = findPendaftarById(id);
                if (!data) {
                    throw new Error('Data tidak ditemukan');
                }

                // Update form HTML to include all fields
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
                `;

                // Update the form content
                document.getElementById('editForm').innerHTML = formContent + `
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

                // Store current edit ID to use in the update function
                window.currentEditId = id;
                
                openModal('editModal');
                
                // Immediately attach the event handler to the form
                const editForm = document.getElementById('editForm');
                if (editForm) {
                    // Remove any existing handler
                    editForm.removeEventListener('submit', handleEditFormSubmit);
                    // Add new handler
                    editForm.addEventListener('submit', handleEditFormSubmit);
                    console.log('✅ Edit form handler attached directly');
                }
            } catch (error) {
                console.error('Edit Error:', error);
                alert('Gagal memuat data: ' + error.message);
            }
        }

        function sendWhatsApp(phone, nama) {
            console.log('📱 Sending WhatsApp message to:', phone);
            const message = encodeURIComponent(generateWhatsAppMessage(nama));
            // WhatsApp already uses HTTPS, but this ensures it stays that way
            window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
        }

        function showAddModal() {
            console.log('➕ Opening add modal');
            // Create form content similar to edit form but empty
            const formContent = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nomor HP</label>
                        <input type="text" name="nomor_hp" required
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">NIK</label>
                        <input type="text" name="nik"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Ibu Kandung</label>
                        <input type="text" name="ibu_kandung"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jurusan</label>
                        <input type="text" name="jurusan"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Agama</label>
                        <input type="text" name="agama"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jalur Program</label>
                        <input type="text" name="jalur_program"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Ukuran Baju</label>
                        <select name="ukuran_baju"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Status Bekerja</label>
                        <select name="bekerja"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Tempat Kerja</label>
                        <input type="text" name="tempat_kerja"
                               class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Alamat</label>
                        <textarea name="alamat" rows="3"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-gray-700 font-bold mb-2">Pertanyaan</label>
                        <textarea name="pertanyaan" rows="3"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-4 border-t mt-6">
                    <button type="button" onclick="closeModal('addModal')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" id="addSubmitBtn"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            `;
            
            document.getElementById('addForm').innerHTML = formContent;
            openModal('addModal');
            
            // Immediately attach event handler
            const addForm = document.getElementById('addForm');
            if (addForm) {
                // Remove any existing handler
                addForm.removeEventListener('submit', handleAddFormSubmit);
                // Add new handler
                addForm.addEventListener('submit', handleAddFormSubmit);
                console.log('✅ Add form handler attached directly');
            }
        }

        // Improved delete confirmation function with enhanced logging
        function confirmDelete(id) {
            console.log('🗑️ Confirming deletion for ID:', id);
            if (!id) {
                console.error('❌ Invalid ID for deletion');
                alert('ID tidak valid');
                return;
            }
            
            deleteId = id;
            openModal('deleteConfirmModal');
            
            // Double check that it's opened
            setTimeout(() => {
                const modal = document.getElementById('deleteConfirmModal');
                if (modal && !modal.classList.contains('show')) {
                    console.warn('⚠️ Modal may not be showing properly, forcing display');
                    modal.style.display = 'block';
                    modal.classList.add('show');
                }
            }, 100);
        }

        // Also update delete function to ensure HTTPS usage
        async function deleteData() {
            console.log('🗑️ Execute deletion for ID:', deleteId);
            if (!deleteId) {
                console.error('❌ No delete ID found');
                alert('Tidak ada ID yang akan dihapus');
                return;
            }
            
            try {
                console.log('🔄 Sending delete request for ID:', deleteId);
                const deleteUrl = secureUrl(`${apiUrl}/${deleteId}`);
                console.log('🔗 Delete URL (secured):', deleteUrl);
                
                const response = await fetchApi(deleteUrl, {
                    method: 'DELETE'
                });

                console.log('✅ Delete successful:', response);
                closeModal('deleteConfirmModal');
                alert('Data berhasil dihapus! 🎉');
                location.reload();
            } catch (error) {
                console.error('❌ Delete Error:', error);
                alert(`Gagal menghapus data: ${error.message}`);
            }
        }

        // Improved add form submission
        async function handleAddFormSubmit(e) {
            e.preventDefault();
            console.log('📝 Add form submitted');
            
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
            
            console.log('📤 Form data to send:', formData);
            
            try {
                // Ensure we use HTTPS for the request
                const addUrl = secureUrl(apiUrl);
                console.log('🔗 Add URL (secured):', addUrl);
                
                const response = await fetchApi(addUrl, {
                    method: 'POST',
                    body: JSON.stringify(formData)
                });

                console.log('✅ Add successful:', response);
                closeModal('addModal');
                alert('Data berhasil ditambahkan! 🎉');
                location.reload();
            } catch (error) {
                console.error('❌ Add Error:', error);
                alert(`Gagal menambahkan data: ${error.message}`);
            }
        }

        // Improved edit form submission with explicit HTTPS handling
        async function handleEditFormSubmit(e) {
            e.preventDefault();
            console.log('📝 Edit form submitted');
            
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
                // Make explicit PUT request to update data with secure URL
                const updateUrl = secureUrl(`${apiUrl}/${id}`);
                console.log('🔗 Update URL (secured):', updateUrl);
                
                const response = await fetch(updateUrl, {
                    method: 'PUT',
                    headers: apiHeaders,
                    body: JSON.stringify(formData)
                });
                
                const responseText = await response.text();
                console.log('📥 Update Response Status:', response.status);
                console.log('📥 Update Response Text:', responseText);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}, Message: ${responseText}`);
                }
                
                console.log('✅ Update successful!');
                closeModal('editModal');
                alert('Data berhasil diperbarui! 🎉');
                location.reload();
            } catch (error) {
                console.error('❌ Update Error:', error);
                alert(`Gagal memperbarui data: ${error.message}`);
            }
        }

        // Initialize everything when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 DOM fully loaded and parsed');
            
            // Initialize search functionality
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('pendaftarTableBody');
            
            if (searchInput && tableBody) {
                const rows = Array.from(tableBody.getElementsByTagName('tr'));
                const noDataRow = document.getElementById('noDataRow');
                
                // Search functionality - with correctly defined lastTimeout
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
                            // Update row number
                            const rowNumber = row.querySelector('.row-number');
                            if (rowNumber) rowNumber.textContent = visibleCount;
                        }
                    });

                    // Show/hide no data message
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
                
                console.log('🔍 Search functionality initialized');
            }
            
            // Add explicit event listeners to all buttons for better certainty
            document.querySelectorAll('button[onclick^="showDetail"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    console.log('🔍 Detail button clicked, executing:', originalOnClick);
                    // Extract ID from the onclick attribute that was like showDetail(123)
                    const match = originalOnClick.match(/showDetail\((\d+)\)/);
                    if (match && match[1]) {
                        showDetail(match[1]);
                    }
                });
                console.log('📝 Rewired Detail button');
            });
            
            document.querySelectorAll('button[onclick^="editData"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    console.log('✏️ Edit button clicked, executing:', originalOnClick);
                    const match = originalOnClick.match(/editData\((\d+)\)/);
                    if (match && match[1]) {
                        editData(match[1]);
                    }
                });
                console.log('📝 Rewired Edit button');
            });
            
            document.querySelectorAll('button[onclick^="confirmDelete"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    console.log('🗑️ Delete button clicked, executing:', originalOnClick);
                    const match = originalOnClick.match(/confirmDelete\((\d+)\)/);
                    if (match && match[1]) {
                        confirmDelete(match[1]);
                    }
                });
                console.log('📝 Rewired Delete button');
            });
            
            document.querySelectorAll('button[onclick^="sendWhatsApp"]').forEach(btn => {
                const originalOnClick = btn.getAttribute('onclick');
                btn.removeAttribute('onclick');
                
                btn.addEventListener('click', function() {
                    console.log('📱 WhatsApp button clicked, executing:', originalOnClick);
                    const match = originalOnClick.match(/sendWhatsApp\('([^']+)',\s*'([^']+)'\)/);
                    if (match && match[1] && match[2]) {
                        sendWhatsApp(match[1], match[2]);
                    }
                });
                console.log('📝 Rewired WhatsApp button');
            });
            
            // Also fix the Add Pendaftar button
            const addButton = document.querySelector('button[onclick^="showAddModal"]');
            if (addButton) {
                addButton.removeAttribute('onclick');
                addButton.addEventListener('click', function() {
                    console.log('➕ Add button clicked');
                    showAddModal();
                });
                console.log('📝 Rewired Add button');
            }
            
            // Test modal functionality
            console.log('🧪 Testing modal system...');
            const testModal = document.createElement('div');
            testModal.id = 'testModal';
            testModal.className = 'modal hidden';
            testModal.innerHTML = '<div class="modal-dialog"><div class="modal-content">Test Modal</div></div>';
            document.body.appendChild(testModal);
            
            try {
                openModal('testModal');
                setTimeout(() => {
                    closeModal('testModal');
                    document.body.removeChild(testModal);
                    console.log('✅ Modal system working properly');
                }, 50);
            } catch (e) {
                console.error('❌ Modal system test failed:', e);
            }
            
            console.log('✅ All functionality initialized');
        });
    </script>
</body>
</html>
