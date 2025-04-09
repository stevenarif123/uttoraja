<?php
// Include auth file from the correct path
require_once __DIR__ . '/pendaftaran/list/auth.php';
require_once __DIR__ . '/koneksi.php';

// Get current user info
$currentUser = $auth->currentUser();

// Fetch latest unprocessed registrants ordered by newest ID first
try {
    $query = "SELECT * FROM pendaftar WHERE status = 'belum_diproses' OR status IS NULL ORDER BY id DESC LIMIT 5";
    $result = $conn->query($query);
    $latestPendaftar = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $latestPendaftar[] = $row;
        }
    }
    
    // Get total unprocessed count
    $totalUnprocessed = $conn->query("SELECT COUNT(*) as total FROM pendaftar WHERE status = 'belum_diproses' OR status IS NULL")->fetch_assoc()['total'];
} catch (Exception $e) {
    error_log("Error fetching latest registrants: " . $e->getMessage());
    $latestPendaftar = [];
    $totalUnprocessed = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UT Toraja - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Status Counter Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Pendaftaran Belum Diproses 📋</h2>
                    <p class="text-gray-600 mt-1">Ada <?php echo $totalUnprocessed; ?> pendaftar yang menunggu diproses</p>
                </div>
                <a href="pendaftaran/list/pendaftar.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Latest Registrants Table -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Pendaftar Terbaru 🆕</h2>
            </div>

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
                    <tbody class="text-gray-600 text-sm">
                        <?php if (!empty($latestPendaftar)): ?>
                            <?php foreach ($latestPendaftar as $index => $pendaftar): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-4 px-6"><?php echo $index + 1; ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nama_lengkap'] ?? '-'); ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['nomor_hp'] ?? '-'); ?></td>
                                    <td class="py-4 px-6"><?php echo htmlspecialchars($pendaftar['jurusan'] ?? '-'); ?></td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            Belum Diproses
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button onclick="showDetail(<?php echo $pendaftar['id']; ?>)" 
                                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200"
                                                    title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="sendInitialMessage('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap']); ?>', <?php echo $pendaftar['id']; ?>)"
                                                    class="bg-purple-500 text-white px-3 py-1 rounded-lg hover:bg-purple-600 transition duration-200"
                                                    title="Kirim Pesan Awal">
                                                <i class="fab fa-whatsapp"></i> 1
                                            </button>
                                            <button onclick="sendWhatsApp('<?php echo $pendaftar['nomor_hp']; ?>', '<?php echo addslashes($pendaftar['nama_lengkap']); ?>', <?php echo $pendaftar['id']; ?>)"
                                                    class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600 transition duration-200"
                                                    title="Kirim Info Pembayaran">
                                                <i class="fab fa-whatsapp"></i> 2
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-4 px-6 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-check-circle text-3xl mb-2"></i>
                                        <p>Semua pendaftar sudah diproses! 🎉</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Function to update status
        async function updateStatus(id, status) {
            try {
                const response = await fetch('pendaftaran/api/update-status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id, status })
                });
                
                if (!response.ok) throw new Error('Failed to update status');
                
                // Reload page to reflect changes
                location.reload();
            } catch (error) {
                console.error('Error updating status:', error);
                alert('Failed to update status: ' + error.message);
            }
        }

        // Function to show contact details
        function showDetail(id) {
            window.location.href = `pendaftaran/list/pendaftar.php?action=view&id=${id}`;
        }

        // Function to get greeting based on time of day
        function getGreeting() {
            const hour = new Date().getHours();
            if (hour < 12) return "Selamat pagi";
            if (hour < 15) return "Selamat siang";
            if (hour < 18) return "Selamat sore";
            return "Selamat malam";
        }

        // Function to send initial WhatsApp message and update status
        async function sendInitialMessage(phone, nama, id) {
            const formattedPhone = formatPhoneNumber(phone);
            const message = `${getGreeting()}, ${nama}\n\nKami ingin memberitahukan bahwa pendaftaran di Universitas Terbuka sudah dibuka kembali untuk semester ini. Apakah Anda tertarik untuk melanjutkan pendidikan di semester ini? 🎓\n\nJika berminat, kami siap membantu dan memandu proses pendaftaran Anda. Silakan balas pesan ini, dan kami akan dengan senang hati memberikan informasi lebih lanjut. 😊\n\nTerima kasih! 🙏`;
            
            // Update status first
            await updateStatus(id, 'sudah_dihubungi');
            
            // Open WhatsApp
            window.open(`https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`, '_blank');
        }

        // Function to send payment info WhatsApp message
        async function sendWhatsApp(phone, nama, id) {
            const formattedPhone = formatPhoneNumber(phone);
            const message = `${getGreeting()}, ${nama}\n\nterima kasih sudah mendaftar di Sentra Layanan Universitas Terbuka (SALUT) Tana Toraja, untuk melanjutkan pendaftaran silahkan melakukan langkah berikut:\n\n1. Membayar uang pendaftaran sebesar Rp. 200.000 ke nomor rekening berikut:\nNama: Ribka Padang (Kepala SALUT Tana Toraja)\nBank: Mandiri\nNomor Rekening: 1700000588917\n\n2. Melengkapi berkas data diri berupa:\n- Foto diri Formal (dapat menggunakan foto HP)\n- Foto KTP asli (KTP asli difoto secara keseluruhan/tidak terpotong)\n- Foto ijazah asli\n- Mengisi formulir Keabsahan Data (dikirimkan)`;
            
            // Update status first
            await updateStatus(id, 'berminat');
            
            // Open WhatsApp
            window.open(`https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`, '_blank');
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
    </script>
</body>
</html>
