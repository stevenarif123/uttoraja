<?php
// Start session for login state management
session_start();

// Set strict error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Basic authentication credentials (should be moved to a secure location in production)
$valid_users = array(
    'admin' => 'uttoraja2024',
    'staff' => 'salut2024'
);

// Check if user is logged in
$logged_in = false;
if (isset($_SESSION['user']) && isset($_SESSION['login_time'])) {
    // Session timeout after 2 hours
    if (time() - $_SESSION['login_time'] < 7200) {
        $logged_in = true;
        // Refresh login time on activity
        $_SESSION['login_time'] = time();
    } else {
        // Session expired - force logout
        session_unset();
        session_destroy();
    }
}

// Process login form
$login_error = "";
if (isset($_POST['login']) && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (isset($valid_users[$username]) && $valid_users[$username] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['login_time'] = time();
        $logged_in = true;
    } else {
        $login_error = "Username atau password tidak valid";
    }
}

// Process logout request
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: upload.php");
    exit;
}

// File upload variables
$upload_success = false;
$upload_error = "";
$delete_success = false;
$delete_error = "";

// Process file upload if user is logged in
if ($logged_in && isset($_POST['upload'])) {
    $target_dir = "images/";
    
    // Ensure target directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Handle file upload
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $allowed_types = array("image/jpeg", "image/jpg", "image/png", "image/gif");
        $max_size = 2 * 1024 * 1024; // 2MB
        $file_type = $_FILES["fileToUpload"]["type"];
        $file_size = $_FILES["fileToUpload"]["size"];
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $category = isset($_POST['category']) ? $_POST['category'] : '';
        
        // Validate category
        if (!in_array($category, ['wisuda', 'kegiatan', 'kampus'])) {
            $upload_error = "❌ Kategori foto tidak valid";
        }
        // Validate file type
        elseif (!in_array($file_type, $allowed_types)) {
            $upload_error = "❌ Format file tidak didukung. Gunakan JPG, PNG, atau GIF";
        }
        // Validate file size
        elseif ($file_size > $max_size) {
            $upload_error = "❌ Ukuran file terlalu besar. Maksimal 2MB";
        } 
        else {
            // Create filename with category prefix and sanitized description
            $description = isset($_POST['description']) ? preg_replace('/[^a-z0-9_]/', '', 
                            str_replace(' ', '_', strtolower($_POST['description']))) : date('Ymd_His');
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_filename = $category . "_" . $description . "." . $extension;
            $target_file = $target_dir . $new_filename;
            
            // Check if file already exists
            if (file_exists($target_file)) {
                $upload_error = "❌ File dengan nama yang sama sudah ada";
            } else {
                // Try to upload the file
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $upload_success = true;
                } else {
                    $upload_error = "❌ Terjadi kesalahan saat mengunggah file";
                }
            }
        }
    } elseif (isset($_FILES["fileToUpload"])) {
        // Handle upload errors
        switch($_FILES["fileToUpload"]["error"]) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $upload_error = "❌ File terlalu besar";
                break;
            case UPLOAD_ERR_PARTIAL:
                $upload_error = "❌ File hanya terunggah sebagian";
                break;
            case UPLOAD_ERR_NO_FILE:
                $upload_error = "❌ Tidak ada file yang dipilih";
                break;
            default:
                $upload_error = "❌ Terjadi kesalahan saat mengunggah (kode: " . $_FILES["fileToUpload"]["error"] . ")";
        }
    }
}

// Process file deletion
if ($logged_in && isset($_POST['delete']) && isset($_POST['file'])) {
    $file_to_delete = "images/" . basename($_POST['file']);
    if (file_exists($file_to_delete)) {
        if (unlink($file_to_delete)) {
            // Also delete thumbnail if exists
            $thumbnail = "images/thumbs/thumb_" . basename($_POST['file']);
            if (file_exists($thumbnail)) {
                unlink($thumbnail);
            }
            $delete_success = true;
        } else {
            $delete_error = "❌ Gagal menghapus file";
        }
    } else {
        $delete_error = "❌ File tidak ditemukan";
    }
}

// Get all existing images
$images = [];
if ($logged_in) {
    $dir = "images";
    if (file_exists($dir)) {
        $files = glob($dir . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        foreach($files as $file) {
            $filename = basename($file);
            $size = filesize($file);
            $date = date("Y-m-d H:i:s", filemtime($file));
            
            // Extract category from filename
            $category = "other";
            if (strpos(strtolower($filename), 'wisuda_') === 0) {
                $category = "wisuda";
            } elseif (strpos(strtolower($filename), 'kegiatan_') === 0) {
                $category = "kegiatan";
            } elseif (strpos(strtolower($filename), 'kampus_') === 0) {
                $category = "kampus";
            }
            
            $images[] = [
                'name' => $filename,
                'path' => $file,
                'size' => $size,
                'date' => $date,
                'category' => $category
            ];
        }
        
        // Sort images by upload date (newest first)
        usort($images, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
    }
}

// Statistics for admin dashboard
$stats = [
    'total' => count($images),
    'wisuda' => 0,
    'kegiatan' => 0,
    'kampus' => 0,
    'other' => 0,
    'total_size' => 0
];

foreach ($images as $image) {
    $stats[$image['category']]++;
    $stats['total_size'] += $image['size'];
}

// Convert size to human readable format
function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes > 1024 && $i < count($units)-1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Galeri SALUT Tana Toraja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f8fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container,
        .upload-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .upload-container {
            max-width: 1200px;
            margin-top: 50px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo img {
            max-height: 80px;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        
        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .image-item {
            position: relative;
            margin-bottom: 25px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .image-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: space-between;
            opacity: 0;
            transition: all 0.3s;
        }
        
        .image-item:hover .image-actions {
            opacity: 1;
        }
        
        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .category-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .wisuda {
            background-color: #ffc107;
            color: #212529;
        }
        
        .kegiatan {
            background-color: #0dcaf0;
            color: #fff;
        }
        
        .kampus {
            background-color: #198754;
            color: #fff;
        }
        
        .other {
            background-color: #6c757d;
            color: #fff;
        }
        
        .stat-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 15px;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .stat-text {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .navbar-brand img {
            height: 40px;
        }
        
        /* Custom progress bar */
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        
        /* File upload preview */
        #imagePreview {
            max-width: 100%;
            max-height: 300px;
            display: none;
            margin-top: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php if (!$logged_in): ?>
    <!-- Login Form -->
    <div class="login-container">
        <div class="logo">
            <img src="../assets/img/resource/logo.png" alt="SALUT Tana Toraja Logo">
        </div>
        <h2 class="text-center mb-4">🔐 Login Admin Galeri</h2>
        
        <?php if ($login_error): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $login_error; ?>
        </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">👤 Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">🔑 Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </div>
        </form>
        <div class="text-center mt-4">
            <a href="../" class="text-decoration-none">Kembali ke Beranda</a>
        </div>
    </div>
    <?php else: ?>
    <!-- Upload & Management Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="../">
                <img src="../assets/img/resource/logo.png" alt="SALUT Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../galeri/">Lihat Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="upload.php">Kelola Galeri</a>
                    </li>
                </ul>
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($_SESSION['user']); ?>
                </span>
                <a href="?logout=1" class="btn btn-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="upload-container">
        <h2 class="mb-4">📤 Upload Foto Baru</h2>
        
        <?php if ($upload_success): ?>
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i> ✅ Foto berhasil diunggah!
        </div>
        <?php endif; ?>
        
        <?php if ($upload_error): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $upload_error; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($delete_success): ?>
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle me-2"></i> ✅ Foto berhasil dihapus!
        </div>
        <?php endif; ?>
        
        <?php if ($delete_error): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $delete_error; ?>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">📂 Kategori Foto</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="wisuda">Wisuda (Acara Wisuda)</option>
                                    <option value="kegiatan">Kegiatan (Akademik/Non-akademik)</option>
                                    <option value="kampus">Kampus (Lingkungan Kampus)</option>
                                </select>
                                <div class="form-text">Kategori akan menentukan prefix nama file.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">📝 Deskripsi</label>
                                <input type="text" class="form-control" id="description" name="description" 
                                       placeholder="Contoh: wisuda_januari_2024">
                                <div class="form-text">Gunakan underscore untuk spasi, hanya alfanumerik.</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="fileToUpload" class="form-label">🖼️ Pilih File Gambar</label>
                        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" 
                               accept=".jpg,.jpeg,.png,.gif" required>
                        <div class="form-text">Max: 2MB. Format: JPG, PNG, GIF.</div>
                    </div>
                    
                    <!-- Preview image before upload -->
                    <img id="imagePreview" class="mt-3">
                    
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" name="upload" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i> Upload Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dashboard Statistics -->
        <h3 class="mt-5 mb-4">📊 Statistik Galeri</h3>
        <div class="row row-cols-1 row-cols-md-5 g-4 mb-5">
            <div class="col">
                <div class="stat-card">
                    <div class="stat-icon text-primary">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['total']; ?></div>
                    <div class="stat-text">Total Foto</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-icon text-warning">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['wisuda']; ?></div>
                    <div class="stat-text">Foto Wisuda</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-icon text-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['kegiatan']; ?></div>
                    <div class="stat-text">Foto Kegiatan</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-icon text-success">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="stat-number"><?php echo $stats['kampus']; ?></div>
                    <div class="stat-text">Foto Kampus</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-icon text-secondary">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="stat-number"><?php echo formatSize($stats['total_size']); ?></div>
                    <div class="stat-text">Total Ukuran</div>
                </div>
            </div>
        </div>

        <!-- Storage usage progress -->
        <div class="card mb-5">
            <div class="card-body">
                <h5 class="card-title">💾 Penggunaan Penyimpanan</h5>
                <?php 
                // Assuming 100MB total space (adjust as needed)
                $total_space = 100 * 1024 * 1024; // 100MB in bytes
                $usage_percent = min(100, ($stats['total_size'] / $total_space) * 100);
                ?>
                <div class="progress mb-2">
                    <div class="progress-bar bg-<?php echo $usage_percent > 80 ? 'danger' : ($usage_percent > 50 ? 'warning' : 'success'); ?>" 
                         role="progressbar" style="width: <?php echo $usage_percent; ?>%" 
                         aria-valuenow="<?php echo $usage_percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">
                    <?php echo formatSize($stats['total_size']); ?> / 100MB terpakai (<?php echo round($usage_percent, 1); ?>%)
                </small>
            </div>
        </div>

        <!-- Image Management -->
        <h3 class="mb-4">🖼️ Kelola Foto</h3>
        <?php if (empty($images)): ?>
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada foto dalam galeri. Upload foto terlebih dahulu.
        </div>
        <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4">
            <?php foreach ($images as $image): ?>
            <div class="col">
                <div class="image-item">
                    <span class="category-badge <?php echo $image['category']; ?>">
                        <?php 
                        $icon = 'question-circle';
                        switch ($image['category']) {
                            case 'wisuda': $icon = 'graduation-cap'; break;
                            case 'kegiatan': $icon = 'users'; break;
                            case 'kampus': $icon = 'university'; break;
                        }
                        ?>
                        <i class="fas fa-<?php echo $icon; ?> me-1"></i>
                        <?php echo ucfirst($image['category']); ?>
                    </span>
                    <img src="<?php echo $image['path']; ?>" class="image-preview" alt="<?php echo $image['name']; ?>">
                    <div class="image-actions">
                        <span class="text-white small">
                            <i class="fas fa-calendar-alt me-1"></i> <?php echo date('d M Y', strtotime($image['date'])); ?>
                        </span>
                        <span class="text-white small">
                            <i class="fas fa-file-alt me-1"></i> <?php echo formatSize($image['size']); ?>
                        </span>
                        <form method="post" onsubmit="return confirm('Anda yakin ingin menghapus foto ini?');">
                            <input type="hidden" name="file" value="<?php echo $image['name']; ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="small text-truncate text-center mb-3">
                    <?php echo $image['name']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview before upload
        document.getElementById('fileToUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const imagePreview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
        
        // Auto-generate description from filename
        document.getElementById('fileToUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const descriptionInput = document.getElementById('description');
            
            // Only suggest if description is empty
            if (file && !descriptionInput.value) {
                let filename = file.name.split('.')[0]; // Get name without extension
                filename = filename.replace(/[^a-z0-9_]/gi, '_').toLowerCase(); // Sanitize
                
                // Remove category prefixes if they exist
                ['wisuda_', 'kegiatan_', 'kampus_'].forEach(prefix => {
                    if (filename.startsWith(prefix)) {
                        filename = filename.substring(prefix.length);
                    }
                });
                
                // Add current date if filename is too short
                if (filename.length < 5) {
                    const now = new Date();
                    const dateStr = now.getFullYear() + '_' + 
                                  String(now.getMonth() + 1).padStart(2, '0') + '_' +
                                  String(now.getDate()).padStart(2, '0');
                    filename = filename + '_' + dateStr;
                }
                
                descriptionInput.value = filename;
            }
        });
    </script>
</body>
</html>
