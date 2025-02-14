<?php
// Include koneksi.php
include '../koneksi.php';

// Query untuk mendapatkan data mahasiswa
$query = "SELECT * FROM pendaftar";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Dashboard Calon Mahasiswa</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Data Calon Mahasiswa</h2>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>$no</td>
                            <td>{$row['nama_lengkap']}</td>
                            <td>{$row['nomor_hp']}</td>
                            <td>{$row['jurusan']}</td>
                            <td>
                                <button class='btn btn-info' data-toggle='modal' data-target='#detailModal{$row['id']}'>Detail</button>
                            </td>
                        </tr>";
                    // Modal untuk detail mahasiswa
                    echo "
                        <div class='modal fade' id='detailModal{$row['id']}' tabindex='-1' aria-labelledby='detailModalLabel{$row['id']}' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='detailModalLabel{$row['id']}'>Detail Mahasiswa</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    <div class='modal-body'>
                                        <p><strong>Nama Lengkap:</strong> {$row['nama_lengkap']}</p>
                                        <p><strong>Nomor HP:</strong> {$row['nomor_hp']}</p>
                                        <p><strong>Tempat Lahir:</strong> {$row['tempat_lahir']}</p>
                                        <p><strong>Tanggal Lahir:</strong> {$row['tanggal_lahir']}</p>
                                        <p><strong>Ibu Kandung:</strong> {$row['ibu_kandung']}</p>
                                        <p><strong>NIK:</strong> {$row['nik']}</p>
                                        <p><strong>Jurusan:</strong> {$row['jurusan']}</p>
                                        <p><strong>Agama:</strong> {$row['agama']}</p>
                                        <p><strong>Jenis Kelamin:</strong> {$row['jenis_kelamin']}</p>
                                        <p><strong>Pertanyaan:</strong> {$row['pertanyaan']}</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='5'>Terjadi kesalahan saat mengambil data mahasiswa.</td></tr>";
                error_log("Database error in dashboard.php: " . mysqli_error($conn) . "\n", 3, "error_log");
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
