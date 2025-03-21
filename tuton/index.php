<?php
require_once "../../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <!-- Updated Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Updated Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root {
            --bs-primary: #0d6efd;
            --bs-secondary: #6c757d;
        }
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            border-radius: 15px;
        }
        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }
        .table thead th {
            border-top: none;
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        .btn-action {
            padding: 0.5rem;
            border-radius: 8px;
            margin: 0 0.2rem;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .copy-btn {
            background: none;
            border: none;
            color: var(--bs-primary);
            padding: 0.2rem 0.5rem;
            transition: all 0.2s;
        }
        .copy-btn:hover {
            color: var(--bs-primary);
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 4px;
        }
        .search-box {
            max-width: 300px;
            position: relative;
        }
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-box input {
            padding-left: 2.5rem;
            border-radius: 20px;
        }
        .badge {
            font-size: 0.85rem;
            padding: 0.5rem 0.8rem;
        }
        .table td {
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .action-cell {
            text-align: right;
            min-width: 120px;
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
        .btn-group-action {
            display: flex;
            gap: 0.3rem;
            justify-content: flex-end;
        }
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
        /* New styles for masa filter */
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
        /* Toast styles for clipboard */
        .copy-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
            animation: fadeInOut 2s ease;
        }
        
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-20px); }
            15% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
        
        /* Password strength styles */
        .progress {
            height: 5px;
            margin-top: 5px;
        }
        .password-strength-meter {
            text-align: left;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        .password-strength-meter i {
            margin-right: 5px;
        }
        .very-weak { color: #dc3545; }
        .weak { color: #ffc107; }
        .medium { color: #fd7e14; }
        .strong { color: #20c997; }
        .very-strong { color: #198754; }
    </style>
</head>
<body class="bg-light">
<?php
// Add WhatsApp message generator function
function generateWhatsAppMessage($nim, $password) {
    date_default_timezone_set('Asia/Jakarta');
    $jam = date('H');
    
    // Determine greeting based on time
    if($jam >= 1 && $jam < 10){
        $salam = 'Selamat pagi';
    } elseif($jam >= 10 && $jam < 14){
        $salam = 'Selamat siang';
    } elseif($jam >= 14 && $jam < 18){
        $salam = 'Selamat sore';
    } else {
        $salam = 'Selamat malam';
    }

    // Construct message
    $pesan = "$salam, saya kirimkan detail akun mahasiswa yang akan digunakan untuk Tutorial Online (TUTON).\n";
    $pesan .= "Username : $nim\n";
    $pesan .= "Password : $password\n\n";
    $pesan .= "Silahkan melakukan login di alamat https://elearning.ut.ac.id/login/index.php dengan memasukkan username dan passwordnya. Sekian dan terima kasih.";

    return urlencode($pesan);
}

// Get unique Masa values for the dropdown
$masaOptions = [];
$sqlMasa = "SELECT DISTINCT Masa FROM mahasiswa ORDER BY Masa DESC";
$resultMasa = mysqli_query($koneksi, $sqlMasa);
if ($resultMasa) {
    while ($row = mysqli_fetch_assoc($resultMasa)) {
        $masaOptions[] = $row['Masa'];
    }
}

// Set default or selected masa
$selectedMasa = isset($_GET['masa']) ? $_GET['masa'] : (count($masaOptions) > 0 ? $masaOptions[0] : '20242');
?>
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-white py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-0">Data Mahasiswa</h2>
                <div class="d-flex align-items-center gap-3">
                    <!-- Add Masa filter dropdown -->
                    <div class="filter-container">
                        <label class="filter-label" for="masaSelect">
                            <i class="fas fa-filter"></i> Masa:
                        </label>
                        <form method="GET" action="" class="d-flex align-items-center" id="masaForm">
                            <select name="masa" id="masaSelect" class="form-control masa-select" onchange="this.form.submit()">
                                <?php foreach ($masaOptions as $masaOption): ?>
                                    <option value="<?php echo htmlspecialchars($masaOption, ENT_QUOTES, 'UTF-8'); ?>" 
                                            <?php echo ($masaOption == $selectedMasa) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($masaOption, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                    <div class="form-inline">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Masa</th>
                            <th>Password</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Pagination configuration
                        $limit = 10; // Items per page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $limit;
                        
                        // Get total records with Masa filter
                        $countSql = "SELECT COUNT(*) as total FROM mahasiswa WHERE Masa = ?";
                        $countStmt = mysqli_prepare($koneksi, $countSql);
                        mysqli_stmt_bind_param($countStmt, "s", $selectedMasa);
                        mysqli_stmt_execute($countStmt);
                        $total_records = mysqli_stmt_get_result($countStmt)->fetch_assoc()['total'];
                        $total_pages = ceil($total_records / $limit);
                        
                        // Modified query with LIMIT and Masa filter
                        $sql = "SELECT * FROM mahasiswa WHERE Masa = ? LIMIT $start, $limit";
                        $stmt = mysqli_prepare($koneksi, $sql);
                        mysqli_stmt_bind_param($stmt, "s", $selectedMasa);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        
                        $number = $start + 1;
                        while($row = mysqli_fetch_assoc($result)) {
                            $nim = $row['NIM'];

                            // Cek apakah NIM ada di tabel tuton dan tentukan status
                            $sql_check = "SELECT NIM, Password FROM tuton WHERE NIM = ?";
                            $stmt_check = mysqli_prepare($koneksi, $sql_check);
                            mysqli_stmt_bind_param($stmt_check, "s", $nim);
                            mysqli_stmt_execute($stmt_check);
                            $result_check = mysqli_stmt_get_result($stmt_check);
                            $existing = mysqli_fetch_assoc($result_check);

                            // Determine status based on Password value
                            if($existing) {
                                if(!empty($existing['Password'])) {
                                    $status = 'Sukses';
                                    $statusClass = 'status-success';
                                    $password = $existing['Password'];
                                } else {
                                    $status = 'Gagal';
                                    $statusClass = 'status-failed';
                                    $password = '';
                                }
                            } else {
                                $status = 'Belum';
                                $statusClass = 'status-pending';
                                $password = '';
                            }

                            // Add new status style
                            echo '<style>
                                .status-failed {
                                    background-color: #f8d7da;
                                    color: #721c24;
                                }
                            </style>';

                            echo '<tr>';
                            echo '<td class="text-center">'.$number.'</td>';
                            echo '<td><div class="copy-cell"><span class="copy-text">'.$row['NIM'].'</span><button class="btn btn-sm btn-light copy-btn" data-clipboard-text="'.$row['NIM'].'"><i class="fas fa-copy"></i></button></div></td>';
                            echo '<td><div class="copy-cell"><span class="copy-text">'.stripslashes($row['NamaLengkap']).'</span><button class="btn btn-sm btn-light copy-btn" data-clipboard-text="'.stripslashes($row['NamaLengkap']).'"><i class="fas fa-copy"></i></button></div></td>';
                            echo '<td>'.$row['Jurusan'].'</td>';
                            echo '<td>'.$row['Masa'].'</td>';
                            echo '<td><div class="copy-cell"><span class="copy-text">'.$password.'</span>'.($password ? '<button class="btn btn-sm btn-light copy-btn" data-clipboard-text="'.$password.'"><i class="fas fa-copy"></i></button>' : '').'</div></td>';
                            echo '<td class="text-center"><span class="status-badge '.$statusClass.'">'.$status.'</span></td>';
                            echo '<td class="action-cell">';
                            echo '<div class="btn-group-action">';

                            if($status != 'Sukses') {
                                echo '<button class="btn btn-primary btn-action proses-pendaftaran" 
                                    data-no="'.$row['No'].'" 
                                    data-nim="'.$row['NIM'].'" 
                                    data-nama="'.$row['NamaLengkap'].'" 
                                    data-email="'.$row['Email'].'"
                                    data-birthdate="'.$row['TanggalLahir'].'" 
                                    data-phone="'.$row['NomorHP'].'"
                                    title="'.($status == 'Gagal' ? 'Coba Lagi' : 'Proses').'">
                                    <i class="fas '.($status == 'Gagal' ? 'fa-redo' : 'fa-play').'"></i>
                                    </button>';
                                    
                                echo '<button class="btn btn-success btn-action migrasi-data" 
                                    data-no="'.$row['No'].'" 
                                    title="Migrasi">
                                    <i class="fas fa-sync-alt"></i>
                                    </button>';
                            } else {
                                echo '<button class="btn btn-secondary btn-action" disabled>
                                    <i class="fas fa-check"></i>
                                    </button>';
                                    
                                // WhatsApp button only if status is success and has phone number
                                if(!empty($row['NomorHP'])) {
                                    $nomor_wa = preg_replace('/^0/', '62', $row['NomorHP']);
                                    $pesan_wa = generateWhatsAppMessage($row['NIM'], $password);
                                    echo '<button 
                                        class="btn btn-success btn-action wa-confirm" 
                                        title="WhatsApp"
                                        data-nim="'.$row['NIM'].'"
                                        data-nama="'.htmlspecialchars(stripslashes($row['NamaLengkap']), ENT_QUOTES, 'UTF-8').'"
                                        data-password="'.$password.'"
                                        data-phone="'.$nomor_wa.'">
                                        <i class="fab fa-whatsapp"></i>
                                        </button>';
                                }
                            }
                            echo '</div></td>';
                            echo '</tr>';
                            $number++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="?page=<?php echo $page-1; ?>&masa=<?php echo urlencode($selectedMasa); ?>" tabindex="-1">Previous</a>
                    </li>
                    <?php 
                    for($i = 1; $i <= $total_pages; $i++):
                        $active = $i == $page ? 'active' : '';
                    ?>
                    <li class="page-item <?php echo $active; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&masa=<?php echo urlencode($selectedMasa); ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>&masa=<?php echo urlencode($selectedMasa); ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Toast notification for copy to clipboard -->
<div class="copy-toast" id="copyToast">
    <i class="fas fa-check-circle me-2"></i> Teks berhasil disalin! ✅
</div>

<!-- Modal Preview Data -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Data Pendaftaran 📋</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Periksa dan edit data jika diperlukan sebelum mengirim ke server.
        </div>
        <form id="previewForm">
          <input type="hidden" name="no" id="previewNo">
          <div class="form-group mb-3">
            <label>NIM</label>
            <div class="input-group">
              <input type="text" class="form-control" id="previewNIM" name="nim" readonly>
              <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
          </div>
          <div class="form-group mb-3">
            <label>Email</label>
            <div class="input-group">
              <input type="email" class="form-control" id="previewEmail" name="email">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
          </div>
          <div class="form-group mb-3">
            <label>Tanggal Lahir</label>
            <div class="input-group">
              <input type="date" class="form-control" id="previewBirthDate" name="birthdate">
              <span class="input-group-text" id="birthDateVerification"></span>
            </div>
          </div>
          <div class="form-group mb-3">
            <label>Nomor HP</label>
            <div class="input-group">
              <input type="text" class="form-control" id="previewPhone" name="phone">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="showProsesModal">Lanjut ke Proses ➡️</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="prosesForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="prosesModalLabel">Konfirmasi Data ✅</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="no" id="modalNo">
          <div class="form-group mb-3">
            <label>NIM</label>
            <input type="text" class="form-control" id="modalNIM" name="nim" readonly>
          </div>
          <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" class="form-control" id="modalEmail" name="email" readonly>
          </div>
          <div class="form-group mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" id="modalBirthDate" name="birthdate" readonly>
          </div>
          <div class="form-group mb-3">
            <label>Nomor HP</label>
            <input type="text" class="form-control" id="modalPhone" name="phone" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <button type="button" class="btn btn-primary submit-proses">Kirim Data 🚀</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- WhatsApp Confirmation Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="whatsappModalLabel">
            <i class="fab fa-whatsapp me-2"></i> Konfirmasi Pesan WhatsApp
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="fas fa-info-circle me-2"></i> Periksa data sebelum mengirim pesan WhatsApp.
        </div>
        <form id="whatsappForm">
          <div class="mb-3">
            <label class="form-label"><strong>NIM</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-id-card"></i></span>
              <input type="text" class="form-control" id="waNIM" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Nama</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="waNama" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Nomor WhatsApp</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
              <input type="text" class="form-control" id="waPhone">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Password</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-key"></i></span>
              <input type="text" class="form-control" id="waPassword">
            </div>
          </div>
          <div class="mb-3 form-text text-info">
            <i class="fas fa-info-circle"></i> Password akan disimpan saat Anda mengirim WhatsApp.
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Preview Pesan</strong></label>
            <div class="border p-3 rounded bg-light">
              <p id="waPreviewMessage" style="white-space: pre-line;"></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="button" class="btn btn-primary me-2" id="savePasswordOnlyBtn">
            <i class="fas fa-save me-1"></i> Simpan Password Saja
        </button>
        <button type="button" class="btn btn-success" id="saveAndSendWAButton">
            <i class="fab fa-whatsapp me-1"></i> Simpan & Kirim WhatsApp
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Password Change Modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="passwordChangeModalLabel">
            <i class="fas fa-key me-2"></i> Ganti Password
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="passwordChangeForm">
          <input type="hidden" name="no" id="pwNo">
          <input type="hidden" name="nim" id="pwNIM">
          <input type="hidden" name="masa" id="pwMasa">
          <div class="mb-3">
            <label class="form-label"><strong>Nama Mahasiswa</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="pwNama" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Password Lama</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-lock"></i></span>
              <input type="text" class="form-control" id="pwOldPassword" name="old_password">
              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="pwOldPassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div id="oldPasswordHelp" class="form-text text-muted"></div>
          </div>
          <div class="mb-3">
            <label class="form-label"><strong>Password Baru</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-key"></i></span>
              <input type="text" class="form-control" id="pwNewPassword" name="new_password">
              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="pwNewPassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div class="progress">
              <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
            <div id="passwordStrengthText" class="password-strength-meter"></div>
          </div>
          
          <div class="mb-3">
            <label class="form-label"><strong>Konfirmasi Password Baru</strong></label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
              <input type="text" class="form-control" id="pwConfirmPassword" name="confirm_password">
              <button class="btn btn-outline-secondary toggle-password" type="button" data-target="pwConfirmPassword">
                <i class="fas fa-eye"></i>
              </button>
            </div>
            <div id="confirmPasswordHelp" class="form-text"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="button" class="btn btn-primary" id="savePasswordButton">
            <i class="fas fa-save me-1"></i> Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Replace the hidden iframe with a dynamic popup mechanism -->
<div id="waClickHandler" style="position: fixed; bottom: -999px; left: -999px; width: 1px; height: 1px;">
  <a id="waLink" href="#"></a>
</div>

<!-- Replace the WhatsApp handler with a more efficient solution -->
<div class="position-fixed" style="bottom: -100vh; opacity: 0;">
  <iframe id="waIframe" style="width: 1px; height: 1px; opacity: 0;"></iframe>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

<script>
    // Inisialisasi ClipboardJS dengan toast notification
    var clipboard = new ClipboardJS('.copy-btn');
    
    clipboard.on('success', function(e) {
        // Show toast notification with animation
        const toast = document.getElementById('copyToast');
        toast.style.display = 'block';
        
        // The animation will automatically hide the toast after 2 seconds
        // due to the CSS animation we defined
        setTimeout(function() {
            toast.style.display = 'none';
        }, 2000);
        
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menyalin data.',
        });
    });

    // WhatsApp confirmation modal handlers
    $(document).on('click', '.wa-confirm', function(){
        const nim = $(this).data('nim');
        const nama = $(this).data('nama');
        const password = $(this).data('password');
        const phone = $(this).data('phone');
        
        // Fill the WhatsApp modal with data (removed readonly attributes)
        $('#waNIM').val(nim);
        $('#waNama').val(nama);
        $('#waPassword').val(password);
        $('#waPhone').val(phone);
        
        // Generate and display preview message
        updateWhatsAppPreview();
        
        // Show the modal
        $('#whatsappModal').modal('show');
    });
    
    // Add event listeners to update the preview message when inputs change
    $('#waPassword, #waPhone').on('input', function() {
        updateWhatsAppPreview();
    });
    
    // Function to update WhatsApp preview message
    function updateWhatsAppPreview() {
        const nim = $('#waNIM').val();
        const password = $('#waPassword').val();
        const waMessage = generateWhatsAppPreviewMessage(nim, password);
        $('#waPreviewMessage').text(waMessage);
        
        // Update the href for the WhatsApp button
        const phone = $('#waPhone').val();
        $('#sendWAButton').attr('href', 'https://wa.me/' + phone + '?text=' + encodeURIComponent(waMessage));
    }
    
    // Function to generate WhatsApp preview message (mirroring the PHP function)
    function generateWhatsAppPreviewMessage(nim, password) {
        // Get current hour for greeting
        const hour = new Date().getHours();
        let greeting = '';
        
        if(hour >= 1 && hour < 10) {
            greeting = 'Selamat pagi';
        } else if(hour >= 10 && hour < 14) {
            greeting = 'Selamat siang';
        } else if(hour >= 14 && hour < 18) {
            greeting = 'Selamat sore';
        } else {
            greeting = 'Selamat malam';
        }
        
        // Construct message
        let pesan = greeting + ", saya kirimkan detail akun mahasiswa yang akan digunakan untuk Tutorial Online (TUTON).\n";
        pesan += "Username : " + nim + "\n";
        pesan += "Password : " + password + "\n\n";
        pesan += "Silahkan melakukan login di alamat https://elearning.ut.ac.id/login/index.php dengan memasukkan username dan passwordnya. Sekian dan terima kasih.";
        
        return pesan;
    }

    // Replace existing proses-pendaftaran click handler with this:
    $(document).on('click', '.proses-pendaftaran', function(){
        // Get data from button attributes
        var no = $(this).data('no');
        var nim = $(this).data('nim');
        var birthdate = $(this).data('birthdate');
        var phone = $(this).data('phone');
        var email = $(this).data('email');
        
        // Fill preview modal directly with data
        $('#previewNo').val(no);
        $('#previewNIM').val(nim);
        $('#previewBirthDate').val(birthdate);
        $('#previewPhone').val(phone);
        $('#previewEmail').val(email);
        
        // Add data verification badge for birthdate
        $('#birthDateVerification').html(validateBirthDate(birthdate) ? 
            '<span class="badge bg-success">Valid ✓</span>' : 
            '<span class="badge bg-danger">Invalid ✗</span>');
        
        // Show preview modal
        $('#previewModal').modal('show');
    });

    // Add new handler for showing process modal
    $('#showProsesModal').click(function() {
        // Transfer values to process modal
        $('#modalNo').val($('#previewNo').val());
        $('#modalNIM').val($('#previewNIM').val());
        $('#modalBirthDate').val($('#previewBirthDate').val());
        $('#modalPhone').val($('#previewPhone').val());
        $('#modalEmail').val($('#previewEmail').val());

        // Hide preview modal and show process modal
        $('#previewModal').modal('hide');
        $('#prosesModal').modal('show');
    });

    // Enhanced error handling for proses button
    $(document).on('click', '.submit-proses', function(){
        var formData = new FormData($('#prosesForm')[0]);

        // Log form data for debugging
        console.log('Form data:', {
            nim: formData.get('nim'),
            birthdate: formData.get('birthdate'),
            phone: formData.get('phone'),
            email: formData.get('email')
        });

        // Additional validation
        if(!formData.get('nim') || !formData.get('birthdate')) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                text: 'NIM dan Tanggal Lahir harus diisi!',
            });
            return;
        }

        $.ajax({
            url: 'proses_pendaftaran.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function(xhr){
                $('#prosesModal').modal('hide');
                Swal.fire({
                    title: 'Memproses Pendaftaran',
                    text: 'Mohon tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function(response){
                console.log('Server Response:', response);
                Swal.close();
                
                if(response.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.message
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Terjadi kesalahan pada server',
                    });
                }
            },
            error: function(xhr, status, error){
                console.error('AJAX Error:', {xhr, status, error});
                console.log('Response Text:', xhr.responseText);
                
                Swal.close();
                
                let errorMessage = 'Terjadi kesalahan saat memproses data';
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMessage = response.message || errorMessage;
                } catch(e) {
                    console.warn('Failed to parse error response:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            }
        });
    });

    // Event handler untuk tombol Migrasi
    $(document).on('click', '.migrasi-data', function(){
        var no = $(this).data('no');

        $.ajax({
            url: 'migrasi_data.php',
            method: 'POST',
            data: { no: no },
            dataType: 'json',
            beforeSend: function(){
                Swal.fire({
                    title: 'Migrasi Data',
                    text: 'Mohon tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function(response){
                Swal.close();
                if(response.status == 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message,
                    });
                }
            },
            error: function(xhr, status, error){
                Swal.close();
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses data.',
                });
            }
        });
    });
    
    // Add context menu for rows to show additional options
    $(document).on('contextmenu', '.table tbody tr', function(e) {
        e.preventDefault();
        
        const $row = $(this);
        const nim = $row.find('td:eq(1)').text().trim();
        const nama = $row.find('td:eq(2)').text().trim();
        const masa = $row.find('td:eq(4)').text().trim();
        const password = $row.find('td:eq(5) .copy-text').text().trim();
        const no = $row.find('.proses-pendaftaran').data('no') || '';
        
        // Show custom context menu with SweetAlert2
        Swal.fire({
            title: 'Aksi Tambahan 🛠️',
            html: `<div class="text-start">Mahasiswa: <strong>${nama}</strong> (${nim})</div>`,
            icon: 'info',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: '<i class="fas fa-key"></i> Ganti Password',
            denyButtonText: '<i class="fas fa-copy"></i> Salin Semua Data',
            cancelButtonText: '<i class="fas fa-times"></i> Tutup'
        }).then((result) => {
            if (result.isConfirmed) {
                // Open password change modal
                showPasswordChangeModal(no, nim, nama, password, masa);
            } else if (result.isDenied) {
                // Copy all data to clipboard
                const allData = `NIM: ${nim}\nNama: ${nama}\nMasa: ${masa}\nPassword: ${password}`;
                
                // Use clipboard API
                navigator.clipboard.writeText(allData).then(() => {
                    // Show success toast
                    const toast = document.getElementById('copyToast');
                    toast.innerText = "✅ Semua data berhasil disalin!";
                    toast.style.display = 'block';
                    
                    setTimeout(function() {
                        toast.style.display = 'none';
                        toast.innerText = "<i class=\"fas fa-check-circle me-2\"></i> Teks berhasil disalin! ✅";
                    }, 2000);
                });
            }
        });
    });
    
    // Function to show password change modal - fixed the modal so it's not readonly
    function showPasswordChangeModal(no, nim, nama, oldPassword, masa) {
        // Set values in the form
        $('#pwNo').val(no);
        $('#pwNIM').val(nim);
        $('#pwNama').val(nama);
        $('#pwOldPassword').val(oldPassword);
        $('#pwMasa').val(masa);
        
        // Clear new password fields
        $('#pwNewPassword').val('');
        $('#pwConfirmPassword').val('');
        
        // Reset strength meter
        $('#passwordStrength').css('width', '0%').attr('class', 'progress-bar');
        $('#passwordStrengthText').html('').attr('class', 'password-strength-meter');
        
        // Set fields to text type
        $('#pwOldPassword, #pwNewPassword, #pwConfirmPassword').attr('type', 'text');
        $('.toggle-password i').removeClass('fa-eye-slash').addClass('fa-eye');
        
        // Set message based on current password
        if (oldPassword) {
            $('#oldPasswordHelp').html('<small class="text-info"><i class="fas fa-info-circle"></i> Password saat ini ditampilkan. Anda dapat mengubahnya jika perlu.</small>');
        } else {
            $('#oldPasswordHelp').html('<small class="text-warning"><i class="fas fa-exclamation-circle"></i> Password lama tidak ada, masukkan password baru.</small>');
        }
        
        // Show modal
        $('#passwordChangeModal').modal('show');
    }
    
    // Toggle password visibility
    $(document).on('click', '.toggle-password', function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Password strength checker
    $('#pwNewPassword').on('input', function() {
        const password = $(this).val();
        checkPasswordStrength(password);
        
        // Check if passwords match when typing
        validateConfirmPassword();
    });
    
    // Confirm password validation
    $('#pwConfirmPassword').on('input', validateConfirmPassword);
    
    function validateConfirmPassword() {
        const newPassword = $('#pwNewPassword').val();
        const confirmPassword = $('#pwConfirmPassword').val();
        
        if (!confirmPassword) {
            $('#confirmPasswordHelp').html('').removeClass();
            return;
        }
        
        if (newPassword === confirmPassword) {
            $('#confirmPasswordHelp').html('<i class="fas fa-check-circle"></i> Password cocok').addClass('text-success');
        } else {
            $('#confirmPasswordHelp').html('<i class="fas fa-times-circle"></i> Password tidak cocok').addClass('text-danger');
        }
    }
    
    // Function to check password strength
    function checkPasswordStrength(password) {
        // Initialize variables
        let strength = 0;
        let tips = [];
        
        // If password is empty, set default state and return
        if (password.length === 0) {
            $('#passwordStrength').css('width', '0%').attr('class', 'progress-bar');
            $('#passwordStrengthText').html('').attr('class', 'password-strength-meter');
            return;
        }
        
        // Check password length
        if (password.length < 6) {
            tips.push("lebih panjang");
        } else if (password.length >= 10) {
            strength += 25;
        } else {
            strength += 10;
        }
        
        // Check for mixed case
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
            strength += 20;
        } else {
            tips.push("kombinasi huruf besar dan kecil");
        }
        
        // Check for numbers
        if (password.match(/\d/)) {
            strength += 20;
        } else {
            tips.push("tambahkan angka");
        }
        
        // Check for special characters
        if (password.match(/[^a-zA-Z\d]/)) {
            strength += 20;
        } else {
            tips.push("tambahkan karakter khusus");
        }
        
        // Check for repeated characters
        if (password.match(/(.)\1\1/)) {
            strength -= 10;
            tips.push("hindari pengulangan karakter");
        }
        
        // Set the strength meter value and class
        $('#passwordStrength').css('width', strength + '%');
        
        // Set appropriate text and color based on strength
        let strengthText, strengthClass;
        
        if (strength < 30) {
            strengthText = '<i class="fas fa-exclamation-circle"></i> Sangat lemah';
            strengthClass = 'very-weak';
            $('#passwordStrength').attr('class', 'progress-bar bg-danger');
        } else if (strength < 50) {
            strengthText = '<i class="fas fa-exclamation-triangle"></i> Lemah';
            strengthClass = 'weak';
            $('#passwordStrength').attr('class', 'progress-bar bg-warning');
        } else if (strength < 70) {
            strengthText = '<i class="fas fa-info-circle"></i> Sedang';
            strengthClass = 'medium';
            $('#passwordStrength').attr('class', 'progress-bar bg-info');
        } else if (strength < 85) {
            strengthText = '<i class="fas fa-check-circle"></i> Kuat';
            strengthClass = 'strong';
            $('#passwordStrength').attr('class', 'progress-bar bg-success');
        } else {
            strengthText = '<i class="fas fa-shield-alt"></i> Sangat kuat';
            strengthClass = 'very-strong';
            $('#passwordStrength').attr('class', 'progress-bar bg-success');
        }
        
        // Add tips if strength is not high enough
        if (strength < 70 && tips.length > 0) {
            strengthText += ' (Tips: ' + tips.join(", ") + ')';
        }
        
        $('#passwordStrengthText').html(strengthText).attr('class', 'password-strength-meter ' + strengthClass);
    }
    
    // Save password button handler
    $('#savePasswordButton').on('click', function() {
        // Get form values
        const nim = $('#pwNIM').val();
        const masa = $('#pwMasa').val();
        const oldPassword = $('#pwOldPassword').val();
        const newPassword = $('#pwNewPassword').val();
        const confirmPassword = $('#pwConfirmPassword').val();
        
        // Validate inputs
        if (!nim || !newPassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap ⚠️',
                text: 'NIM dan password baru harus diisi!',
            });
            return;
        }
        
        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok ❌',
                text: 'Password baru dan konfirmasi password harus sama!',
            });
            return;
        }
        
        // Show loading indicator
        Swal.fire({
            title: 'Memproses... ⏳',
            text: 'Sedang mengubah password...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Log the data being sent to help with debugging
        console.log('Sending password change request:', {
            nim: nim,
            masa: masa,
            old_password: oldPassword,
            new_password: newPassword
        });
        
        // Send AJAX request to change password
        $.ajax({
            url: 'update_password.php',
            method: 'POST',
            data: {
                nim: nim,
                masa: masa,
                old_password: oldPassword,
                new_password: newPassword
            },
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                Swal.close();
                
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Berhasil Diubah! 🎉',
                        html: response.message
                    }).then(() => {
                        // Close modal
                        $('#passwordChangeModal').modal('hide');
                        
                        // Refresh page to show updated data
                        location.reload();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Mengubah Password ❌',
                        html: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                Swal.close();
                
                let errorMessage = 'Terjadi kesalahan saat mengubah password.';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error ⚠️',
                    html: errorMessage
                });
            }
        });
    });
    
    // Add search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Birthdate validation function
    function validateBirthDate(date) {
        var re = /^\d{4}-\d{2}-\d{2}$/;
        return re.test(date);
    }
    
    // Add the "Save and Send WhatsApp" functionality
    $('#saveAndSendWAButton').on('click', function() {
        const nim = $('#waNIM').val();
        const password = $('#waPassword').val();
        const phone = $('#waPhone').val();
        
        // Validate input
        if (!nim || !password) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap ⚠️',
                text: 'NIM dan password harus diisi!',
            });
            return;
        }
        
        // Show loading indicator
        Swal.fire({
            title: 'Menyimpan Password... ⏳',
            text: 'Sedang memperbarui password...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Send AJAX request to update password
        $.ajax({
            url: 'update_password.php',
            method: 'POST',
            data: {
                nim: nim,
                new_password: password
            },
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                Swal.close();
                
                if (response.success) {
                    // Close the modal first
                    $('#whatsappModal').modal('hide');
                    
                    // Prepare WhatsApp message
                    const waMessage = generateWhatsAppPreviewMessage(nim, password);
                    
                    // Open WhatsApp in new tab
                    const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(waMessage);
                    window.open(waUrl, '_blank');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Disimpan & WhatsApp Dibuka! 🎉',
                        text: 'WhatsApp telah dibuka di tab baru',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        // Refresh page to show updated data
                        location.reload();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Password ❌',
                        html: response.message,
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                Swal.close();
                
                let errorMessage = 'Terjadi kesalahan saat menyimpan password.';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error ⚠️',
                    html: errorMessage,
                    confirmButtonText: 'Tutup'
                });
            }
        });
    });
    
    // Function to open WhatsApp in background using iframe
    function openWhatsAppInBackground(phone, message) {
        // Create the WhatsApp URL
        const waUrl = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
        
        // Open WhatsApp in new tab
        window.open(waUrl, '_blank');
    }
    
    // Success notification
    function showWhatsAppSuccessNotification() {
        Swal.fire({
            icon: 'success',
            title: 'WhatsApp Dibuka! 🎉',
            text: 'WhatsApp berhasil dibuka di tab baru',
            timer: 3000,
            showConfirmButton: false
        });
    }
    
    // Add "Save Password Only" functionality 💾
    $('#savePasswordOnlyBtn').on('click', function() {
        const nim = $('#waNIM').val();
        const password = $('#waPassword').val();
        
        // Validate input
        if (!nim || !password) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap ⚠️',
                text: 'NIM dan password harus diisi!',
            });
            return;
        }
        
        // Show loading indicator
        Swal.fire({
            title: 'Menyimpan Password... ⏳',
            text: 'Sedang memperbarui password...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Send AJAX request to update password
        $.ajax({
            url: 'update_password.php',
            method: 'POST',
            data: {
                nim: nim,
                new_password: password
            },
            dataType: 'json',
            success: function(response) {
                console.log('Server response:', response);
                Swal.close();
                
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Berhasil Disimpan! 🎉',
                        html: response.message
                    }).then(() => {
                        // Close the modal
                        $('#whatsappModal').modal('hide');
                        
                        // Refresh the page to show updated data
                        location.reload();
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Password ❌',
                        html: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                Swal.close();
                
                let errorMessage = 'Terjadi kesalahan saat menyimpan password.';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error ⚠️',
                    html: errorMessage
                });
            }
        });
    });
    
    // Also update the direct WhatsApp button to open in new tab
    $(document).on('click', '.wa-direct', function(e) {
        // Let the default behavior happen (open in new tab)
        return true;
    });
    
    // Remove unnecessary functions
    // Function testWhatsAppOpening and related keyboard shortcut removed
    
    // Add keyboard shortcut for password change (Ctrl+P) ⌨️
    $(document).on('keydown', function(e) {
        // Check if Ctrl+P is pressed and a row is selected/hovered
        if (e.ctrlKey && e.which === 80) {
            e.preventDefault(); // Prevent browser's print dialog
            
            // Get the currently hovered row
            const $hoveredRow = $('.table tbody tr:hover');
            
            if ($hoveredRow.length) {
                const nim = $hoveredRow.find('td:eq(1) .copy-text').text().trim();
                const nama = $hoveredRow.find('td:eq(2) .copy-text').text().trim();
                const masa = $hoveredRow.find('td:eq(4)').text().trim();
                const password = $hoveredRow.find('td:eq(5) .copy-text').text().trim();
                const no = $hoveredRow.find('.proses-pendaftaran').data('no') || '';
                
                showPasswordChangeModal(no, nim, nama, password, masa);
            }
        }
    });
</script>
</body>
</html>