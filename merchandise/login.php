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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Merchandise Store Login
                </h2>
            </div>
            
            <div class="px-8 py-6">
                <?php if ($error_message): ?>
                    <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="" class="space-y-6">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                        <input type="text" id="nim" name="nim" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                    
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                    
                    <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-md shadow-sm transition duration-200 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Login
                    </button>
                </form>
                
                <div class="mt-4 text-center relative">
                    <span class="px-2 bg-white text-sm text-gray-500 relative z-10">or</span>
                    <hr class="absolute top-1/2 left-0 w-full border-gray-200 -z-0">
                </div>
                
                <form method="post" action="" class="mt-4">
                    <button type="submit" name="guest" 
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-4 rounded-md shadow-sm transition duration-200 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        Login as Guest
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        By logging in, you agree to our 
                        <a href="#" class="text-blue-600 hover:text-blue-800">Terms of Service</a> and 
                        <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Need help? <a href="../kontak/index.php" class="text-blue-600 hover:text-blue-800">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
