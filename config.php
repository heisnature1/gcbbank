<?php
// Database configuration
$host = "sql206.infinityfree.com";
$username = "if0_38659973";
$password = "lewinsky2612";
$database = "if0_38659973_gcbbank";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?> 