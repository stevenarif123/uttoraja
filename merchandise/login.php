<?php
session_start();
include 'koneksi.php'; // Include database connection

// Debugging output
error_log("Session State: " . print_r($_SESSION, true) . "\n", 3, "../merchandise/error_log");

// Check if the user is already logged in or a guest
if (isset($_SESSION['nim']) || isset($_SESSION['guest'])) {
    header('Location: index.php');
    exit;
}

// Initialize variables
$nim = $tanggal_lahir = "";
$error_message = "";

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guest'])) {
        // Set a session variable for guest login
        $_SESSION['guest'] = true;
        error_log("Guest login initiated. Session State: " . print_r($_SESSION, true) . "\n", 3, "../merchandise/error_log");
        header('Location: index.php'); // Redirect to the main page
        exit;
    } else {
        $nim = $_POST['nim'];
        $tanggal_lahir = $_POST['tanggal_lahir'];

        // Prepare and execute the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE NIM = ? AND tanggal_lahir = ?");
        
        if ($stmt === false) {
            error_log("Prepare failed: " . $conn->error . "\n", 3, "../merchandise/error_log");
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $nim, $tanggal_lahir);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Data found
            $_SESSION['nim'] = $nim;
            header('Location: index.php');
            exit;
        } else {
            // Data not found
            $error_message = "NIM atau tanggal lahir salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Merchandise Sales</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="css/marketplace.css">
</head>
<body>
    <div class="marketplace-container">
        <div class="product-card">
            <div class="product-info">
                <h2>Login</h2>
                <?php if ($error_message): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form method="post" action="">
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required class="search-bar">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required class="search-bar">
                    <button type="submit" class="buy-button">Login</button>
                </form>
                <form method="post" action="">
                    <button type="submit" name="guest" class="buy-button">Login as Guest</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
