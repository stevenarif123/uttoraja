<?php
session_start();
require_once '../koneksi.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $price_student = filter_input(INPUT_POST, 'price_student', FILTER_VALIDATE_FLOAT);
        $price_guest = filter_input(INPUT_POST, 'price_guest', FILTER_VALIDATE_FLOAT);
        
        // Handle size options and stock
        $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
        $stocks = isset($_POST['stocks']) ? $_POST['stocks'] : [];
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
            }
        }

        $conn->begin_transaction();

        // Insert product
        $stmt = $conn->prepare("INSERT INTO Products (name, description, price_student, price_guest, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdds", $name, $description, $price_student, $price_guest, $image);
        
        if (!$stmt->execute()) {
            throw new Exception("Error adding product");
        }
        
        $product_id = $conn->insert_id;

        // Insert sizes and stock
        $stmt = $conn->prepare("INSERT INTO product_sizes (product_id, size, stock) VALUES (?, ?, ?)");
        
        foreach ($sizes as $index => $size) {
            if (!empty($size) && isset($stocks[$index]) && $stocks[$index] > 0) {
                $stmt->bind_param("isi", $product_id, $size, $stocks[$index]);
                if (!$stmt->execute()) {
                    throw new Exception("Error adding size and stock");
                }
            }
        }

        $conn->commit();
        $message = "Product added successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        .form-group { margin-bottom: 15px; }
        .size-inputs { margin-top: 10px; }
        .size-stock-pair {
            margin-bottom: 10px;
        }
        .size-stock-pair input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Add New Product</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Name:</label><br>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Description:</label><br>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>Student Price:</label><br>
            <input type="number" name="price_student" min="0" required>
        </div>

        <div class="form-group">
            <label>Guest Price:</label><br>
            <input type="number" name="price_guest" min="0" required>
        </div>

        <div class="form-group">
            <label>Image:</label><br>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label>Sizes and Stock:</label><br>
            <div class="size-inputs">
                <div class="size-stock-pair">
                    <input type="text" name="sizes[]" placeholder="Size (e.g., S)">
                    <input type="number" name="stocks[]" placeholder="Stock" min="0">
                </div>
                <button type="button" onclick="addSizeStockFields()">Add More Sizes</button>
            </div>
        </div>

        <button type="submit">Add Product</button>
    </form>

    <script>
        function addSizeStockFields() {
            const container = document.querySelector('.size-inputs');
            const pair = document.createElement('div');
            pair.className = 'size-stock-pair';
            
            const sizeInput = document.createElement('input');
            sizeInput.type = 'text';
            sizeInput.name = 'sizes[]';
            sizeInput.placeholder = 'Size (e.g., S)';
            
            const stockInput = document.createElement('input');
            stockInput.type = 'number';
            stockInput.name = 'stocks[]';
            stockInput.placeholder = 'Stock';
            stockInput.min = '0';
            
            pair.appendChild(sizeInput);
            pair.appendChild(stockInput);
            container.insertBefore(pair, container.lastElementChild);
        }
    </script>
</body>
</html>
