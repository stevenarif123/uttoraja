<?php
// Script to fix product images
include 'koneksi.php';

echo "<h1>🖼️ UTToraja Product Image Repair Tool</h1>";

// 1. Make sure the uploads directory exists
$uploadsDir = "../uploads";
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
    echo "<p style='color:green'>✅ Created uploads directory at: " . realpath($uploadsDir) . "</p>";
} else {
    echo "<p style='color:green'>✅ Uploads directory exists at: " . realpath($uploadsDir) . "</p>";
}

// 2. Check if we have the product_images table
$tableCheck = $conn->query("SHOW TABLES LIKE 'product_images'");
if (!$tableCheck || $tableCheck->num_rows === 0) {
    echo "<p style='color:red'>❌ The product_images table doesn't exist!</p>";
    echo "<p>Please run the setup_product_images.sql script first.</p>";
    exit;
}

// 3. Get all products
$products = $conn->query("SELECT * FROM products WHERE image IS NOT NULL AND image != ''");
if (!$products || $products->num_rows === 0) {
    echo "<p style='color:orange'>⚠️ No products found with images in the database.</p>";
} else {
    echo "<p>📊 Found " . $products->num_rows . " products with images.</p>";
    
    // Create a sample blank image if needed
    $sampleImagePath = $uploadsDir . "/sample_product.jpg";
    if (!file_exists($sampleImagePath)) {
        $im = @imagecreatetruecolor(800, 800) 
           or die("<p style='color:red'>❌ Cannot create a new image.</p>");
        $background_color = imagecolorallocate($im, 240, 240, 240);
        $text_color = imagecolorallocate($im, 100, 100, 100);
        imagefilledrectangle($im, 0, 0, 800, 800, $background_color);
        imagestring($im, 5, 300, 400, 'UTToraja Product', $text_color);
        imagejpeg($im, $sampleImagePath);
        imagedestroy($im);
        echo "<p style='color:blue'>ℹ️ Created sample product image.</p>";
    }
    
    // Process each product
    while ($product = $products->fetch_assoc()) {
        echo "<h3>Processing product: " . htmlspecialchars($product['name']) . " (ID: " . $product['id'] . ")</h3>";
        
        $imagePath = $uploadsDir . "/" . $product['image'];
        if (!file_exists($imagePath)) {
            // Copy the sample image with the expected filename
            copy($sampleImagePath, $imagePath);
            echo "<p style='color:green'>✅ Created placeholder image for: " . htmlspecialchars($product['image']) . "</p>";
        } else {
            echo "<p style='color:green'>✅ Image already exists: " . htmlspecialchars($product['image']) . "</p>";
        }
        
        // Make sure we have an entry in product_images
        $check = $conn->prepare("SELECT COUNT(*) AS count FROM product_images WHERE product_id = ?");
        $check->bind_param("i", $product['id']);
        $check->execute();
        $result = $check->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] == 0) {
            $insert = $conn->prepare("INSERT INTO product_images (product_id, image_path, is_primary) VALUES (?, ?, 1)");
            $insert->bind_param("is", $product['id'], $product['image']);
            if ($insert->execute()) {
                echo "<p style='color:green'>✅ Added record to product_images table.</p>";
            } else {
                echo "<p style='color:red'>❌ Failed to add record to product_images table.</p>";
            }
        } else {
            echo "<p style='color:blue'>ℹ️ Product already has images in the product_images table.</p>";
        }
    }
}

echo "<p><a href='test_uploads.php' style='color:blue'>➡️ Run diagnostic test</a></p>";
echo "<p><a href='products.php' style='color:blue'>🏠 Return to products page</a></p>";
?>
