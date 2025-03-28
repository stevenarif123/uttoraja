<?php
session_start();
include 'koneksi.php';

// Periksa jika pengguna sudah login atau tamu
if (!isset($_SESSION['nim']) && !isset($_SESSION['guest'])) {
    header('Location: login.php');
    exit;
}

// Ambil ID produk dari parameter URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Jika tidak ada ID produk, redirect ke halaman produk
if ($product_id === 0) {
    header('Location: products.php');
    exit;
}

// Query untuk mendapatkan detail produk
$stmt = $conn->prepare("SELECT * FROM Products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Jika produk tidak ditemukan, redirect ke halaman produk
if ($result->num_rows === 0) {
    header('Location: products.php');
    exit;
}

$product = $result->fetch_assoc();

// Ambil ukuran yang tersedia untuk produk ini
$sizes = [];
$stmt = $conn->prepare("SELECT size, stock FROM product_sizes WHERE product_id = ? AND stock > 0");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$size_result = $stmt->get_result();

while ($size = $size_result->fetch_assoc()) {
    $sizes[] = $size;
}

// Tentukan harga berdasarkan tipe pengguna (mahasiswa atau tamu)
$price = isset($_SESSION['guest']) ? $product['price_guest'] : $product['price_student'];

// Ambil produk terkait
$stmt = $conn->prepare("SELECT id, name, image, price_student, price_guest FROM Products 
                       WHERE id != ? AND active = 1 ORDER BY RAND() LIMIT 3");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_products = $related_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - UTToraja Store</title>
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
    <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="index.php" class="font-bold text-xl text-primary-600">UTToraja Store</a>
            <nav class="hidden md:flex space-x-6">
                <a href="index.php" class="text-gray-500 hover:text-primary-600 transition">Beranda</a>
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
                <a href="products.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Produk</a>
                <a href="../kontak/index.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Kontak</a>
                <a href="../jadwal/logout.php" class="text-gray-500 hover:text-primary-600 py-2 transition">Logout</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6 flex items-center space-x-1 text-gray-500">
            <a href="index.php" class="hover:text-primary-600 transition">Beranda</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <a href="products.php" class="hover:text-primary-600 transition">Produk</a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
            <span class="font-medium text-gray-900"><?php echo htmlspecialchars($product['name']); ?></span>
        </nav>
        
        <!-- Product Details -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-12">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    <div class="aspect-square bg-gray-50">
                        <?php if (!empty($product['image']) && file_exists("../uploads/" . $product['image'])): ?>
                            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full h-full object-contain">
                        <?php else: ?>
                            <div class="h-full flex items-center justify-center bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="md:w-1/2 p-8">
                    <?php if ($product['featured']): ?>
                        <span class="inline-block bg-amber-100 text-amber-800 text-xs font-medium px-2.5 py-1 rounded-md mb-3">
                            ✨ Produk Unggulan
                        </span>
                    <?php endif; ?>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h1>
                    
                    <div class="text-2xl font-bold text-primary-600 mb-6">
                        Rp <?php echo number_format($price, 0, ',', '.'); ?>
                        <?php if (isset($_SESSION['guest']) && $product['price_guest'] > $product['price_student']): ?>
                            <span class="text-sm font-normal block mt-1 text-primary-500">Masuk sebagai mahasiswa untuk diskon</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="prose prose-sm max-w-none mb-8 text-gray-600">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                    
                    <form action="add_to_cart.php" method="POST" class="space-y-6" id="productForm">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo $price; ?>">
                        
                        <?php if (!empty($sizes)): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Ukuran</label>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach($sizes as $index => $size): ?>
                                    <label class="size-option cursor-pointer">
                                        <input type="radio" name="size" value="<?php echo htmlspecialchars($size['size']); ?>" 
                                            <?php echo $index === 0 ? 'checked' : ''; ?> class="hidden size-radio"
                                            data-stock="<?php echo $size['stock']; ?>">
                                        <span class="size-button inline-block border border-gray-300 rounded-md px-4 py-2 text-sm font-medium <?php echo $index === 0 ? 'bg-primary-50 border-primary-500 text-primary-700' : 'text-gray-700 hover:border-primary-300'; ?> transition">
                                            <?php echo htmlspecialchars($size['size']); ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <p class="mt-1 text-xs text-gray-500" id="stock-info">
                                <?php if (!empty($sizes)): ?>
                                    Stok tersedia: <?php echo $sizes[0]['stock']; ?> item
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <div>
                            <label for="quantity-input" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                            <div class="flex items-center w-32">
                                <button type="button" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-l-md bg-gray-50 text-gray-600 hover:bg-gray-100" id="decrease">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo !empty($sizes) ? $sizes[0]['stock'] : 10; ?>" class="w-full h-8 border-y border-gray-300 py-0 px-2 text-center text-gray-700 focus:outline-none focus:ring-0" id="quantity-input">
                                <button type="button" class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-r-md bg-gray-50 text-gray-600 hover:bg-gray-100" id="increase">+</button>
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 px-6 rounded-md font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php if (!empty($related_products)): ?>
        <!-- Related Products -->
        <div class="mb-12">
            <h2 class="text-xl font-bold mb-6 text-gray-900">Anda mungkin juga menyukai</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($related_products as $related): ?>
                    <?php 
                        $related_price = isset($_SESSION['guest']) ? $related['price_guest'] : $related['price_student'];
                    ?>
                    <a href="product_details.php?id=<?php echo $related['id']; ?>" class="group">
                        <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow transition">
                            <div class="aspect-square bg-gray-50">
                                <?php if (!empty($related['image']) && file_exists("../uploads/" . $related['image'])): ?>
                                    <img src="../uploads/<?php echo htmlspecialchars($related['image']); ?>" 
                                        alt="<?php echo htmlspecialchars($related['name']); ?>" 
                                        class="w-full h-full object-contain group-hover:opacity-90 transition">
                                <?php else: ?>
                                    <div class="h-full flex items-center justify-center bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900 group-hover:text-primary-600 transition">
                                    <?php echo htmlspecialchars($related['name']); ?>
                                </h3>
                                <p class="text-primary-600 font-medium mt-1">
                                    Rp <?php echo number_format($related_price, 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <p class="text-sm text-gray-500">© 2025 UTToraja Store. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
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
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Size selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sizeOptions = document.querySelectorAll('.size-option');
            const sizeRadios = document.querySelectorAll('.size-radio');
            const quantityInput = document.getElementById('quantity-input');
            const stockInfo = document.getElementById('stock-info');
            
            // Initialize with first size's stock limit
            if (sizeRadios.length > 0) {
                const initialStock = parseInt(sizeRadios[0].dataset.stock);
                quantityInput.max = initialStock;
            }
            
            // Set up size selection
            sizeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Update all buttons
                    sizeOptions.forEach(opt => {
                        const button = opt.querySelector('.size-button');
                        button.classList.remove('bg-primary-50', 'border-primary-500', 'text-primary-700');
                        button.classList.add('text-gray-700');
                    });
                    
                    // Mark this one as active
                    const button = this.querySelector('.size-button');
                    button.classList.add('bg-primary-50', 'border-primary-500', 'text-primary-700');
                    button.classList.remove('text-gray-700');
                    
                    // Check the radio button
                    this.querySelector('input[type="radio"]').checked = true;
                    
                    // Update quantity max based on selected size's stock
                    const selectedRadio = this.querySelector('input[type="radio"]');
                    const stockLimit = parseInt(selectedRadio.dataset.stock);
                    quantityInput.max = stockLimit;
                    stockInfo.textContent = `Stok tersedia: ${stockLimit} item`;
                    
                    // Reset quantity if it exceeds the new max
                    if (parseInt(quantityInput.value) > stockLimit) {
                        quantityInput.value = stockLimit;
                    }
                });
            });
            
            // Quantity adjustment
            const decreaseBtn = document.getElementById('decrease');
            const increaseBtn = document.getElementById('increase');
            
            decreaseBtn.addEventListener('click', function() {
                let currentVal = parseInt(quantityInput.value);
                if (currentVal > 1) {
                    quantityInput.value = currentVal - 1;
                }
            });
            
            increaseBtn.addEventListener('click', function() {
                let currentVal = parseInt(quantityInput.value);
                let maxVal = parseInt(quantityInput.max);
                if (currentVal < maxVal) {
                    quantityInput.value = currentVal + 1;
                }
            });
            
            // Validate quantity input
            quantityInput.addEventListener('change', function() {
                let val = parseInt(this.value);
                let maxVal = parseInt(this.max);
                
                if (isNaN(val) || val < 1) {
                    this.value = 1;
                } else if (val > maxVal) {
                    this.value = maxVal;
                }
            });
            
            // Form validation before submit
            document.getElementById('productForm').addEventListener('submit', function(event) {
                const quantity = parseInt(quantityInput.value);
                let maxQuantity = parseInt(quantityInput.max);
                
                if (isNaN(quantity) || quantity < 1 || quantity > maxQuantity) {
                    event.preventDefault();
                    alert(`Silakan masukkan jumlah yang valid antara 1 dan ${maxQuantity}`);
                }
            });
        });
    </script>
</body>
</html>
