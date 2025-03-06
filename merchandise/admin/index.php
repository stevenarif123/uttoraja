<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../koneksi.php';

// Fetch basic statistics
$result = $conn->query("SELECT COUNT(*) as total FROM Orders");
$totalOrders = $result->fetch_assoc()['total'];

$result = $conn->query("SELECT COUNT(*) as total FROM Products");
$totalProducts = $result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="products.php">Manage Products</a>
            <a href="orders.php">View Orders</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h2>
        
        <div class="dashboard-stats">
            <div>
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div>
                <h3>Total Products</h3>
                <p><?php echo $totalProducts; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
