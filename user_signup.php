<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Sign Up - Waste Management</title>
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
      width: 100%;
      max-width: 400px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h2 {
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
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .error {
      color: red;
    }
    .success {
      color: green;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>User Sign Up</h2>

  <!-- Display error or success messages -->
  <?php
  if (isset($_SESSION['signup_error'])) {
      echo '<p class="message error">' . htmlspecialchars($_SESSION['signup_error']) . '</p>';
      unset($_SESSION['signup_error']);
  }
  if (isset($_SESSION['signup_success'])) {
      echo '<p class="message success">' . htmlspecialchars($_SESSION['signup_success']) . '</p>';
      unset($_SESSION['signup_success']);
  }
  ?>

  <form id="signUpForm" action="user_signup_process.php" method="POST">
    <div class="input-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required />
    </div>
    <div class="input-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />
    </div>
    <div class="input-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />
    </div>
    <button type="submit" class="button">Sign Up</button>
  </form>

  <div class="links">
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

</body>
</html>
