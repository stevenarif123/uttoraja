<?php
// Update API URL
$apiUrl = 'http://uttoraja.com/pendaftaran/api/pendaftar';

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

    <!-- Improved Detail Modal -->
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
                <div class="flex justify-between items-center p-4 border-b">
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
    <div id="addModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="modal-dialog bg-white rounded-lg mx-auto mt-10 max-w-4xl">
            <div class="modal-content p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Pendaftar Baru</h2>
                    <button onclick="closeModal('addModal')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <form id="addForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Form fields will be identical to edit form -->
                    <!-- Will be populated by JavaScript -->
                </form>
            </div>
        </div>
    </div>

    <!-- Add confirmation modal -->
    <div id="deleteConfirmModal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="modal-dialog bg-white rounded-lg mx-auto mt-20 max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Konfirmasi Hapus</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal('deleteConfirmModal')" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Batal
                </button>
                <button onclick="deleteData()" 
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
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

1. Membayar uang pendaftaran sebesar Rp. 200.000 sampai tanggal 21 Februari 2025 ke nomor rekening berikut:
Nama : Ribka Padang (Kepala SALUT Tana Toraja)
Bank : Mandiri
Nomor Rekening : 1700000588917

2. Melenkapi berkas data diri berupa:
- Foto diri Formal (dapat menggunakan foto HP)
- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)
- Foto Ijazah dilegalisir cap basah atau Foto ijazah asli
- Mengisi formulir Keabsahan Data (dikirimkan)`;
        }

        // Define API URL and headers
        const apiUrl = 'http://uttoraja.com/pendaftaran/api/pendaftar';
        const apiHeaders = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-API-KEY': 'pantanmandiri25'
        };

        // Generic fetch function with better error handling
        async function fetchApi(url, options = {}) {
            try {
                console.log('Fetching:', url); // Debug log
                const response = await fetch(url, {
                    ...options,
                    headers: {
                        ...apiHeaders,
                        ...options.headers
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new TypeError("Response is not JSON");
                }

                return await response.json();
            } catch (error) {
                console.error('API Error:', error);
                throw new Error('Gagal memuat data');
            }
        }

        // Store all data in a global variable
        const allPendaftarData = <?php echo json_encode($data); ?>;
        
        // Function to find pendaftar by ID
        function findPendaftarById(id) {
            return allPendaftarData.find(p => p.id == id);
        }

        // Updated showDetail function
        function showDetail(id) {
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
                alert('Gagal memuat data');
            }
        }

        // Updated edit function
        function editData(id) {
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
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                `;

                openModal('editModal');
            } catch (error) {
                console.error('Edit Error:', error);
                alert('Gagal memuat data');
            }
        }

        function sendWhatsApp(phone, nama) {
            const message = encodeURIComponent(generateWhatsAppMessage(nama));
            window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Update table button to use new WhatsApp function
        document.querySelectorAll('.whatsapp-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const phone = btn.dataset.phone;
                const nama = btn.dataset.nama;
                sendWhatsApp(phone, nama);
            });
        });

        // Handle edit form submission
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            try {
                const formData = {
                    nama_lengkap: document.getElementById('editNama').value,
                    nomor_hp: document.getElementById('editNomorHP').value,
                    nik: document.getElementById('editNIK').value,
                    ibu_kandung: document.getElementById('editIbuKandung').value,
                    tempat_lahir: document.getElementById('editTempatLahir').value,
                    tanggal_lahir: document.getElementById('editTanggalLahir').value,
                    jurusan: document.getElementById('editJurusan').value,
                    agama: document.getElementById('editAgama').value,
                    jenis_kelamin: document.getElementById('editJenisKelamin').value,
                    jalur_program: document.getElementById('editJalurProgram').value,
                    alamat: document.getElementById('editAlamat').value,
                    ukuran_baju: document.getElementById('editUkuranBaju').value,
                    tempat_kerja: document.getElementById('editTempatKerja').value,
                    bekerja: document.getElementById('editBekerja').value,
                    pertanyaan: document.getElementById('editPertanyaan').value
                };

                await fetchApi(`${apiUrl}/${id}`, {
                    method: 'PUT',
                    body: JSON.stringify(formData)
                });

                alert('Data berhasil diperbarui');
                location.reload();
            } catch (error) {
                console.error('Update Error:', error);
                alert('Gagal memperbarui data');
            }
        });

        // Update the WhatsApp button in the table
        document.querySelectorAll('a[href^="https://wa.me/"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const phone = this.closest('tr').querySelector('td:nth-child(3)').textContent;
                const nama = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                sendWhatsApp(phone, nama);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('pendaftarTableBody');
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const noDataRow = document.getElementById('noDataRow');
            let lastTimeout = null;

            function debounceSearch(fn, delay) {
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(lastTimeout);
                    lastTimeout = setTimeout(() => fn.apply(context, args), delay);
                };
            }

            const performSearch = debounceSearch(function(searchTerm) {
                searchTerm = searchTerm.toLowerCase().trim();
                let visibleCount = 0;

                rows.forEach((row, index) => {
                    if (row.id === 'noDataRow') return;

                    const text = row.textContent.toLowerCase();
                    const shouldShow = text.includes(searchTerm);

                    row.style.display = shouldShow ? '' : 'none';
                    
                    if (shouldShow) {
                        visibleCount++;
                        // Update row number
                        row.querySelector('.row-number').textContent = visibleCount;
                    }
                });

                // Show/hide no data message
                if (noDataRow) {
                    noDataRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            }, 300);

            searchInput.addEventListener('input', function() {
                performSearch(this.value);
            });

            // Add clear search functionality
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    performSearch('');
                }
            });
        });

        let deleteId = null;

        function showAddModal() {
            // Create form content similar to edit form but empty
            const formContent = `
                <div class="col-span-2">
                    <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Add all other fields similar to edit form but without values -->
                <!-- ... -->
                <div class="col-span-2 flex justify-end space-x-4 pt-4 border-t mt-6">
                    <button type="button" onclick="closeModal('addModal')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            `;
            
            document.getElementById('addForm').innerHTML = formContent;
            openModal('addModal');
        }

        function confirmDelete(id) {
            deleteId = id;
            openModal('deleteConfirmModal');
        }

        async function deleteData() {
            if (!deleteId) return;
            
            try {
                const response = await fetch(`${apiUrl}/${deleteId}`, {
                    method: 'DELETE',
                    headers: apiHeaders
                });

                if (!response.ok) throw new Error('Failed to delete');

                closeModal('deleteConfirmModal');
                location.reload();
            } catch (error) {
                console.error('Delete Error:', error);
                alert('Gagal menghapus data');
            }
        }

        // Add form submission handler
        document.getElementById('addForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = {
                nama_lengkap: this.nama_lengkap.value,
                nomor_hp: this.nomor_hp.value,
                tempat_lahir: this.tempat_lahir.value,
                tanggal_lahir: this.tanggal_lahir.value,
                ibu_kandung: this.ibu_kandung.value,
                nik: this.nik.value,
                jurusan: this.jurusan.value,
                agama: this.agama.value,
                jenis_kelamin: this.jenis_kelamin.value,
                jalur_program: this.jalur_program.value,
                alamat: this.alamat.value,
                ukuran_baju: this.ukuran_baju.value,
                tempat_kerja: this.tempat_kerja.value,
                bekerja: this.bekerja.value
            };

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: apiHeaders,
                    body: JSON.stringify(formData)
                });

                if (!response.ok) throw new Error('Failed to add data');

                closeModal('addModal');
                location.reload();
            } catch (error) {
                console.error('Add Error:', error);
                alert('Gagal menambahkan data');
            }
        });

        // Update edit form submission
        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            
            const formData = {
                nama_lengkap: this.nama_lengkap.value,
                nomor_hp: this.nomor_hp.value,
                tempat_lahir: this.tempat_lahir.value,
                tanggal_lahir: this.tanggal_lahir.value,
                ibu_kandung: this.ibu_kandung.value,
                nik: this.nik.value,
                jurusan: this.jurusan.value,
                agama: this.agama.value,
                jenis_kelamin: this.jenis_kelamin.value,
                jalur_program: this.jalur_program.value,
                alamat: this.alamat.value,
                ukuran_baju: this.ukuran_baju.value,
                tempat_kerja: this.tempat_kerja.value,
                bekerja: this.bekerja.value,
                pertanyaan: this.pertanyaan.value
            };

            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'PUT',
                    headers: apiHeaders,
                    body: JSON.stringify(formData)
                });

                if (!response.ok) throw new Error('Failed to update');

                closeModal('editModal');
                location.reload();
            } catch (error) {
                console.error('Update Error:', error);
                alert('Gagal memperbarui data');
            }
        });
    </script>
    <script>
        // Initialize configuration first
        window.config = {
            apiUrl: '<?php echo $apiUrl; ?>',
            apiHeaders: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-API-KEY': 'pantanmandiri25'
            }
        };
        
        // Initialize data
        window.allPendaftarData = <?php echo json_encode($data); ?>;
        window.currentEditId = null;
    </script>
    <!-- Load the JavaScript file after config initialization -->
    <script src="js/pendaftar.js"></script>
</body>
</html>
