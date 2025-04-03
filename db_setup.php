<?php
// Database configuration
$host = "sql206.infinityfree.com";
$username = "if0_38659973";
$password = "lewinsky2612";

// Create connection without selecting a database
$conn = mysqli_connect($host, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected to MySQL server successfully.<br>";
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS gtbank_db";
if (mysqli_query($conn, $sql)) {
    echo "Database created or already exists successfully.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
if (mysqli_select_db($conn, "gtbank_db")) {
    echo "Selected database gtbank_db successfully.<br>";
} else {
    echo "Error selecting database: " . mysqli_error($conn) . "<br>";
    die("Could not select database.");
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    account_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Users table created successfully.<br>";
} else {
    echo "Error creating users table: " . mysqli_error($conn) . "<br>";
}

// Insert sample user for testing
$sample_user_id = "user123";
$sample_password = password_hash("12345", PASSWORD_DEFAULT); // Using secure password hashing
$sample_name = "John Doe";
$sample_email = "john.doe@example.com";
$sample_account = "0123456789";

// Check if user already exists
$check_sql = "SELECT * FROM users WHERE user_id = '$sample_user_id'";
$result = mysqli_query($conn, $check_sql);

if (!$result) {
    echo "Error checking for existing user: " . mysqli_error($conn) . "<br>";
} else {
    if (mysqli_num_rows($result) == 0) {
        // User doesn't exist, insert sample user
        $insert_sql = "INSERT INTO users (user_id, password, full_name, email, account_number) 
                      VALUES ('$sample_user_id', '$sample_password', '$sample_name', '$sample_email', '$sample_account')";
        
        if (mysqli_query($conn, $insert_sql)) {
            echo "Sample user created successfully.<br>";
            echo "User ID: $sample_user_id<br>";
            echo "Password: 12345<br>";
        } else {
            echo "Error creating sample user: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "Sample user already exists.<br>";
    }
}

mysqli_close($conn);
echo "Database setup completed.";
?> 