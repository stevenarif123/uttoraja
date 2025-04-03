<?php
// This script helps diagnose image upload issues

// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if uploads directory exists
$uploadsDir = "../uploads";
echo "<h3>🔍 Testing uploads directory</h3>";

if (!file_exists($uploadsDir)) {
    echo "<p style='color:red'>❌ ERROR: Uploads directory does not exist at '$uploadsDir'</p>";
    echo "<p>Please create this directory with: <code>mkdir -p " . realpath("..") . "/uploads</code></p>";
} else {
    echo "<p style='color:green'>✅ Uploads directory exists at " . realpath($uploadsDir) . "</p>";
    
    // Check if the directory is writable
    if (is_writable($uploadsDir)) {
        echo "<p style='color:green'>✅ Uploads directory is writable</p>";
    } else {
        echo "<p style='color:red'>❌ ERROR: Uploads directory is not writable</p>";
        echo "<p>Please fix permissions with: <code>chmod 755 " . realpath($uploadsDir) . "</code></p>";
    }
    
    // List contents of the uploads directory
    echo "<h3>📁 Files in uploads directory:</h3>";
    $files = scandir($uploadsDir);
    if (count($files) <= 2) { // . and .. directories
        echo "<p style='color:orange'>⚠️ WARNING: No files found in uploads directory</p>";
    } else {
        echo "<ul>";
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                echo "<li>" . htmlspecialchars($file) . " (" . filesize("$uploadsDir/$file") . " bytes)</li>";
            }
        }
        echo "</ul>";
    }
}

// Check database connection
echo "<h3>🔌 Testing database connection</h3>";
include 'koneksi.php';

if (!$conn) {
    echo "<p style='color:red'>❌ ERROR: Database connection failed</p>";
} else {
    echo "<p style='color:green'>✅ Database connection successful</p>";
    
    // Check if product_images table exists
    $result = $conn->query("SHOW TABLES LIKE 'product_images'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green'>✅ product_images table exists</p>";
        
        // Check content of product_images table
        $result = $conn->query("SELECT * FROM product_images");
        if ($result && $result->num_rows > 0) {
            echo "<p style='color:green'>✅ Found " . $result->num_rows . " images in product_images table</p>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Product ID</th><th>Image Path</th><th>Is Primary</th><th>Exists</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['product_id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['image_path']) . "</td>";
                echo "<td>" . ($row['is_primary'] ? "Yes" : "No") . "</td>";
                $exists = file_exists("../uploads/" . $row['image_path']);
                echo "<td style='color:" . ($exists ? "green" : "red") . "'>" . ($exists ? "✅" : "❌") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:orange'>⚠️ WARNING: No images found in product_images table</p>";
            echo "<p>Please run the setup_product_images.sql script to populate the table</p>";
        }
    } else {
        echo "<p style='color:red'>❌ ERROR: product_images table does not exist</p>";
        echo "<p>Please run the setup_product_images.sql script to create the table</p>";
    }
}
?>
