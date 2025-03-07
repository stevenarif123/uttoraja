# Secure Image Serving Guide

## Overview
The `serve-image.php` script provides a secure way to serve images to authenticated users only.

## Requirements
- User must be authenticated (have valid session)
- Images must be in either `assets/img` or `uploads` directories

## Usage Example

### 1. Authentication
Make sure user is logged in and has `$_SESSION['authenticated'] = true` set.

```php
session_start();
$_SESSION['authenticated'] = true; // Set this after successful login
```

### 2. Image URL Format
Use the following format to serve images:
```html
<img src="serve-image.php?img=assets/img/example.jpg">
<!-- OR -->
<img src="serve-image.php?img=uploads/user-photo.png">
```

### 3. Supported Directories
Only images in these directories can be served:
- `assets/img/`
- `uploads/`

### Security Notes
- Direct access to image files should be prevented using .htaccess
- Only authenticated users can access images
- Path traversal attacks are prevented
- Only valid image files are served

### Headers Set by Script
- Content-Type: Automatically detected from image
- Content-Length: File size
- Cache-Control: public, max-age=31536000 (1 year caching)
