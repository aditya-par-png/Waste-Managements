<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Sign Up - Waste Management</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 400px; width: 100%; }
    h2 { text-align: center; color: #333; }
    .input-group { margin: 10px 0; }
    label { display: block; margin-bottom: 5px; color: #555; }
    input { width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; }
    button { width: 100%; padding: 10px; font-size: 16px; background: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #45a049; }
    .message { text-align: center; margin-bottom: 15px; font-weight: bold; }
    .error { color: red; }
    .success { color: green; }
    .links { text-align: center; margin-top: 10px; }
    .links a { color: #4caf50; text-decoration: none; }
    .links a:hover { text-decoration: underline; }
  </style>
</head>
<body>

<div class="container">
  <h2>Admin Sign Up</h2>

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

  <form action="admin_signup_process.php" method="POST">
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
    <button type="submit">Sign Up</button>
  </form>

  <div class="links">
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

</body>
</html>
