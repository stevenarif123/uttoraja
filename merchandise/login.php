<?php
session_start();
require_once 'koneksi.php';

// Clear any existing sessions first
session_unset();
session_destroy();
session_start();

// Initialize variables
$nim = $tanggal_lahir = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guest'])) {
        $_SESSION['guest'] = true;
        header('Location: index.php');
        exit;
    } else {
        $nim = trim($_POST['nim']);
        $tanggal_lahir = trim($_POST['tanggal_lahir']);

        if (empty($nim) || empty($tanggal_lahir)) {
            $error_message = "Silakan isi semua field yang diperlukan. 😊";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE NIM = ? AND tanggal_lahir = ?");
            if ($stmt) {
                $stmt->bind_param("ss", $nim, $tanggal_lahir);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $_SESSION['nim'] = $nim;
                    header('Location: index.php');
                    exit;
                } else {
                    $error_message = "NIM atau tanggal lahir tidak valid. ❌";
                }
                $stmt->close();
            } else {
                $error_message = "Terjadi kesalahan sistem. Silakan coba lagi. 🔄";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - UTToraja Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 bg-primary-600">
                <div class="flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-white">UTToraja Store</h2>
                </div>
            </div>
            
            <div class="p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Masuk ke Akun Anda</h3>
                
                <?php if ($error_message): ?>
                    <div class="bg-red-50 text-red-700 p-4 rounded-md mb-6 flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="" class="space-y-5">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                        <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($nim); ?>" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Masukkan NIM Anda">
                    </div>
                    
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-md transition">
                        Masuk 🚀
                    </button>
                </form>
                
                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>
                
                <form method="post" action="" class="mt-6">
                    <button type="submit" name="guest" class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-2 px-4 rounded-md border border-gray-200 transition">
                        Masuk sebagai Tamu 👥
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-500">Butuh bantuan? <a href="../kontak/index.php" class="text-primary-600 hover:text-primary-800">Hubungi Dukungan</a></p>
        </div>
    </div>
</body>
</html>
