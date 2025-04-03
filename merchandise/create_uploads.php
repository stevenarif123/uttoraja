<?php
// Create uploads directory if it doesn't exist
$uploadsDir = "./uploads";
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
    echo "✅ Uploads directory created successfully at: " . realpath($uploadsDir);
} else {
    echo "✅ Uploads directory already exists at: " . realpath($uploadsDir);
}
?>
