<?php
session_start();
include 'koneksi.php';

// Periksa jika pengguna sudah login atau tamu
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Set filter dan pengurutan default
$category_filter = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Buat query dasar
$query = "SELECT p.*, GROUP_CONCAT(DISTINCT ps.size) as sizes, MIN(ps.stock) as min_stock 
          FROM products p 
          LEFT JOIN product_sizes ps ON p.id = ps.product_id 
          WHERE p.active = 1";

// Tambahkan filter kategori
if ($category_filter !== 'all') {
    $query .= " AND p.category = '" . $conn->real_escape_string($category_filter) . "'";
}

// Tambahkan pencarian
if ($search) {
    $query .= " AND (p.name LIKE '%" . $conn->real_escape_string($search) . "%' 
              OR p.description LIKE '%" . $conn->real_escape_string($search) . "%')";
}

// Add GROUP BY clause - this is necessary when using aggregate functions
$query .= " GROUP BY p.id";

// Add sorting
switch ($sort_by) {
    case 'price_asc':
        $query .= " ORDER BY p.price_student ASC";
        break;
    case 'price_desc':
        $query .= " ORDER BY p.price_student DESC";
        break;
    case 'name_desc':
        $query .= " ORDER BY p.name DESC";
        break;
    case 'newest':
        $query .= " ORDER BY p.id DESC";
        break;
    default:
        $query .= " ORDER BY p.name ASC";
        break;
}

// Execute the query
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
$products = $result->fetch_all(MYSQLI_ASSOC);

// Fetch categories for filter
$categories_query = "SELECT DISTINCT category FROM products WHERE active = 1 AND category IS NOT NULL AND category != ''";
$categories_result = $conn->query($categories_query);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - UTToraja Store</title>
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
    <!-- Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="index.php" class="font-bold text-xl text-primary-600">UTToraja Store</a>
            <nav class="hidden md:flex space-x-6">
                <a href="index.php" class="text-gray-500 hover:text-primary-600 transition">Beranda</a>
                <a href="products.php" class="text-primary-600 font-medium">Produk</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 transition">Kontak</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="cart.php" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-primary-600 transition">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                        <span class="absolute -top-2 -right-2 bg-primary-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                            <?php echo count($_SESSION['cart']); ?>
                        </span>
                    <?php endif; ?>
                </a>
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
                <a href="index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Beranda</a>
                <a href="products.php" class="text-primary-600 font-medium py-2">Produk</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Kontak</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Page title -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Merchandise UTToraja 🛍️</h1>
            <p class="text-gray-600">Temukan berbagai produk resmi UTToraja yang berkualitas</p>
        </div>
        
        <!-- Search and filters -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-2/3">
                    <form action="" method="get" class="flex">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari produk..." 
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="w-full border border-gray-300 rounded-l-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-300"
                        >
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-r-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="md:w-1/3 flex gap-2">
                    <select 
                        name="category" 
                        id="category-filter"
                        onchange="this.options[this.selectedIndex].value && (window.location = '?category=' + this.options[this.selectedIndex].value + '&sort=<?php echo $sort_by; ?>&search=<?php echo urlencode($search); ?>')"
                        class="w-1/2 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-300"
                    >
                        <option value="all" <?php echo $category_filter === 'all' ? 'selected' : ''; ?>>Semua Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['category']); ?>" <?php echo $category_filter === $category['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['category']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <select 
                        name="sort" 
                        id="sort-filter"
                        onchange="this.options[this.selectedIndex].value && (window.location = '?category=<?php echo $category_filter; ?>&sort=' + this.options[this.selectedIndex].value + '&search=<?php echo urlencode($search); ?>')"
                        class="w-1/2 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-300"
                    >
                        <option value="name_asc" <?php echo $sort_by === 'name_asc' ? 'selected' : ''; ?>>Nama (A-Z)</option>
                        <option value="name_desc" <?php echo $sort_by === 'name_desc' ? 'selected' : ''; ?>>Nama (Z-A)</option>
                        <option value="price_asc" <?php echo $sort_by === 'price_asc' ? 'selected' : ''; ?>>Harga (Rendah-Tinggi)</option>
                        <option value="price_desc" <?php echo $sort_by === 'price_desc' ? 'selected' : ''; ?>>Harga (Tinggi-Rendah)</option>
                        <option value="newest" <?php echo $sort_by === 'newest' ? 'selected' : ''; ?>>Terbaru</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Product grid -->
        <?php if (empty($products)): ?>
            <div class="text-center py-16">
                <div class="mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk yang ditemukan</h3>
                <p class="text-gray-500 mb-6">Coba gunakan kata kunci pencarian lain atau hapus filter yang diterapkan.</p>
                <a href="products.php" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Reset Filter
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 transition transform hover:-translate-y-1 hover:shadow-md">
                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="block aspect-square overflow-hidden bg-gray-100">
                            <?php if (!empty($product['image']) && file_exists("./uploads/" . $product['image'])): ?>
                                <img src="./uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-full object-cover object-center">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                        <div class="p-4">
                            <?php if (!empty($product['category'])): ?>
                                <span class="text-xs font-medium text-primary-600 bg-primary-50 rounded-full px-2 py-1 mb-2 inline-block"><?php echo htmlspecialchars($product['category']); ?></span>
                            <?php endif; ?>
                            
                            <h3 class="font-medium text-gray-900 mb-1">
                                <a href="product_details.php?id=<?php echo $product['id']; ?>" class="hover:text-primary-600">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h3>
                            
                            <div class="text-gray-500 text-sm mb-2 line-clamp-2 h-10">
                                <?php echo htmlspecialchars($product['description']); ?>
                            </div>
                            
                            <div class="flex justify-between items-center mt-2">
                                <div class="text-primary-600 font-medium">
                                    <?php if (isset($_SESSION['guest'])): ?>
                                        Rp <?php echo number_format($product['price_guest'], 0, ',', '.'); ?>
                                    <?php else: ?>
                                        Rp <?php echo number_format($product['price_student'], 0, ',', '.'); ?>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (isset($product['min_stock']) && $product['min_stock'] > 0): ?>
                                    <span class="text-xs font-medium text-green-600 bg-green-50 rounded-full px-2 py-1">In Stock</span>
                                <?php else: ?>
                                    <span class="text-xs font-medium text-red-600 bg-red-50 rounded-full px-2 py-1">Out of Stock</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="px-4 pb-4">
                            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="block w-full bg-primary-600 hover:bg-primary-700 text-white text-center font-medium py-2 rounded-md transition">
                                View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-12 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <a href="index.php" class="font-bold text-xl text-primary-600">UTToraja Store</a>
                    <p class="text-sm text-gray-500 mt-1">Merchandise Resmi Universitas Teknologi Toraja</p>
                </div>
                <div class="flex space-x-4">
                    <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 transition">Contact</a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition">About</a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition">FAQs</a>
                </div>
            </div>
            <div class="border-t border-gray-100 mt-6 pt-6 text-center text-sm text-gray-500">
                &copy; 2025 UTToraja Store. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
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
