<?php
session_start();

// Fungsi untuk mendapatkan akses token
function getAccessToken() {
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
function searchMataKuliah($accessToken, $kodeMatakuliah) {
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
function getBiayaBahanAjar($accessToken, $idMatakuliah) {
    $url = 'https://api-sia.ut.ac.id/backend-sia/api/graphql';

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
                'nim' => '', // Ganti dengan NIM yang sesuai
                'statusBahanAjar' => array(1, 1), // Status bahan ajar
                'idMatakuliah' => array_map('intval', $idMatakuliah), // Mengonversi ID mata kuliah ke integer
                'idWilayahUjian' => 426, // Pastikan ini benar
                'idAlamat' => 1 // Pastikan ini benar
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

    return $result; // Kembalikan hasil respons untuk digunakan lebih lanjut
}

// Inisialisasi variabel
$hasilPencarian = [];

// Proses request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accessToken = getAccessToken();

    // Simpan access token untuk debugging
    $_SESSION['debug']['access_token'] = $accessToken;

    // Pencarian Mata Kuliah
    if (isset($_POST['action']) && $_POST['action'] === 'search') {
        $kodeMatakuliah = $_POST['kode_matakuliah'] ?? '';
        $hasilPencarian = searchMataKuliah($accessToken, $kodeMatakuliah);
    }

    // Tambah Mata Kuliah ke Pesanan
    if (isset($_POST['action']) && $_POST['action'] === 'tambah_pesanan') {
        if (isset($_POST['id_matakuliah'], $_POST['nama_matakuliah'], $_POST['sks'])) {
            $idMatakuliah = $_POST['id_matakuliah'];
            $namaMatakuliah = $_POST['nama_matakuliah'];
            $sks = $_POST['sks'];
            
            if (!isset($_SESSION['pesanan'])) {
                $_SESSION['pesanan'] = [];
            }

            // Cek apakah mata kuliah sudah ada di pesanan
            $exists = false;
            foreach ($_SESSION['pesanan'] as $pesanan) {
                if ($pesanan['id_matakuliah'] == $idMatakuliah) {
                    $exists = true;
                    break;
                }
            }

            // Jika belum ada, tambahkan ke pesanan
            if (!$exists) {
                $_SESSION['pesanan'][] = [
                    'id_matakuliah' => $idMatakuliah,
                    'nama_matakuliah' => $namaMatakuliah,
                    'sks' => $sks,
                    'status_bahan_ajar' => 1 // Default status
                ];
            }
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Proses biaya bahan ajar
if (isset($_POST['action']) && $_POST['action'] === 'proses_biaya') {
    $accessToken = getAccessToken();

    if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])) {
        // Ambil mata kuliah yang akan diproses
        $matakuliahUntukDiproses = array_column($_SESSION['pesanan'], 'id_matakuliah');
        $biayaResponse = getBiayaBahanAjar($accessToken, $matakuliahUntukDiproses);
        $_SESSION['json_response'] = json_encode($biayaResponse, JSON_PRETTY_PRINT); // Store the response for debugging
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
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .debug-box {
            border: 1px solid #007bff;
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            overflow-x: auto; /* Allow horizontal scrolling */
        }
        pre {
            white-space: pre-wrap; /* Wrap long lines */
            word-wrap: break-word; /* Break long words */
        }
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
                            <form method="POST" style="display:inline;">
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
                            <form method="POST" style="display:inline;">
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
    </table>

    <?php if (!empty($_SESSION['pesanan'])): ?>
    <button id="showModalBtn">Lihat Detail Pesanan</button>
    <form method="POST">
        <input type="hidden" name="action" value="proses_biaya">
        <button type="submit">Proses Biaya</button>
    </form>
    <?php endif; ?>

    <?php if (isset($_SESSION['json_response'])): ?>
        <h2>Hasil Query Biaya Bahan Ajar (JSON)</h2>
        <pre><?php echo htmlspecialchars($_SESSION['json_response']); ?></pre>
        <?php unset($_SESSION['json_response']); // Clear the response after displaying ?>
    <?php endif; ?>

    <!-- Menampilkan semua hasil debugging -->
    <?php if (isset($_SESSION['debug'])): ?>
        <div class="debug-box">
            <h2>Debugging Information</h2>
            <pre><?php echo htmlspecialchars(json_encode($_SESSION['debug'], JSON_PRETTY_PRINT)); ?></pre>
        </div>
        <?php unset($_SESSION['debug']); // Clear debugging info after displaying ?>
    <?php endif; ?>

    <!-- Modal untuk menampilkan detail pesanan -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Detail Pesanan</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Harga Bahan Satuan</th>
                        <th>Total Ongkir</th>
                        <th>Total Harga</th>
                        <th>Total Berat</th>
                        <th>Nama Bahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($_SESSION['pesanan']) && !empty($_SESSION['pesanan'])): 
                        foreach ($_SESSION['pesanan'] as $pesanan): 
                            // Ambil data biaya untuk setiap mata kuliah
                            $biayaResponse = getBiayaBahanAjar($accessToken, [$pesanan['id_matakuliah']]);
                            $biayaData = $biayaResponse['data']['getBiayaBahanAjar'][0] ?? null;

                            if ($biayaData) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pesanan['id_matakuliah']); ?></td>
                                <td><?php echo htmlspecialchars($pesanan['nama_matakuliah']); ?></td>
                                <td><?php echo htmlspecialchars($biayaData['hargaBaSatuan'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($biayaData['totalOngkir'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($biayaData['totalHargaBa'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($biayaData['totalBeratBa'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($biayaData['namaBa'] ?? ''); ?></td>
                            </tr>
                            <?php 
                            }
                        endforeach; 
                    else: ?>
                        <tr>
                            <td colspan="7">Tidak ada detail pesanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Modal functionality
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("showModalBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
