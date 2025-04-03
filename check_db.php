<?php
// Database configuration
$host = "sql206.infinityfree.com";
$username = "if0_38659973";
$password = "lewinsky2612";

try {
    // Create connection
    $conn = new mysqli($host, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if database exists
    $dbResult = $conn->query("SHOW DATABASES LIKE 'gtbank_db'");
    if ($dbResult->num_rows > 0) {
        echo "Database 'gtbank_db' exists.<br>";
        
        // Select the database
        $conn->select_db("gtbank_db");
        
        // Check if users table exists
        $tableResult = $conn->query("SHOW TABLES LIKE 'users'");
        if ($tableResult->num_rows > 0) {
            echo "Table 'users' exists.<br>";
            
            // Check for sample user
            $userResult = $conn->query("SELECT * FROM users WHERE user_id = 'user123'");
            if ($userResult->num_rows > 0) {
                $user = $userResult->fetch_assoc();
                echo "Sample user exists:<br>";
                echo "User ID: " . $user['user_id'] . "<br>";
                echo "Name: " . $user['full_name'] . "<br>";
                echo "Email: " . $user['email'] . "<br>";
            } else {
                echo "Sample user does not exist.<br>";
            }
        } else {
            echo "Table 'users' does not exist.<br>";
        }
    } else {
        echo "Database 'gtbank_db' does not exist.<br>";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 