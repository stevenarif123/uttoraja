<?php
// Path ke file JSON
$json_file = 'status_pengambilan.json';

// Cek apakah file JSON ada, jika tidak buat file baru
if (!file_exists($json_file)) {
    file_put_contents($json_file, '{}');
}

// Baca data status pengambilan dari file JSON
$status_pengambilan = json_decode(file_get_contents($json_file), true);

// Koneksi ke database
require_once "../koneksi.php";

// Get selected masa from POST or default to empty
$selected_masa = isset($_POST['masa']) ? $_POST['masa'] : '';

// Modified query to include masa and filter if selected
$query = "
    SELECT catatan.nama_lengkap, catatan.almamater, catatan.status_admisi, 
           catatan.sisa, mahasiswa.UkuranBaju, mahasiswa.Masa
    FROM catatan_bayarmaba20242 AS catatan
    JOIN mahasiswa AS mahasiswa
    ON catatan.nama_lengkap = mahasiswa.NamaLengkap
    WHERE catatan.almamater = 200000 
    AND catatan.status_admisi = 'lunas' 
    AND catatan.sisa >= 0
    " . ($selected_masa ? "AND mahasiswa.Masa = '$selected_masa'" : "") . "
";

$result = $koneksi->query($query);

// Cek apakah query berhasil dieksekusi
if (!$result) {
    die("Query error: " . $koneksi->error);
}

// Buat array untuk menghitung ukuran baju
$size_counts = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0, 'XXL' => 0];

// Inisialisasi counter untuk baju yang belum diambil
$belum_diambil = 0;

// Get unique masa values for dropdown
$masa_query = "SELECT DISTINCT Masa FROM mahasiswa ORDER BY Masa";
$masa_result = $koneksi->query($masa_query);
$masa_options = [];
while ($row = $masa_result->fetch_assoc()) {
    $masa_options[] = $row['Masa'];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pengambilan Baju Almamater</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add required Bootstrap dependencies in correct order -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .container {
                width: 100%;
                max-width: none;
                padding: 0;
                margin: 0;
            }
            /* Remove table borders in print */
            .table {
                width: 100%;
                margin-bottom: 1rem;
                border-collapse: collapse !important;
            }
            .table td,
            .table th {
                background-color: #fff !important;
                border: 1px solid #dee2e6 !important;
                padding: 0.5rem !important;
            }
            /* Ensure summary prints at bottom */
            .print-summary {
                margin-top: 2rem;
                border-top: 2px solid #000;
                padding-top: 1rem;
            }
            body {
                padding: 2rem;
            }
        }
        .print-only {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="my-4 no-print">Daftar Mahasiswa Pemesan Baju Almamater</h2>
    
    <!-- Print and Masa Filter Controls -->
    <div class="row mb-4">
        <div class="col-md-6 no-print">
            <form method="POST" class="mb-4">
                <div class="form-group">
                    <label for="masa">Filter by Masa:</label>
                    <select name="masa" id="masa" class="form-control w-50" onchange="this.form.submit()">
                        <option value="">Semua Masa</option>
                        <?php foreach ($masa_options as $masa): ?>
                            <option value="<?php echo htmlspecialchars($masa); ?>" 
                                    <?php echo $selected_masa === $masa ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($masa); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-right no-print">
            <button onclick="window.print()" class="btn btn-success">
                🖨️ Print Daftar
            </button>
        </div>
    </div>

    <!-- Print Header -->
    <div class="print-only text-center mb-4">
        <h3>Daftar Pengambilan Baju Almamater</h3>
        <h4>Masa: <?php echo $selected_masa ? $selected_masa : 'Semua Masa'; ?></h4>
        <hr>
    </div>

    <!-- Print-only table -->
    <div class="print-only">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Ukuran Baju</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset result pointer
                $result->data_seek(0);
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . htmlspecialchars(stripslashes($row['nama_lengkap'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['UkuranBaju']) . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Regular editable table (hidden when printing) -->
    <form method="POST" action="simpan_status.php" class="no-print">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Ukuran Baju</th>
                    <th class="no-print">Aksi</th>
                    <th class="no-print">Sudah Diambil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Reset result pointer again
                $result->data_seek(0);
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        $nama_lengkap = stripslashes($row['nama_lengkap']);
                        $ukuran_baju = $row['UkuranBaju'];
                        $size_counts[$ukuran_baju]++;
                        
                        $sudah_diambil = isset($status_pengambilan[$nama_lengkap]) 
                            ? $status_pengambilan[$nama_lengkap] 
                            : false;
                        
                        if (!$sudah_diambil) {
                            $belum_diambil++;
                        }

                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . htmlspecialchars($nama_lengkap) . "</td>";
                        echo "<td id='ukuran-" . $no . "'>" . htmlspecialchars($ukuran_baju) . "</td>";
                        echo "<td class='no-print'><button type='button' class='btn btn-warning btn-sm' onclick='editUkuran(\"" . htmlspecialchars($nama_lengkap, ENT_QUOTES) . "\", \"" . htmlspecialchars($ukuran_baju, ENT_QUOTES) . "\", " . $no . ")'>Edit</button></td>";
                        echo "<td class='no-print'><input type='checkbox' name='status_pengambilan[" . htmlspecialchars($nama_lengkap, ENT_QUOTES) . "]' " . ($sudah_diambil ? "checked" : "") . "></td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data yang sesuai.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Simpan Status</button>
    </form>

    <!-- Print summary -->
    <div class="print-summary">
        <h4>Ringkasan Ukuran Baju</h4>
        <ul class="list-unstyled">
            <?php foreach ($size_counts as $size => $count): ?>
                <li>Ukuran <?php echo $size; ?>: <?php echo $count; ?></li>
            <?php endforeach; ?>
        </ul>
        <p>Baju yang belum diambil: <?php echo $belum_diambil; ?></p>
    </div>
</div>

<!-- Modal untuk edit ukuran baju -->
<div class="modal fade no-print" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Ukuran Baju</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body modal -->
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="studentId">
                    <div class="form-group">
                        <label for="namaLengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" id="namaLengkap" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ukuranBaju">Ukuran Baju</label>
                        <select class="form-control" id="ukuranBaju">
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>
                    <div id="modalMessage" class="alert" style="display: none;"></div>
                    <button type="button" class="btn btn-primary" onclick="simpanPerubahan()">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editUkuran(nama, ukuran, id) {
    $('#namaLengkap').val(nama);
    $('#ukuranBaju').val(ukuran);
    $('#studentId').val(id);
    $('#editModal').modal('show');
}

function simpanPerubahan() {
    var ukuranBaru = document.getElementById('ukuranBaju').value;
    var id = document.getElementById('studentId').value;
    var namaLengkap = document.getElementById('namaLengkap').value;
    var element = document.getElementById('ukuran-' + id);
    if (element) {
        element.innerHTML = ukuranBaru;
        // Kirim data ke server melalui Ajax
        $.ajax({
            url: 'update_ukuran.php',
            type: 'POST',
            data: {
                nama_lengkap: namaLengkap,
                ukuran_baru: ukuranBaru
            },
            success: function(response) {
                $('#modalMessage').removeClass().addClass('alert alert-success').text('Berhasil mengubah ukuran!').show();
                setTimeout(function() {
                    $('#editModal').modal('hide');
                    location.reload();
                }, 1500);
            },
            error: function(xhr, status, error) {
                $('#modalMessage').removeClass().addClass('alert alert-danger').text('Gagal mengubah: ' + error).show();
            }
        });
    } else {
        console.log('Element dengan ID ukuran-' + id + ' tidak ditemukan.');
    }
}
</script>
</body>
</html>

<?php
$koneksi->close();
?>
