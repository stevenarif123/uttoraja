<?php
// Include the database connection file
include 'koneksi.php';

// Start output buffering to capture the HTML content
ob_start();

// Check if a student is selected via POST method
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare the SQL query to select the student
    $email_safe = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT Email, Password, NamaLengkap FROM mahasiswabaru20242 WHERE Email = '$email_safe'";
    $query_result = mysqli_query($conn, $sql);

    if (!$query_result) {
        die('<p>SQL query error: ' . mysqli_error($conn) . '</p>');
    }

    if (mysqli_num_rows($query_result) > 0) {
        $user = mysqli_fetch_assoc($query_result);
        // Extract email, password, and name
        $email = $user['Email'];
        $password = $user['Password'];
        $name = $user['NamaLengkap'];

        // First Request: Obtain the Bearer Token
        $url = 'https://api-sia.ut.ac.id/backend-sia/api/graphql';

        $data = array(
            'query' => '
                mutation {
                    signInUser(email: "' . $email . '", password: "' . $password . '") {
                        access_token
                    }
                }
            ',
            'variables' => new stdClass()
        );

        $json_data = json_encode($data);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: api-sia.ut.ac.id',
            'Content-Type: application/json',
            'Accept-Language: en-GB,en;q=0.9',
            'Accept: application/json, text/plain, */*',
            'Origin: https://admisi-sia.ut.ac.id',
            'Referer: https://admisi-sia.ut.ac.id/',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Sec-Ch-Ua: "Not;A=Brand";v="24", "Chromium";v="128"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Sec-Fetch-Site: same-site',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: empty',
            'Accept-Encoding: gzip, deflate, br',
            'Priority: u=1, i'
        ));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo '<p>Error for user ' . htmlspecialchars($email) . ': ' . curl_error($ch) . '</p>';
            exit;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code !== 200) {
            echo '<p>HTTP error ' . $http_code . ' for user ' . htmlspecialchars($email) . '</p>';
            echo '<p>Response:</p>';
            echo '<pre>' . $response . '</pre>';
            exit;
        }

        curl_close($ch);

        // Decode the response to get the access token
        $result_data = json_decode($response, true);

        if (isset($result_data['data']['signInUser']['access_token'])) {
            $access_token = $result_data['data']['signInUser']['access_token'];
        } else {
            echo '<p>Access token not found for user ' . htmlspecialchars($email) . '.</p>';
            exit;
        }

        // Second Request: Access the Student KTPU page
        $url2 = 'https://api-sia.ut.ac.id/global-rest/api/student/ktpu-all?token=' . $access_token;

        $ch2 = curl_init($url2);

        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
            'Host: api-sia.ut.ac.id',
            'Authorization: Bearer ' . $access_token,
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: id,en-US;q=0.9,en;q=0.8',
            'Origin: https://admisi-sia.ut.ac.id',
            'Referer: https://admisi-sia.ut.ac.id/',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Sec-Ch-Ua: "Microsoft Edge";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Sec-Fetch-Site: same-site',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: document',
            'Accept-Encoding: gzip, deflate, br',
            'Priority: u=1, i'
        ));
        // Allow redirects
        curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
        // Enable automatic decompression
        curl_setopt($ch2, CURLOPT_ENCODING, '');

        $response2 = curl_exec($ch2);

        if (curl_errno($ch2)) {
            echo '<p>Error for user ' . htmlspecialchars($email) . ': ' . curl_error($ch2) . '</p>';
            exit;
        }

        $http_code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        if ($http_code2 !== 200) {
            echo '<p>HTTP error ' . $http_code2 . ' for user ' . htmlspecialchars($email) . '</p>';
            echo '<p>Response:</p>';
            echo '<pre>' . $response2 . '</pre>';
            exit;
        }

        // Now, run the logout mutation
        $logout_data = array(
            'query' => '
                mutation {
                    logout
                }
            ',
            'variables' => new stdClass()
        );

        $logout_json_data = json_encode($logout_data);

        $ch_logout = curl_init($url);

        curl_setopt($ch_logout, CURLOPT_POST, true);
        curl_setopt($ch_logout, CURLOPT_POSTFIELDS, $logout_json_data);
        curl_setopt($ch_logout, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_logout, CURLOPT_HTTPHEADER, array(
            'Host: api-sia.ut.ac.id',
            'Content-Type: application/json',
            'Accept-Language: en-GB,en;q=0.9',
            'Accept: application/json, text/plain, */*',
            'Authorization: Bearer ' . $access_token,
            'Origin: https://admisi-sia.ut.ac.id',
            'Referer: https://admisi-sia.ut.ac.id/',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Sec-Ch-Ua: "Not;A=Brand";v="24", "Chromium";v="128"',
            'Sec-Ch-Ua-Mobile: ?0',
            'Sec-Ch-Ua-Platform: "Windows"',
            'Sec-Fetch-Site: same-site',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: empty',
            'Accept-Encoding: gzip, deflate, br',
            'Priority: u=1, i'
        ));

        $logout_response = curl_exec($ch_logout);

        if (curl_errno($ch_logout)) {
            echo '<p>Error during logout for user ' . htmlspecialchars($email) . ': ' . curl_error($ch_logout) . '</p>';
            exit;
        }

        $http_code_logout = curl_getinfo($ch_logout, CURLINFO_HTTP_CODE);

        if ($http_code_logout !== 200) {
            echo '<p>HTTP error ' . $http_code_logout . ' during logout for user ' . htmlspecialchars($email) . '</p>';
            echo '<p>Response:</p>';
            echo '<pre>' . $logout_response . '</pre>';
            exit;
        }

        curl_close($ch_logout);
        curl_close($ch2);

        // Output the response directly
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print KTPU - <?php echo htmlspecialchars($name); ?></title>
            <meta charset="UTF-8">
            <style>
                @page {
                    size: A4;
                    margin: 0;
                }
                @media print {
                    html, body {
                        width: 210mm;
                        height: 297mm;
                        margin: 0;
                        padding: 0;
                    }
                    .page {
                        page-break-after: always;
                    }
                }
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                }
                .page {
                    width: 210mm;
                    min-height: 297mm;
                    margin: 0 auto;
                    position: relative;
                    overflow: hidden;
                }
                .content {
                    padding: 20mm;
                }
                /* Ensure content overflows properly */
                .content > * {
                    page-break-inside: avoid;
                }
            </style>
        </head>
        <body onload="window.print();">
            <div class="page">
                <div class="content">
                    <?php
                    // Embed the KTPU content
                    echo $response2;
                    ?>
                </div>
            </div>
        </body>
        </html>
        <?php

    } else {
        echo '<p>No student found with the specified email.</p>';
    }

    // Close the database connection
    mysqli_close($conn);

    // Get the HTML content
    $htmlContent = ob_get_clean();

    // Output the HTML content
    echo $htmlContent;

    exit;

} else {
    // No student selected, display the list
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Select Student</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            h1 {
                text-align: center;
                margin-bottom: 30px;
            }
            .student-list {
                margin-bottom: 20px;
            }
            .action-button {
                text-align: center;
            }
            .table th, .table td {
                vertical-align: middle !important;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>Select Student to Print KTPU</h1>
        <div class="student-list">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all students from the database
                    $sql = "SELECT Email, NamaLengkap FROM mahasiswabaru20242";
                    $result_students = mysqli_query($conn, $sql);

                    if ($result_students && mysqli_num_rows($result_students) > 0) {
                        $counter = 1;
                        while ($student = mysqli_fetch_assoc($result_students)) {
                            $email = htmlspecialchars($student['Email']);
                            $name = htmlspecialchars($student['NamaLengkap']);
                            echo '<tr>';
                            echo '<th scope="row">' . $counter . '</th>';
                            echo '<td>' . $email . '</td>';
                            echo '<td>' . $name . '</td>';
                            echo '<td class="action-button">';
                            echo '<form method="post" action="" target="_blank">';
                            echo '<input type="hidden" name="email" value="' . $email . '">';
                            echo '<button type="submit" class="btn btn-primary">PRINT KTPU</button>';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                            $counter++;
                        }
                    } else {
                        echo '<tr><td colspan="4">No students found in the database.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies (Optional, for Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php

    // Close the database connection
    mysqli_close($conn);

    // Get the HTML content
    $htmlContent = ob_get_clean();

    // Output the HTML content
    echo $htmlContent;

    exit;
}
?>
