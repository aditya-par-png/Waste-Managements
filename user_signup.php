<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Trim and capitalize first letters of first and last names
    $firstName = ucfirst(strtolower(trim($_POST["firstName"])));
    $lastName = ucfirst(strtolower(trim($_POST["lastName"])));
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    // Validate password length and uppercase letter
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    }
    elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "Password must contain at least one uppercase letter.";
    }
    // Check passwords match
    elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            // Insert new user (plain password as requested)
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
            if ($stmt->execute()) {
                $success = "Signup successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Signup failed. Please try again.";
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Marshall Waste Management - Sign Up</title>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <style>
    /* Your existing CSS here */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Arial', sans-serif; }
    body { background-color: #d4f8df; overflow-x: hidden; }
    .navbar { background-color: #2e7d32; display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; flex-wrap: wrap; animation: fadeIn 1s forwards; }
    .navbar .logo { display: flex; align-items: center; }
    .navbar img { width: 50px; margin-right: 10px; }
    .navbar h1 { color: #fff; font-size: 22px; }
    .nav-links { list-style: none; display: flex; gap: 20px; }
    .nav-links a { color: #fff; text-decoration: none; font-size: 16px; padding: 8px 12px; transition: background-color 0.3s; }
    .nav-links a:hover { background-color: #1b5e20; border-radius: 5px; }
    .main-content { display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 250px); padding: 20px; flex-direction: row; gap: 40px; animation: fadeIn 2s forwards; }
    .animation-container { flex: 1; max-width: 500px; display: flex; justify-content: flex-start; margin-right: 200px; }
    .signup-box { width: 100%; max-width: 400px; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: slideUp 1s forwards; }
    .signup-box h2 { text-align: center; margin-bottom: 20px; color: #333; }
    .input-group { margin-bottom: 15px; }
    .input-group label { display: block; margin-bottom: 5px; color: #555; }
    .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .signup-box button { width: 100%; padding: 10px; background-color: #2e7d32; color: #fff; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; transition: background-color 0.3s; }
    .signup-box button:hover { background-color: #1b5e20; }
    .signup-box .links { margin-top: 15px; text-align: center; }
    .signup-box .links a { display: block; color: #2e7d32; text-decoration: none; margin-top: 8px; font-size: 14px; }
    .signup-box .links a:hover { text-decoration: underline; }
    .slogan { text-align: center; font-weight: bold; font-size: 18px; color: #2e7d32; margin-top: 30px; }
    .error-message { color: #c0392b; text-align: center; margin-bottom: 10px; font-size: 15px; }
    .success-message { color: #2e7d32; text-align: center; margin-bottom: 10px; font-size: 15px; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); } to { transform: translateY(0); } }
    @media (max-width: 768px) {
      .main-content { flex-direction: column; text-align: center; }
      .animation-container { margin: 0 auto; }
      .signup-box { margin-top: 20px; }
      .nav-links { flex-direction: column; align-items: center; width: 100%; padding-top: 10px; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <div class="logo">
      <img src="97b6d99e-4463-47ed-afea-810bc603a85b.jpg" alt="Marshall Logo" />
      <h1>MARSHALL</h1>
    </div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Help</a></li>
    </ul>
  </nav>

  <!-- Signup Form + Animation -->
  <div class="main-content">
    <div class="animation-container">
      <lottie-player src="login.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
    </div>

    <div class="signup-box">
      <h2>Create Account</h2>
      <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (!empty($success)): ?>
        <div class="success-message"><?= $success ?></div>
      <?php endif; ?>
      <form id="signUpForm" method="POST" autocomplete="off">
        <div class="input-group">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" required />
        </div>
        <div class="input-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" required />
        </div>
        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="input-group">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required />
        </div>
        <button type="submit">Sign Up</button>
      </form>
      <div class="links">
        <p>Already registered? <a href="login.php">Login here</a></p>
      </div>
    </div>
  </div>

  <!-- Slogan -->
  <div class="slogan">
    <p>Reduce, Reuse, Recycle: Let's Keep Kathmandu Clean</p>
  </div>
</body>
</html>

