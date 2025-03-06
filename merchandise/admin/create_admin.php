<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Properly hash the password
    $name = $_POST['name'];
    
    $stmt = $conn->prepare("INSERT INTO Admins (username, password, name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $name);
    
    if ($stmt->execute()) {
        echo "Admin account created successfully!";
    } else {
        echo "Error creating admin account: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin Account</title>
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        .form-group { margin-bottom: 15px; }
        input { padding: 5px; width: 200px; }
    </style>
</head>
<body>
    <h2>Create New Admin Account</h2>
    <form method="POST">
        <div class="form-group">
            <label>Username:</label><br>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Full Name:</label><br>
            <input type="text" name="name" required>
        </div>
        <button type="submit">Create Admin</button>
    </form>
</body>
</html>
