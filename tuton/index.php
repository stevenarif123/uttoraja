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
?>
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-white py-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Data Mahasiswa</h2>
                <div class="form-inline">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari...">
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
                            <th>Email</th>
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
                        
                        // Get total records
                        $total_records = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM mahasiswa")->fetch_assoc()['total'];
                        $total_pages = ceil($total_records / $limit);
                        
                        // Modified query with LIMIT
                        $sql = "SELECT * FROM mahasiswa LIMIT $start, $limit";
                        $result = mysqli_query($koneksi, $sql);
                        
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
                            echo '<td><div class="copy-cell"><span class="copy-text">'.$row['Email'].'</span><button class="btn btn-sm btn-light copy-btn" data-clipboard-text="'.$row['Email'].'"><i class="fas fa-copy"></i></button></div></td>';
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
                                    echo '<a href="https://wa.me/'.$nomor_wa.'?text='.$pesan_wa.'" 
                                        class="btn btn-success btn-action" 
                                        title="WhatsApp" 
                                        target="_blank">
                                        <i class="fab fa-whatsapp"></i>
                                        </a>';
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
                        <a class="page-link" href="?page=<?php echo $page-1; ?>" tabindex="-1">Previous</a>
                    </li>
                    <?php 
                    for($i = 1; $i <= $total_pages; $i++):
                        $active = $i == $page ? 'active' : '';
                    ?>
                    <li class="page-item <?php echo $active; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                        <a class="page-link" href="?page=<?php echo $page+1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Preview Data -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Data Pendaftaran 📋</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <i class="fas fa-info-circle"></i> Periksa data sebelum mengirim ke server.
        </div>
        <form id="previewForm">
          <input type="hidden" name="no" id="previewNo">
          <div class="form-group">
            <label>NIM</label>
            <input type="text" class="form-control" id="previewNIM" name="nim">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="previewEmail" name="email">
          </div>
          <div class="form-group">
            <label>Tanggal Lahir (YYYY-MM-DD)</label>
            <input type="date" class="form-control" id="previewBirthDate" name="birthdate">
          </div>
          <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control" id="previewPhone" name="phone" placeholder="Contoh: 08123456789">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="no" id="modalNo">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" class="form-control" id="modalNIM" name="nim" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="modalEmail" name="email" readonly>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" id="modalBirthDate" name="birthdate" readonly>
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" class="form-control" id="modalPhone" name="phone" readonly>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="button" class="btn btn-primary submit-proses">Kirim Data 🚀</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Updated script imports -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

<script>
    // Inisialisasi ClipboardJS
    var clipboard = new ClipboardJS('.copy-btn');

    clipboard.on('success', function(e) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil disalin!',
            timer: 1500,
            showConfirmButton: false
        });
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menyalin data.',
        });
    });

    // Replace existing proses-pendaftaran click handler with this:
    $(document).on('click', '.proses-pendaftaran', function(){
        var no = $(this).data('no');
        var nim = $(this).data('nim');
        var nama = $(this).data('nama');
        var email = $(this).data('email');

        // Get additional data from the row
        var row = $(this).closest('tr');
        var birthdate = row.find('.birthdate').text() || '';
        var phone = row.find('.phone').text() || '';

        // Fill preview modal
        $('#previewNo').val(no);
        $('#previewNIM').val(nim);
        $('#previewEmail').val(email);
        $('#previewBirthDate').val(birthdate);
        $('#previewPhone').val(phone);

        // Show preview modal
        $('#previewModal').modal('show');
    });

    // Add new handler for showing process modal
    $('#showProsesModal').click(function() {
        // Transfer edited values to process modal
        $('#modalNo').val($('#previewNo').val());
        $('#modalNIM').val($('#previewNIM').val());
        $('#modalEmail').val($('#previewEmail').val());
        $('#modalBirthDate').val($('#previewBirthDate').val());
        $('#modalPhone').val($('#previewPhone').val());

        // Hide preview modal and show process modal
        $('#previewModal').modal('hide');
        $('#prosesModal').modal('show');
    });

    // Enhanced error handling for proses button
    $(document).on('click', '.submit-proses', function(){
        var formData = $('#prosesForm').serialize();
        
        // Form validation
        if(!$('#modalEmail').val()) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                text: 'Email harus diisi!'
            });
            return;
        }

        $.ajax({
            url: 'proses_pendaftaran.php', // 🔄 Changed to relative path
            method: 'POST',
            data: formData,
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
                // Add custom headers
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response){
                Swal.close();
                console.log('Server Response:', response); // 🔍 Debug log
                
                if(response && response.status === 'success'){
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
                        footer: '<small>Periksa console untuk detail error</small>'
                    });
                }
            },
            error: function(xhr, status, error){
                Swal.close();
                console.log('Raw Response:', xhr.responseText); // 🔍 Debug log
                
                let errorMessage = 'Terjadi kesalahan saat memproses data';
                
                try {
                    // Try to extract JSON from possible HTML response
                    const jsonStart = xhr.responseText.indexOf('{');
                    const jsonEnd = xhr.responseText.lastIndexOf('}') + 1;
                    if(jsonStart >= 0 && jsonEnd > 0) {
                        const jsonStr = xhr.responseText.substring(jsonStart, jsonEnd);
                        const response = JSON.parse(jsonStr);
                        errorMessage = response.message || errorMessage;
                    }
                } catch(e) {
                    console.warn('Response parsing error:', e);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    footer: '<small>Coba lagi dalam beberapa saat</small>'
                });
            },
            complete: function() {
                // Always log the form data for debugging
                console.log('Form Data Sent:', formData);
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

    // Add search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
</body>
</html>
