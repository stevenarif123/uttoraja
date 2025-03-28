<?php
session_start();
require_once 'koneksi.php';

// Check if the user is logged in or a guest
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Calculate cart item count
$cartItemCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartItemCount += $item['quantity'];
    }
}

// Fetch featured products (limit to 3)
$featured_query = "SELECT p.*, 
          GROUP_CONCAT(CONCAT(ps.size, ':', ps.stock) SEPARATOR ', ') as size_stocks,
          SUM(ps.stock) as total_stock 
          FROM Products p 
          LEFT JOIN product_sizes ps ON p.id = ps.product_id 
          GROUP BY p.id 
          HAVING total_stock > 0 
          ORDER BY p.id DESC LIMIT 3";

$featured_result = $conn->query($featured_query);
if (!$featured_result) {
    die("Query failed: " . $conn->error);
}
$featured_products = $featured_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTToraja Store - Merchandise Resmi</title>
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
<body class="bg-gray-50 font-sans text-gray-800">
    <!-- Top navigation bar -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="index.php" class="font-bold text-xl text-primary-600">UTToraja Store</a>
            <nav class="hidden md:flex space-x-6">
                <a href="index.php" class="text-primary-600 font-medium">Beranda</a>
                <a href="products.php" class="text-gray-500 hover:text-primary-600 transition">Produk</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 transition">Kontak</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-primary-600 transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <?php if (!empty($_SESSION['cart'])): ?>
                        <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </a>
                <?php if (isset($_SESSION['nim'])): ?>
                    <a href="logout.php" class="text-gray-500 hover:text-primary-600 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Keluar
                    </a>
                <?php elseif (isset($_SESSION['guest'])): ?>
                    <a href="login.php" class="text-gray-500 hover:text-primary-600 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Masuk
                    </a>
                <?php endif; ?>
                <button id="mobile-menu-button" class="md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile navigation menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 py-4">
            <div class="container mx-auto px-4 flex flex-col space-y-3">
                <a href="index.php" class="text-primary-600 font-medium py-2 transition">Beranda</a>
                <a href="products.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Produk</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Kontak</a>
                <?php if (isset($_SESSION['nim'])): ?>
                    <a href="logout.php" class="text-gray-500 hover:text-primary-600 py-2 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Keluar
                    </a>
                <?php elseif (isset($_SESSION['guest'])): ?>
                    <a href="login.php" class="text-gray-500 hover:text-primary-600 py-2 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Masuk
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section with eye-catching design -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 relative overflow-hidden">
        <!-- Pattern background -->
        <div class="absolute inset-0 opacity-10 z-[1]">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="pattern" width="100" height="100" patternUnits="userSpaceOnUse">
                        <path d="M0 50 L100 50 M50 0 L50 100" stroke="currentColor" stroke-width="2"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)"></rect>
            </svg>
        </div>
        
        <!-- Wave decoration -->
        <div class="absolute bottom-0 left-0 right-0 z-[2] text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
                <path fill="#f9fafb" fill-opacity="0.1" d="M0,128L60,138.7C120,149,240,171,360,165.3C480,160,600,128,720,122.7C840,117,960,139,1080,154.7C1200,171,1320,181,1380,186.7L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
            </svg>
        </div>

        <!-- Content with higher z-index -->
        <div class="container mx-auto px-4 py-16 md:py-24 relative z-[3]">
            <div class="max-w-3xl mx-auto text-center text-white">
                <span class="inline-block px-4 py-1 bg-white/25 backdrop-blur-sm rounded-full text-sm font-medium mb-4">
                    ✨ Selamat Datang di UTToraja Store
                </span>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 drop-shadow-lg">Merchandise Eksklusif Universitas Toraja</h1>
                <p class="text-xl mb-8 text-white drop-shadow-lg">
                    Tunjukkan rasa bangga dan kecintaan Anda terhadap Universitas Toraja dengan koleksi merchandise resmi kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center relative">
                    <a href="products.php" class="bg-white hover:bg-gray-100 text-primary-800 font-semibold py-3 px-6 rounded-md shadow-lg transition transform hover:-translate-y-0.5">
                        🛍️ Jelajahi Produk Kami
                    </a>
                    <?php if (isset($_SESSION['guest'])): ?>
                        <a href="login.php" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white border border-white/50 py-3 px-6 rounded-md transition shadow-lg">
                            🔑 Masuk Sebagai Mahasiswa
                        </a>
                    <?php else: ?>
                        <a href="cart.php" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white border border-white/50 py-3 px-6 rounded-md transition shadow-lg">
                            🛒 Lihat Keranjang
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Kenapa Memilih Merchandise UTToraja? 🤔</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Kualitas Premium</h3>
                    <p class="text-gray-600">
                        Semua produk kami dirancang dengan standar kualitas terbaik menggunakan material pilihan.
                    </p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Eksklusif</h3>
                    <p class="text-gray-600">
                        Desain eksklusif yang hanya tersedia untuk komunitas Universitas Toraja.
                    </p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                    <div class="bg-primary-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-primary-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Harga Khusus</h3>
                    <p class="text-gray-600">
                        Dapatkan harga spesial untuk mahasiswa aktif Universitas Toraja.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Produk Unggulan 🌟</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Beberapa produk terbaik dari koleksi merchandise kami yang paling diminati
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <?php foreach($featured_products as $product): ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden transition-transform hover:-translate-y-1">
                    <div class="h-48 overflow-hidden">
                        <?php if (!empty($product['image'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                alt="<?php echo htmlspecialchars($product['name']); ?>"
                                class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary-600">
                                Rp <?php echo number_format(isset($_SESSION['guest']) ? $product['price_guest'] : $product['price_student'], 0, ',', '.'); ?>
                            </span>
                            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="text-sm font-medium text-primary-600 hover:text-primary-800">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center">
                <a href="products.php" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-md transition inline-flex items-center">
                    Lihat Semua Produk
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- How to Order Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-12">Cara Pemesanan 📦</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <span class="font-bold text-primary-600">1</span>
                    </div>
                    <h3 class="font-semibold mb-2">Pilih Produk</h3>
                    <p class="text-gray-600 text-sm">
                        Jelajahi koleksi kami dan pilih produk favorit Anda
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <span class="font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="font-semibold mb-2">Tambahkan ke Keranjang</h3>
                    <p class="text-gray-600 text-sm">
                        Pilih ukuran dan jumlah yang diinginkan
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <span class="font-bold text-primary-600">3</span>
                    </div>
                    <h3 class="font-semibold mb-2">Checkout</h3>
                    <p class="text-gray-600 text-sm">
                        Isi detail pengiriman dan pilih metode pembayaran
                    </p>
                </div>
                
                <div class="flex flex-col items-center text-center">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mb-4">
                        <span class="font-bold text-primary-600">4</span>
                    </div>
                    <h3 class="font-semibold mb-2">Terima Pesanan</h3>
                    <p class="text-gray-600 text-sm">
                        Pesanan Anda akan segera disiapkan dan dikirim
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="bg-primary-50 py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-6">Siap Menunjukkan Kebanggaan Anda?</h2>
                <p class="text-lg text-gray-600 mb-8">
                    Jelajahi koleksi merchandise eksklusif kami sekarang dan dapatkan diskon khusus untuk mahasiswa UTToraja.
                </p>
                <a href="products.php" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-8 rounded-md text-lg transition transform hover:-translate-y-0.5 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    Belanja Sekarang
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-semibold text-lg mb-4">UTToraja Store</h3>
                    <p class="text-gray-600 mb-4">
                        Merchandise resmi dan eksklusif dari Universitas Toraja. Tunjukkan identitas dan kebanggaan Anda.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Tautan</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-600 hover:text-primary-600">Beranda</a></li>
                        <li><a href="products.php" class="text-gray-600 hover:text-primary-600">Produk</a></li>
                        <li><a href="../kontak/index.php" class="text-gray-600 hover:text-primary-600">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Informasi Kontak</h3>
                    <address class="text-gray-600 not-italic">
                        Universitas Toraja<br>
                        Jl. Nusantara No. 12<br>
                        Tana Toraja, Sulawesi Selatan<br>
                        Email: store@uttoraja.ac.id
                    </address>
                </div>
            </div>
            <div class="border-t border-gray-100 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">© 2025 UTToraja Store. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-600 transition">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
