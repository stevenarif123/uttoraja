<?php
/**
 * Contact Form Handler
 * 
 * This script processes contact form submissions from the contact page,
 * validates the input, and sends an email notification to the admin.
 * 
 * @package UTTORAJA
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set response array
$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan dalam memproses permintaan Anda.',
    'errors' => []
];

// Process only if POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Get form data and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    
    // Validate inputs
    $errors = [];
    
    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Nama diperlukan';
    } elseif (strlen($name) < 2 || strlen($name) > 100) {
        $errors['name'] = 'Nama harus antara 2-100 karakter';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email diperlukan';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid';
    }
    
    // Validate subject
    if (empty($subject)) {
        $errors['subject'] = 'Subjek diperlukan';
    } elseif (strlen($subject) < 5 || strlen($subject) > 200) {
        $errors['subject'] = 'Subjek harus antara 5-200 karakter';
    }
    
    // Validate message
    if (empty($message)) {
        $errors['message'] = 'Pesan diperlukan';
    } elseif (strlen($message) < 10 || strlen($message) > 2000) {
        $errors['message'] = 'Pesan harus antara 10-2000 karakter';
    }
    
    // Validate phone (optional, but validate format if provided)
    if (!empty($phone)) {
        // Simple phone validation - adjust as needed for your requirements
        if (!preg_match('/^[0-9\+\-\s\(\)]{8,20}$/', $phone)) {
            $errors['phone'] = 'Format nomor telepon tidak valid';
        }
    }
    
    // Simple spam check - honeypot field (assuming 'website' is your honeypot field)
    $honeypot = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);
    if (!empty($honeypot)) {
        // This is likely a bot submission - silently exit with success message
        $response = [
            'status' => 'success',
            'message' => 'Terima kasih! Pesan Anda telah diterima.'
        ];
        echo json_encode($response);
        exit;
    }
    
    // If there are no validation errors, process the form
    if (empty($errors)) {
        // Log contact form submission
        $logMessage = date('Y-m-d H:i:s') . " - New contact from: $name ($email), Subject: $subject\n";
        $logFile = __DIR__ . '/../logs/contact_submissions.log';
        
        // Create logs directory if it doesn't exist
        if (!is_dir(__DIR__ . '/../logs')) {
            mkdir(__DIR__ . '/../logs', 0755, true);
        }
        
        // Write to log file
        file_put_contents($logFile, $logMessage, FILE_APPEND);
        
        // Prepare email to administrators
        $to = "saluttanatoraja@gmail.com"; // Replace with your admin email
        $emailSubject = "Kontak Web: $subject";
        
        // Create email headers
        $headers = "From: $name <$email>" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        
        // Compose email body
        $emailBody = "
        <html>
        <head>
            <title>Pesan Kontak Baru</title>
            <style>
                body {font-family: Arial, sans-serif; line-height: 1.6; color: #333;}
                .container {max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;}
                h2 {color: #0066cc; border-bottom: 1px solid #eee; padding-bottom: 10px;}
                .info {margin-bottom: 20px;}
                .label {font-weight: bold; margin-right: 10px;}
                .message-box {background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 20px;}
                .footer {margin-top: 30px; font-size: 12px; color: #777; text-align: center;}
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>PESAN KONTAK BARU</h2>
                <div class='info'>
                    <p><span class='label'>Nama:</span> $name</p>
                    <p><span class='label'>Email:</span> $email</p>
                    " . (!empty($phone) ? "<p><span class='label'>Telepon:</span> $phone</p>" : "") . "
                    <p><span class='label'>Subjek:</span> $subject</p>
                </div>
                <div class='message-box'>
                    <p><span class='label'>Pesan:</span></p>
                    <p>" . nl2br(htmlspecialchars($message)) . "</p>
                </div>
                <div class='footer'>
                    <p>Email ini dikirim secara otomatis dari formulir kontak website SALUT Tana Toraja.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Send email
        $mailSent = false;
        
        // Attempt to use PHPMailer if available
        $phpmailerPath = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($phpmailerPath)) {
            require $phpmailerPath;
            
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'saluttanatoraja@gmail.com'; // Replace with your email
                $mail->Password = 'your_app_password_here'; // Replace with your email password or app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom($email, $name);
                $mail->addAddress($to);
                $mail->Subject = $emailSubject;
                $mail->isHTML(true);
                $mail->Body = $emailBody;
                
                $mail->send();
                $mailSent = true;
            } catch (Exception $e) {
                // Log mail error
                error_log('PHPMailer Error: ' . $e->getMessage());
                
                // Fall back to mail()
                $mailSent = mail($to, $emailSubject, $emailBody, $headers);
            }
        } else {
            // Use regular PHP mail() function
            $mailSent = mail($to, $emailSubject, $emailBody, $headers);
        }
        
        // Also store in database if available
        try {
            require_once '../koneksi.php';
            
            if (isset($conn) && $conn) {
                $stmt = $conn->prepare("
                    INSERT INTO contact_messages (name, email, phone, subject, message, created_at)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                
                $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
                $stmt->execute();
                
                if ($stmt->affected_rows > 0) {
                    // Message saved to database successfully
                    $dbSuccess = true;
                }
                
                $stmt->close();
            }
        } catch (Exception $e) {
            // Log database error
            error_log('Database Error: ' . $e->getMessage());
        }
        
        // Set success response
        if ($mailSent) {
            $response = [
                'status' => 'success',
                'message' => 'Terima kasih! Pesan Anda telah diterima dan akan segera kami tanggapi.'
            ];
            
            // Store success message in session for page redirect scenarios
            $_SESSION['contact_form_success'] = true;
            $_SESSION['contact_form_message'] = $response['message'];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Maaf, terjadi masalah saat mengirim pesan. Silakan coba lagi nanti atau hubungi kami melalui telepon.'
            ];
            
            // Log mail sending failure
            error_log('Mail sending failed for contact from: ' . $email);
        }
    } else {
        // Set validation error response
        $response = [
            'status' => 'error',
            'message' => 'Silakan perbaiki kesalahan dalam formulir.',
            'errors' => $errors
        ];
    }
}

// Return JSON response for AJAX requests
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Redirect for non-AJAX form submissions
if ($response['status'] === 'success') {
    header("Location: thank_you.php");
} else {
    $_SESSION['contact_form_errors'] = $response['errors'];
    $_SESSION['contact_form_data'] = [
        'name' => $name ?? '',
        'email' => $email ?? '',
        'phone' => $phone ?? '',
        'subject' => $subject ?? '',
        'message' => $message ?? ''
    ];
    header("Location: kontak.php?status=error");
}
exit;
?>
