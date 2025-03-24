<?php
/**
 * Database Connection Test
 * 
 * This script tests the database connection and displays information about the tables
 * being used by the module tracking system
 */

echo "<h1>Database Connection Test</h1>";

try {
    // Include database connection
    require_once '../koneksi.php';
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color:green;'>✅ Database connection successful!</p>";
    
    // Check if tables exist
    $tables = ["mahasiswa", "pengiriman_modul"];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p>✅ Table '$table' exists</p>";
            
            // Count records
            $count = $conn->query("SELECT COUNT(*) as count FROM $table");
            $row = $count->fetch_assoc();
            echo "<p>➡️ Table '$table' has " . $row['count'] . " records</p>";
            
            // Show table structure
            echo "<h3>Table Structure for '$table':</h3>";
            $structure = $conn->query("DESCRIBE $table");
            if ($structure->num_rows > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                while ($row = $structure->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        echo "<td>" . ($value ?? "NULL") . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            // Show sample data
            echo "<h3>Sample Data for '$table':</h3>";
            $data = $conn->query("SELECT * FROM $table LIMIT 5");
            if ($data->num_rows > 0) {
                echo "<table border='1' cellpadding='5' cellspacing='0'>";
                
                // Header row
                $firstRow = $data->fetch_assoc();
                echo "<tr>";
                foreach ($firstRow as $key => $value) {
                    echo "<th>" . $key . "</th>";
                }
                echo "</tr>";
                
                // Display the first row
                echo "<tr>";
                foreach ($firstRow as $value) {
                    echo "<td>" . ($value ?? "NULL") . "</td>";
                }
                echo "</tr>";
                
                // Display remaining rows
                while ($row = $data->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . ($value ?? "NULL") . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data in table '$table'</p>";
            }
            
        } else {
            echo "<p style='color:red;'>❌ Table '$table' does not exist</p>";
        }
        echo "<hr>";
    }
    
    echo "<p><a href='setup-module-db.php' style='display:inline-block; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px;'>Setup/Initialize Database</a> &nbsp; <a href='modul.php' style='display:inline-block; padding:10px 20px; background:#2196F3; color:white; text-decoration:none; border-radius:5px;'>Go to Module Page</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ ERROR: " . $e->getMessage() . "</p>";
    echo "<p>Make sure the koneksi.php file exists and contains valid database credentials.</p>";
}
?>
