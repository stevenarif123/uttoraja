<?php
// Basic image serving without authentication
if (isset($_GET['img'])) {
    $imagePath = $_GET['img'];
    
    // Only allow images from assets/img directory
    if (strpos($imagePath, 'assets/img/') === 0) {
        $fullPath = __DIR__ . '/' . $imagePath;
        
        // Check if file exists and is an image
        if (file_exists($fullPath) && getimagesize($fullPath)) {
            // Get MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $fullPath);
            finfo_close($finfo);
            
            // Only allow common image types
            if (in_array($mime_type, ['image/jpeg', 'image/png', 'image/gif'])) {
                header('Content-Type: ' . $mime_type);
                header('Content-Length: ' . filesize($fullPath));
                header('Cache-Control: public, max-age=31536000');
                readfile($fullPath);
                exit;
            }
        }
    }
}

// Return 404 if image not found or invalid
header('HTTP/1.0 404 Not Found');
exit('Image not found');