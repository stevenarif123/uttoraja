<?php
session_start();

// Fungsi untuk mendapatkan akses token
function getAccessToken()
{
    $url = 'https://api-sia.ut.ac.id/backend-sia/api/graphql';

    // Data JSON untuk login
    $data = array(
        'query' => 'mutation { signInUser (email: "f.ann.y.kar.li.n.da.bn.c@gmail.com", password: "@11032006Ut") { access_token } }',
        'variables' => array()
    );

    // Konversi data ke JSON
    $json_data = json_encode($data);

    // Header CURL
    $headers = array(
        'Host: api-sia.ut.ac.id',
        'Content-Type: application/json'
    );

    // Inisialisasi CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // Eksekusi CURL
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse respons JSON
    $result = json_decode($response, true);

    // Simpan hasil debugging
    $_SESSION['debug']['access_token_response'] = $result;

    return $result['data']['signInUser']['access_token'] ?? null;
}

// Fungsi untuk mencari mata kuliah
function searchMataKuliah($accessToken, $kodeMatakuliah)
{
    $url = 'https://api-sia.ut.ac.id/backend-sia/api/graphql';

    $data = array(
        'query' => '
            query searchMtkTawarByKode ($payload: SearchMtkInPayload!){
                searchMtkTawarByKode(payload: $payload){
                    data{
                        id_matakuliah
                        kode_matakuliah
                        sks
                        nama_matakuliah
                        nama_skema_ujian
                        keterangan_waktu_ujian
                    }
                }
            }
        ',
        'variables' => array(
            'payload' => array(
                'nim' => '',
                'kodeMatakuliah' => strtoupper($kodeMatakuliah)
            )
        )
    );

    // Simpan parameter yang dikirim untuk debugging
    $_SESSION['debug']['search_query'] = $data;

    // Konversi dan kirim request CURL
    $json_data = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: api-sia.ut.ac.id',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json, text/plain, */*',
        'Origin: https://admisi-sia.ut.ac.id',
        'Referer: https://admisi-sia.ut.ac.id/'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // Parse respons JSON
    $result = json_decode($response, true);

    // Simpan hasil respons untuk debugging
    $_SESSION['debug']['search_response'] = $result;

    return $result['data']['searchMtkTawarByKode']['data'] ?? [];
}

// Fungsi untuk mendapatkan biaya bahan ajar
function getBiayaBahanAjar($accessToken, $idMatakuliah)
{
    $url = 'https://api-sia.ut.ac.id/backend-sia/api/graphql';

    // Buat array statusBahanAjar dengan jumlah elemen sesuai jumlah mata kuliah
    $statusBahanAjar = array_fill(0, count($idMatakuliah), 1);

    // Data JSON untuk biaya bahan ajar
    $data = array(
        'query' => '
            query getBiayaBahanAjar($payload: GetBiayaBahanAjarInPayload!) {
                getBiayaBahanAjar(payload: $payload) {
                    hargaBaSatuan
                    totalOngkir
                    totalHargaMtk
                    hargaMtkSatuan
                    idMatakuliah
                    namaMatakuliah
                    kodeBa
                    namaBa
                    totalHargaBa
                    totalBeratBa
                    ketBeasiswa
                    totalLipBayar
                    totalTagihan
                }
            }
        ',
        'variables' => array(
            'payload' => array(
                'nim' => '',
                'statusBahanAjar' => $statusBahanAjar,
                'idMatakuliah' => array_map('intval', $idMatakuliah),
                'idWilayahUjian' => 426,
                'idAlamat' => 1
            )
        )
    );

    // Simpan parameter yang dikirim untuk debugging
    $_SESSION['debug']['biaya_query'] = $data;

    // Konversi dan kirim request CURL
    $json_data = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Host: api-sia.ut.ac.id',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json, text/plain, */*',
        'Origin: https://admisi-sia.ut.ac.id',
        'Referer: https://admisi-sia.ut.ac.id/',
        'Content-Length: ' . strlen($json_data)
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // Parse respons JSON
    $result = json_decode($response, true);

    // Simpan hasil respons untuk debugging
    $_SESSION['debug']['biaya_response'] = $result;

    return $result;
}

// Inisialisasi variabel
$hasilPencarian = [];

// Proses request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accessToken = getAccessToken();
    $_SESSION['debug']['access_token'] = $accessToken;

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'search':
                $kodeMatakuliah = $_POST['kode_matakuliah'] ?? '';
                $hasilPencarian = searchMataKuliah($accessToken, $kodeMatakuliah);
                break;

            case 'tambah_pesanan':
                if (isset($_POST['id_matakuliah'], $_POST['nama_matakuliah'], $_POST['sks'])) {
                    if (!isset($_SESSION['pesanan'])) {
                        $_SESSION['pesanan'] = [];
                    }

                    $newItem = [
                        'id_matakuliah' => $_POST['id_matakuliah'],
                        'nama_matakuliah' => $_POST['nama_matakuliah'],
                        'sks' => $_POST['sks']
                    ];

                    // Check if item already exists
                    $exists = false;
                    foreach ($_SESSION['pesanan'] as $pesanan) {
                        if ($pesanan['id_matakuliah'] === $newItem['id_matakuliah']) {
                            $exists = true;
                            break;
                        }
                    }

                    if (!$exists) {
                        $_SESSION['pesanan'][] = $newItem;
                        $_SESSION['total_sks'] = array_sum(array_column($_SESSION['pesanan'], 'sks'));
                    }
                }
                break;

            case 'hapus_pesanan':
                if (isset($_POST['id_matakuliah']) && isset($_SESSION['pesanan'])) {
                    foreach ($_SESSION['pesanan'] as $key => $pesanan) {
                        if ($pesanan['id_matakuliah'] === $_POST['id_matakuliah']) {
                            unset($_SESSION['pesanan'][$key]);
                            break;
                        }
                    }
                    $_SESSION['pesanan'] = array_values($_SESSION['pesanan']);
                    $_SESSION['total_sks'] = array_sum(array_column($_SESSION['pesanan'], 'sks'));
                }
                break;

            case 'proses_biaya':
                if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])) {
                    $matakuliahUntukDiproses = array_column($_SESSION['pesanan'], 'id_matakuliah');
                    $biayaResponse = getBiayaBahanAjar($accessToken, $matakuliahUntukDiproses);
                    $_SESSION['biaya_data'] = $biayaResponse;
                }
                break;

            case 'update_max_sks':
                if (isset($_POST['max_sks'])) {
                    $_SESSION['max_sks'] = (int)$_POST['max_sks'];
                }
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
        }

        form {
            margin-bottom: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Button styles with different colors */
        button {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        /* Search button */
        form button[type="submit"] {
            background-color: #4CAF50;
        }
        
        form button[type="submit"]:hover {
            background-color: #45a049;
            transform: translateY(-1px);
        }

        /* Add to cart button */
        form button[name="action"][value="tambah_pesanan"] {
            background-color: #ff9800;
        }

        form button[name="action"][value="tambah_pesanan"]:hover {
            background-color: #f57c00;
            transform: translateY(-1px);
        }

        /* Delete button */
        form button[name="action"][value="hapus_pesanan"] {
            background-color: #f44336;
        }

        form button[name="action"][value="hapus_pesanan"]:hover {
            background-color: #d32f2f;
            transform: translateY(-1px);
        }

        /* View details button */
        #showModalBtn {
            background-color: #673ab7;
            margin-right: 10px;
        }

        #showModalBtn:hover {
            background-color: #5e35b1;
            transform: translateY(-1px);
        }

        /* Process cost button */
        form button[name="action"][value="proses_biaya"] {
            background-color: #2196F3;
        }

        form button[name="action"][value="proses_biaya"]:hover {
            background-color: #1976D2;
            transform: translateY(-1px);
        }

        /* Debug toggle button */
        .debug-toggle {
            background-color: #9c27b0;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1051;
            padding: 8px 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .debug-toggle:hover {
            background-color: #7B1FA2;
            transform: translateY(-1px);
        }

        /* Debug Window Styles */
        .debug-box {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 400px;
            max-height: 80vh;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 0;
            overflow: auto;
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .debug-box.hidden {
            transform: translateY(calc(100% + 20px));
            opacity: 0;
            pointer-events: none;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            margin: 0;
            font-size: 14px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1055;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            margin: 30px auto;
            padding: 25px;
            border: none;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            position: relative;
            transform: translateY(-50px);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            color: #666;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .close:hover {
            color: #333;
            transform: scale(1.1);
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
            padding-right: 10px;
        }

        .total-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .total-info:last-child {
            border-bottom: none;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #eee;
        }

        .total-info h4 {
            margin: 0;
            color: #333;
            font-weight: 500;
        }

        .total-info span {
            font-weight: bold;
            color: #2196F3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .modal-content {
                margin: 15px;
                padding: 15px;
            }

            button {
                width: 100%;
                margin-bottom: 10px;
            }

            #showModalBtn {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <form method="POST">
        <input type="text" name="email" value="f.ann.y.kar.li.n.da.bn.c@gmail.com" placeholder="Masukkan Email">
        <input type="password" name="password" value="@11032006Ut" placeholder="Masukkan Password">
        <input type="hidden" name="action" value="update_email_password">
        <button type="submit">Simpan</button>
    </form>

    <h1>Pesanan Mata Kuliah</h1>

    <form method="POST">
        <input type="text" name="kode_matakuliah" placeholder="Masukkan Kode Mata Kuliah" required>
        <input type="hidden" name="action" value="search">
        <button type="submit">Cari</button>
    </form>

    <?php if (!empty($hasilPencarian)): ?>
        <h2>Hasil Pencarian</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasilPencarian as $matakuliah): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($matakuliah['kode_matakuliah']); ?></td>
                        <td><?php echo htmlspecialchars($matakuliah['nama_matakuliah']); ?></td>
                        <td><?php echo htmlspecialchars($matakuliah['sks']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;margin:0;padding:0;background:none;box-shadow:none;">
                                <input type="hidden" name="id_matakuliah" value="<?php echo htmlspecialchars($matakuliah['id_matakuliah']); ?>">
                                <input type="hidden" name="nama_matakuliah" value="<?php echo htmlspecialchars($matakuliah['nama_matakuliah']); ?>">
                                <input type="hidden" name="sks" value="<?php echo htmlspecialchars($matakuliah['sks']); ?>">
                                <input type="hidden" name="action" value="tambah_pesanan">
                                <button type="submit">Tambah ke Pesanan</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Pilihan Maksimum SKS -->
    <form method="POST">
        <select name="max_sks">
            <option value="20" <?php echo (isset($_SESSION['max_sks']) && $_SESSION['max_sks'] == 20) ? 'selected' : ''; ?>>20 SKS</option>
            <option value="24" <?php echo (isset($_SESSION['max_sks']) && $_SESSION['max_sks'] == 24) ? 'selected' : ''; ?>>24 SKS</option>
        </select>
        <input type="hidden" name="action" value="update_max_sks">
        <button type="submit">Simpan</button>
    </form>

    <h2>Daftar Pesanan</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])): ?>
                <?php foreach ($_SESSION['pesanan'] as $pesanan): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pesanan['id_matakuliah']); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['nama_matakuliah']); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['sks']); ?></td>
                        <td>
                            <form method="POST" style="display:inline;margin:0;padding:0;background:none;box-shadow:none;">
                                <input type="hidden" name="id_matakuliah" value="<?php echo htmlspecialchars($pesanan['id_matakuliah']); ?>">
                                <input type="hidden" name="action" value="hapus_pesanan">
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Tidak ada pesanan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Jumlah SKS:</th>
                <th><?php echo htmlspecialchars($_SESSION['total_sks'] ?? 0); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <?php if (!empty($_SESSION['pesanan'])): ?>
        <button id="showModalBtn">Lihat Detail Pesanan</button>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="action" value="proses_biaya">
            <button type="submit">Proses Biaya</button>
        </form>
    <?php endif; ?>

    <!-- Debug Toggle Button -->
    <button class="debug-toggle" onclick="toggleDebug()">Toggle Debug</button>

    <!-- Debug Information -->
    <?php if (isset($_SESSION['debug'])): ?>
        <div class="debug-box hidden">
            <h2>Debugging Information</h2>
            <pre><?php echo htmlspecialchars(json_encode($_SESSION['debug'], JSON_PRETTY_PRINT)); ?></pre>
        </div>
        <?php unset($_SESSION['debug']); ?>
    <?php endif; ?>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail Pesanan</h2>
                <button class="close">&times;</button>
            </div>
            <div class="modal-body">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode BA</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Harga Modul</th>
                            <th>Total Harga Mata Kuliah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan']) && isset($_SESSION['biaya_data'])):
                            $biayaDataAll = $_SESSION['biaya_data']['data']['getBiayaBahanAjar'] ?? [];
                            foreach ($_SESSION['pesanan'] as $index => $pesanan):
                                $biayaData = $biayaDataAll[$index] ?? null;
                                if ($biayaData):
                        ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($biayaData['kodeBa'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($pesanan['nama_matakuliah']); ?></td>
                                        <td><?php echo 'Rp ' . number_format($biayaData['hargaBaSatuan'] ?? 0, 0, ',', '.'); ?></td>
                                        <td><?php echo 'Rp ' . number_format($biayaData['hargaMtkSatuan'] ?? 0, 0, ',', '.'); ?></td>
                                    </tr>
                        <?php
                                endif;
                            endforeach;
                        else: ?>
                            <tr>
                                <td colspan="5">Tidak ada detail pesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Informasi Total -->
                <?php if (isset($_SESSION['biaya_data']) && isset($_SESSION['biaya_data']['data']['getBiayaBahanAjar'][0])): 
                    $biayaData = $_SESSION['biaya_data']['data']['getBiayaBahanAjar'][0];
                ?>
                    <div class="total-info">
                        <h4>Total Harga Mata Kuliah:</h4>
                        <span><?php echo 'Rp ' . number_format($biayaData['totalHargaMtk'] ?? 0, 0, ',', '.'); ?></span>
                    </div>
                    <div class="total-info">
                        <h4>Total Harga Modul:</h4>
                        <span><?php echo 'Rp ' . number_format($biayaData['totalHargaBa'] ?? 0, 0, ',', '.'); ?></span>
                    </div>
                    <div class="total-info">
                        <h4>Total Berat:</h4>
                        <span><?php echo number_format($biayaData['totalBeratBa'] ?? 0, 2, ',', '.') . ' Kg'; ?></span>
                    </div>
                    <div class="total-info">
                        <h4>Total Ongkir:</h4>
                        <span><?php echo 'Rp ' . number_format($biayaData['totalOngkir'] ?? 0, 0, ',', '.'); ?></span>
                    </div>
                    <div class="total-info">
                        <h4>Total Tagihan:</h4>
                        <span><?php echo 'Rp ' . number_format($biayaData['totalTagihan'] ?? 0, 0, ',', '.'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Debug window toggle
        function toggleDebug() {
            const debugBox = document.querySelector('.debug-box');
            if (debugBox) {
                debugBox.classList.toggle('hidden');
            }
        }

        // Modal functionality with animations
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("showModalBtn");
        const closeBtn = document.querySelector(".close");

        if (btn) {
            btn.onclick = function() {
                modal.style.display = "block";
                // Trigger reflow
                modal.offsetHeight;
                modal.classList.add("show");
            }
        }

        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.classList.remove("show");
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove("show");
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            }
        }
    </script>
</body>
</html>
