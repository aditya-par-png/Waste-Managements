<?php
session_start(); // Start the session to display error messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Waste Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      width: 90%;
      max-width: 900px;
      display: flex;
      justify-content: space-between;
    }
    .login-section {
      width: 45%;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .login-section h3 {
      text-align: center;
      color: #333;
    }
    .input-group {
      margin: 10px 0;
    }
    .input-group label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }
    .input-group input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .button:hover {
      background-color: #45a049;
    }
    .error {
      color: red;
      text-align: center;
    }
    .links {
      text-align: center;
      margin-top: 10px;
    }
    .links a {
      color: #4caf50;
      text-decoration: none;
    }
    .links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  
  <!-- User Login Section -->
  <div class="login-section">
    <h3>User Login</h3>
    <form action="login_process.php" method="POST">
      <div class="input-group">
        <label for="userUsername">Username or Email</label>
        <input type="text" id="userUsername" name="userUsername" required>
      </div>
      <div class="input-group">
        <label for="userPassword">Password</label>
        <input type="password" id="userPassword" name="userPassword" required>
      </div>
      <button type="submit" class="button" name="userLogin">Login as User</button>
      
      <!-- Display User Login Error -->
      <p class="error">
        <?php
          if (isset($_SESSION['user_error'])) {
            echo htmlspecialchars($_SESSION['user_error']);
            unset($_SESSION['user_error']); // Clear error after displaying
          }
        ?>
      </p>

      <div class="links">
        <a href="user_signup.html">Create an Account</a> | <a href="#">Forgot Password?</a>
      </div>
    </form>
  </div>

  <!-- Admin Login Section -->
  <div class="login-section">
    <h3>Admin Login</h3>
    <form action="login_process.php" method="POST">
      <div class="input-group">
        <label for="adminUsername">Username or Email</label>
        <input type="text" id="adminUsername" name="adminUsername" required>
      </div>
      <div class="input-group">
        <label for="adminPassword">Password</label>
        <input type="password" id="adminPassword" name="adminPassword" required>
      </div>
      <button type="submit" class="button" name="adminLogin">Login as Admin</button>

       <!-- Display Admin Login Error -->
       <p class="error">
         <?php
           if (isset($_SESSION['admin_error'])) {
             echo htmlspecialchars($_SESSION['admin_error']);
             unset($_SESSION['admin_error']); // Clear error after displaying
           }
         ?>
       </p>

       <div class="links">
         <a href="#">Forgot Password?</a>
       </div>
     </form>
   </div>

</div>

</body>
</html>
