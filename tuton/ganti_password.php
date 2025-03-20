<?php
require_once '../../koneksi.php'; // Koneksi ke database

// Inisialisasi variabel
$tutonData = array();
$csvData = array();
$message = '';
$selectedMasa = isset($_GET['masa']) ? $_GET['masa'] : '20242'; // Default masa is 20242

// Ambil semua nilai unik dari kolom "Masa" untuk dropdown
$masaOptions = [];
$sqlMasa = "SELECT DISTINCT Masa FROM mahasiswa ORDER BY Masa DESC";
$resultMasa = mysqli_query($koneksi, $sqlMasa);
if ($resultMasa) {
    while ($row = mysqli_fetch_assoc($resultMasa)) {
        $masaOptions[] = $row['Masa'];
    }
}

// Cek apakah form upload di-submit dan file CSV sudah diunggah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvfile'])) {
    $csvFile = $_FILES['csvfile']['tmp_name'];
    
    // Jika request POST memiliki parameter masa, gunakan itu
    if (isset($_POST['masa'])) {
        $selectedMasa = $_POST['masa'];
    }

    // Baca file CSV
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            // Simpan data NIM dan password lama dari CSV ke array
            $csvData[$data[0]] = $data[1]; // Menggunakan NIM sebagai key
        }
        fclose($handle);
    }

    // Ambil data dari tabel mahasiswa berdasarkan Masa yang dipilih
    $sql = "SELECT NamaLengkap as Nama, NIM, Password, Masa FROM mahasiswa WHERE Masa = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $selectedMasa);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nim = $row['NIM'];
            $nama = stripslashes($row['Nama']);
            $password = $row['Password'];
            $masa = $row['Masa'];

            // Cek apakah NIM ada di CSV untuk mendapatkan password lama
            if (isset($csvData[$nim])) {
                $oldPassword = $csvData[$nim];
                $status = 'Password lama ditemukan di CSV';
            } else {
                $oldPassword = 'Tidak ditemukan';
                $status = 'Password lama tidak ditemukan di CSV';
            }

            // Simpan data ke array
            $tutonData[] = array(
                'nim' => $nim,
                'nama' => $nama,
                'password' => $password,
                'old_password' => $oldPassword,
                'status' => $status,
                'masa' => $masa
            );
        }
    } else {
        $message = "Gagal mengambil data dari database.";
    }
} else {
    // Jika tidak ada file yang di-upload, ambil data dari tabel mahasiswa saja berdasarkan Masa
    $sql = "SELECT NamaLengkap as Nama, NIM, Password, Masa FROM mahasiswa WHERE Masa = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $selectedMasa);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nim = $row['NIM'];
            $nama = $row['Nama'];
            $password = $row['Password'];
            $masa = $row['Masa'];

            // Karena tidak ada CSV, password lama tidak ditemukan
            $oldPassword = 'Tidak ditemukan';
            $status = 'Password lama tidak ditemukan di CSV';

            // Simpan data ke array
            $tutonData[] = array(
                'nim' => $nim,
                'nama' => $nama,
                'password' => $password,
                'old_password' => $oldPassword,
                'status' => $status,
                'masa' => $masa
            );
        }
    } else {
        $message = "Gagal mengambil data dari database.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .copy-cell {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }
        .copy-text {
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .copy-btn {
            background: none;
            border: none;
            color: #0d6efd;
            padding: 0.2rem 0.5rem;
            transition: all 0.2s;
        }
        .copy-btn:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 4px;
        }
        /* Add new styles for the masa filter */
        .filter-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .filter-label {
            font-weight: 600;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .filter-label i {
            margin-right: 5px;
        }
        .masa-select {
            min-width: 150px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">🎓 Daftar Mahasiswa</h2>

    <!-- Masa Filter Dropdown -->
    <div class="filter-container">
        <label class="filter-label" for="masaSelect">
            <i class="fas fa-filter"></i> Filter berdasarkan Masa:
        </label>
        <form method="GET" action="" class="d-flex align-items-center">
            <select name="masa" id="masaSelect" class="form-control masa-select" onchange="this.form.submit()">
                <?php foreach ($masaOptions as $masaOption): ?>
                    <option value="<?php echo htmlspecialchars($masaOption, ENT_QUOTES, 'UTF-8'); ?>" 
                            <?php echo ($masaOption == $selectedMasa) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($masaOption, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary ml-2">
                <i class="fas fa-search"></i> Tampilkan
            </button>
        </form>
    </div>

    <!-- Form Upload CSV -->
    <form action="" method="POST" enctype="multipart/form-data" class="mb-4" id="uploadForm">
        <input type="hidden" name="masa" value="<?php echo htmlspecialchars($selectedMasa, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="form-group">
            <label for="csvfile">📁 Pilih File CSV</label>
            <input type="file" name="csvfile" id="csvfile" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-upload"></i> Upload CSV
        </button>
    </form>

    <!-- Tampilkan pesan jika ada -->
    <?php if ($message != ''): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Daftar Mahasiswa -->
    <?php if (!empty($tutonData)): ?>
        <div class="table-responsive">
            <table id="tabelMahasiswa" class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Masa</th>
                        <th>Password di Database</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($tutonData as $data):
                    $nim = $data['nim'];
                    $nama = $data['nama'];
                    $password = $data['password'];
                    $oldPassword = $data['old_password'];
                    $status = $data['status'];
                    $masa = $data['masa'];

                    // Tentukan tampilan password di database
                    $passwordDisplay = ($password && $password != 'Tidak diketahui') ? $password : 'Tidak diketahui';
                    
                    // Determine status badge class
                    $statusClass = 'status-pending';
                    if (strpos($status, 'ditemukan di CSV') !== false) {
                        $statusClass = 'status-success';
                    } else if (strpos($status, 'tidak ditemukan') !== false) {
                        $statusClass = 'status-failed';
                    }
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($masa, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <div class="copy-cell">
                                <span class="copy-text"><?php echo htmlspecialchars($passwordDisplay, ENT_QUOTES, 'UTF-8'); ?></span>
                                <?php if ($passwordDisplay != 'Tidak diketahui'): ?>
                                    <button class="btn btn-sm btn-light copy-btn" data-clipboard-text="<?php echo htmlspecialchars($passwordDisplay, ENT_QUOTES, 'UTF-8'); ?>">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo strpos($status, 'ditemukan') !== false ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-times-circle"></i> '; ?>
                                <?php echo str_replace(['Password lama ', ' di CSV'], '', $status); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm change-password" 
                                    data-nim="<?php echo htmlspecialchars($nim, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-nama="<?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-password="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-oldpassword="<?php echo htmlspecialchars($oldPassword, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-passworddisplay="<?php echo htmlspecialchars($passwordDisplay, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-masa="<?php echo htmlspecialchars($masa, ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fas fa-key"></i> Ganti Password
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Modal untuk Ganti Password -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-key"></i> Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChangePassword">
          <input type="hidden" name="nim" id="modalNIM">
          <input type="hidden" name="masa" id="modalMasa">
          <div class="form-group">
            <label for="modalNama">Nama</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" id="modalNama" readonly>
            </div>
          </div>
          <div class="form-group">
            <label for="modalOldPassword">Password Lama</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
              </div>
              <input type="text" class="form-control" name="old_password" id="modalOldPassword">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="modalOldPassword">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <small id="oldPasswordHelp" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label for="modalNewPassword">Password Baru</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="text" class="form-control" name="new_password" id="modalNewPassword">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="modalNewPassword">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <small id="newPasswordHelp" class="form-text text-muted"></small>
            <div class="progress mt-2" style="height: 5px;">
              <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times"></i> Batal
        </button>
        <button type="button" class="btn btn-primary" id="btnChangePassword">
          <i class="fas fa-save"></i> Ganti Password
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal untuk Menampilkan Pesan -->
<div class="modal fade" id="modalMessage" tabindex="-1" aria-labelledby="modalMessageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header alert" id="modalMessageHeader">
        <h5 class="modal-title" id="modalMessageTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalMessageBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables only once
    if (!$.fn.dataTable.isDataTable('#tabelMahasiswa')) {
        $('#tabelMahasiswa').DataTable({
            "pageLength": 10,
            "language": {
                "search": "🔍 Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "drawCallback": function() {
                // Re-initialize clipboard for all buttons after table redraw
                new ClipboardJS('.copy-btn');
            }
        });
    }

    // Initialize ClipboardJS
    var clipboard = new ClipboardJS('.copy-btn');

    clipboard.on('success', function(e) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '✅ Teks berhasil disalin!',
            showConfirmButton: false,
            timer: 1500
        });
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyalin',
            text: 'Tidak dapat menyalin teks ke clipboard.'
        });
    });

    // Toggle password visibility
    $(document).on('click', '.toggle-password', function() {
        var targetId = $(this).data('target');
        var input = $('#' + targetId);
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Modal Password Change Handler
    $(document).on('click', '.change-password', function() {
        var nim = $(this).data('nim');
        var nama = $(this).data('nama');
        var password = $(this).data('password');
        var oldPassword = $(this).data('oldpassword');
        var passwordDisplay = $(this).data('passworddisplay');
        var masa = $(this).data('masa');

        // Reset and prepare modal
        resetModalFields(nim, nama, password, oldPassword, passwordDisplay, masa);

        // Show modal
        $('#modalChangePassword').modal('show');
    });

    // Helper function to reset modal fields
    function resetModalFields(nim, nama, password, oldPassword, passwordDisplay, masa) {
        $('#modalNIM').val(nim);
        $('#modalNama').val(nama);
        $('#modalMasa').val(masa);

        // Reset form fields - remove readonly attributes to make fields editable
        $('#modalNewPassword').val(password);
        $('#modalNewPassword').attr('type', 'text');
        $('#modalOldPassword').val(oldPassword);
        $('#modalOldPassword').attr('type', 'text');
        
        // Reset password strength indicator
        $('#passwordStrength').css('width', '0%');
        $('#passwordStrength').removeClass('bg-danger bg-warning bg-success');
        
        // Set status messages based on data
        if (oldPassword === 'Tidak ditemukan') {
            $('#oldPasswordHelp').html('<small class="text-warning"><i class="fas fa-exclamation-circle"></i> Password lama tidak ditemukan di CSV, silakan masukkan atau edit.</small>');
        } else {
            $('#oldPasswordHelp').html('<small class="text-success"><i class="fas fa-check-circle"></i> Password lama terdeteksi dari file CSV. Anda dapat mengedit jika perlu.</small>');
        }

        if (passwordDisplay === 'Tidak diketahui') {
            $('#newPasswordHelp').html('<small class="text-info"><i class="fas fa-info-circle"></i> Silakan masukkan password baru.</small>');
        } else {
            $('#newPasswordHelp').html('<small class="text-info"><i class="fas fa-info-circle"></i> Password saat ini ditampilkan. Anda dapat mengedit jika perlu.</small>');
            // Check password strength
            checkPasswordStrength(password);
        }
    }

    // Password strength meter
    $('#modalNewPassword').on('input', function() {
        var password = $(this).val();
        checkPasswordStrength(password);
    });
    
    // Function to check password strength
    function checkPasswordStrength(password) {
        var strength = 0;
        
        if (password.length > 0) strength += 20;
        if (password.length >= 8) strength += 20;
        if (password.match(/[a-z]+/)) strength += 20;
        if (password.match(/[A-Z]+/)) strength += 20;
        if (password.match(/[0-9]+/)) strength += 20;
        
        $('#passwordStrength').css('width', strength + '%');
        
        if (strength < 40) {
            $('#passwordStrength').removeClass().addClass('progress-bar bg-danger');
            $('#newPasswordHelp').html('<small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Password lemah</small>');
        } else if (strength < 80) {
            $('#passwordStrength').removeClass().addClass('progress-bar bg-warning');
            $('#newPasswordHelp').html('<small class="text-warning"><i class="fas fa-info-circle"></i> Password sedang</small>');
        } else {
            $('#passwordStrength').removeClass().addClass('progress-bar bg-success');
            $('#newPasswordHelp').html('<small class="text-success"><i class="fas fa-check-circle"></i> Password kuat</small>');
        }
    }

    // Form submission handler
    $('#btnChangePassword').on('click', function(e) {
        var nim = $('#modalNIM').val();
        var masa = $('#modalMasa').val();
        var oldPassword = $('#modalOldPassword').val();
        var newPassword = $('#modalNewPassword').val();
        
        // Validate inputs
        if (!oldPassword || !newPassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap ⚠️',
                text: 'Password lama dan password baru harus diisi!',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Memproses... ⏳',
            html: 'Sedang memproses perubahan password.<br>Harap tunggu...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Send AJAX request with better error handling
        $.ajax({
            url: 'proses_ganti_password.php',
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: {
                nim: nim,
                masa: masa,
                old_password: oldPassword,
                new_password: newPassword
            },
            success: function(response) {
                Swal.close();
                console.log("Server response:", response); // Debug output
                
                // Check if the response is a valid JSON object
                if (typeof response === 'object') {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil! 🎉',
                            html: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Update table data without page reload
                            var table = $('#tabelMahasiswa').DataTable();
                            var row = table.row($('td:contains("' + nim + '")').closest('tr'));
                            var rowData = row.data();
                            
                            if (rowData) {
                                // Update password cell (5th column, index 4 - adjusted for added Masa column)
                                var passwordCell = '<div class="copy-cell"><span class="copy-text">' + newPassword + '</span>' +
                                    '<button class="btn btn-sm btn-light copy-btn" data-clipboard-text="' + newPassword + '">' +
                                    '<i class="fas fa-copy"></i></button></div>';
                                
                                // Update status cell (6th column, index 5 - adjusted for added Masa column)
                                var statusCell = '<span class="status-badge status-success"><i class="fas fa-check-circle me-1"></i> Terbaru</span>';
                                
                                // Apply changes and redraw
                                rowData[4] = passwordCell;
                                rowData[5] = statusCell;
                                row.data(rowData).draw();
                                
                                // Re-initialize clipboard for new button
                                new ClipboardJS('.copy-btn');
                            }
                            
                            // Close modal
                            $('#modalChangePassword').modal('hide');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal ❌',
                            html: response.message || 'Terjadi kesalahan yang tidak diketahui',
                            confirmButtonText: 'OK'
                        });
                    }
                } else {
                    // Response is not a valid JSON object
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Format Respons ❌',
                        text: 'Server mengembalikan respons yang tidak valid',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.error("AJAX Error:", xhr.responseText);
                
                // Try to parse error response
                let errorMessage = 'Terjadi kesalahan saat menghubungi server.';
                try {
                    const responseObj = JSON.parse(xhr.responseText);
                    if (responseObj && responseObj.message) {
                        errorMessage = responseObj.message;
                    }
                } catch (e) {
                    // If parsing fails, use error status
                    errorMessage += ' Status: ' + status + ' - ' + error;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Server 🔥',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            },
            timeout: 60000 // 60 seconds timeout
        });
    });

    // Check if proses_ganti_password.php exists
    $.ajax({
        url: 'proses_ganti_password.php',
        type: 'HEAD',
        error: function() {
            console.log("proses_ganti_password.php tidak ditemukan. Silakan buat file ini untuk fungsionalitas ganti password.");
            Swal.fire({
                icon: 'warning',
                title: 'File Tidak Ditemukan ⚠️',
                html: 'File <code>proses_ganti_password.php</code> tidak ditemukan.<br>Fitur ganti password tidak akan berfungsi tanpa file ini.',
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>
</body>
</html>
