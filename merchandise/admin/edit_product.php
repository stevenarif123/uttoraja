<?php
session_start();
require_once '../koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$product = null;
$product_sizes = [];

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    
    if ($product_id) {
        $conn->begin_transaction();
        try {
            // Delete product (will cascade to product_sizes due to foreign key)
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            
            if ($stmt->execute()) {
                $conn->commit();
                header('Location: products.php');
                exit;
            } else {
                throw new Exception("Error deleting product");
            }
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
        }
    }
}

// Handle Edit Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete'])) {
    try {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $price_student = filter_input(INPUT_POST, 'price_student', FILTER_VALIDATE_FLOAT);
        $price_guest = filter_input(INPUT_POST, 'price_guest', FILTER_VALIDATE_FLOAT);
        
        $conn->begin_transaction();

        // Update product basic info
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price_student = ?, price_guest = ? WHERE id = ?");
        $stmt->bind_param("ssddi", $name, $description, $price_student, $price_guest, $product_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error updating product");
        }

        // Handle image upload if new image is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $image = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
                
                $stmt = $conn->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->bind_param("si", $image, $product_id);
                $stmt->execute();
            }
        }

        // Update sizes and stock
        $sizes = $_POST['sizes'] ?? [];
        $stocks = $_POST['stocks'] ?? [];
        
        // Delete existing sizes
        $stmt = $conn->prepare("DELETE FROM product_sizes WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        
        // Insert updated sizes and stock
        $stmt = $conn->prepare("INSERT INTO product_sizes (product_id, size, stock) VALUES (?, ?, ?)");
        foreach ($sizes as $index => $size) {
            if (!empty($size) && isset($stocks[$index]) && $stocks[$index] > 0) {
                $stmt->bind_param("isi", $product_id, $size, $stocks[$index]);
                if (!$stmt->execute()) {
                    throw new Exception("Error updating size and stock");
                }
            }
        }

        $conn->commit();
        $message = "Product updated successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch product data
if (isset($_GET['id'])) {
    $product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Fetch product sizes
    $stmt = $conn->prepare("SELECT * FROM product_sizes WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_sizes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

if (!$product) {
    header('Location: products.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        .form-group { margin-bottom: 15px; }
        .size-inputs { margin-top: 10px; }
        .current-image { max-width: 200px; margin: 10px 0; }
        .delete-btn { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <h2>Edit Product</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        
        <div class="form-group">
            <label>Product Name:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Description:</label><br>
            <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Student Price:</label><br>
            <input type="number" name="price_student" value="<?php echo $product['price_student']; ?>" min="0" required>
        </div>

        <div class="form-group">
            <label>Guest Price:</label><br>
            <input type="number" name="price_guest" value="<?php echo $product['price_guest']; ?>" min="0" required>
        </div>

        <div class="form-group">
            <label>Current Image:</label><br>
            <?php if ($product['image']): ?>
                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" class="current-image"><br>
            <?php endif; ?>
            <label>Update Image:</label><br>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label>Sizes and Stock:</label><br>
            <div class="size-inputs">
                <?php foreach ($product_sizes as $size): ?>
                    <div class="size-stock-pair">
                        <input type="text" name="sizes[]" value="<?php echo htmlspecialchars($size['size']); ?>">
                        <input type="number" name="stocks[]" value="<?php echo $size['stock']; ?>" min="0">
                    </div>
                <?php endforeach; ?>
                <button type="button" onclick="addSizeStockFields()">Add More Sizes</button>
            </div>
        </div>

        <button type="submit">Update Product</button>
    </form>

    <!-- Delete Form -->
    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin-top: 20px;">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <button type="submit" name="delete" class="delete-btn">Delete Product</button>
    </form>

    <script>
        function addSizeStockFields() {
            const container = document.querySelector('.size-inputs');
            const pair = document.createElement('div');
            pair.className = 'size-stock-pair';
            
            const sizeInput = document.createElement('input');
            sizeInput.type = 'text';
            sizeInput.name = 'sizes[]';
            sizeInput.placeholder = 'Size';
            
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
