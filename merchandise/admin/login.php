<?php
session_start();
require_once '../koneksi.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('CSRF token validation failed');
        }

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = $_POST['password'];

        if (!$username || !$password) {
            throw new Exception('Please fill in all fields');
        }

        $stmt = $conn->prepare("SELECT * FROM Admins WHERE username = ?");
        if (!$stmt) {
            throw new Exception('Database error: ' . $conn->error);
        }

        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            throw new Exception('Database error: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        
        if ($admin = $result->fetch_assoc()) {
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                header('Location: index.php');
                exit;
            }
        }
        throw new Exception('Invalid username or password');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - UTToraja Store</title>
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        .error { color: red; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        input { padding: 5px; width: 200px; }
    </style>
</head>
<body>
    <h2>Login Admin</h2>
    <?php if (isset($error)) echo "<div class='error'>" . htmlspecialchars(str_replace('Invalid username or password', 'Username atau password salah', $error)) . "</div>"; ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <label>Username:</label><br>
            <input type="text" name="username" required placeholder="Masukkan username">
        </div>
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" required placeholder="Masukkan password">
        </div>
        <button type="submit">Masuk</button>
    </form>
</body>
</html>
