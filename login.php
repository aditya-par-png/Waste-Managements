<<<<<<< HEAD
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Error messages
$userError = "";
$adminError = "";

// Handle User Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['userLogin'])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Updated query: select first_name and last_name instead of full_name
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If you use hashed passwords, replace the following line with password_verify()
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        header("Location: home.php");
        exit();
    } else {
        $userError = "Invalid user credentials.";
    }
}

// Handle Admin Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['adminLogin'])) {
    $email = trim($_POST["adminEmail"]);
    $password = $_POST["adminPassword"];

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // If you use hashed passwords, replace the following line with password_verify()
    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: homeadmin.php");
        exit();
    } else {
        $adminError = "Invalid admin credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jeevansafa Waste Management - Login</title>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <style>
    /* Your CSS from original file */
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
    .login-container { flex: 1; max-width: 400px; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: slideUp 1s forwards; }
    .login-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
    .input-group { margin-bottom: 15px; }
    .input-group label { display: block; margin-bottom: 5px; color: #555; }
    .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .login-container button { width: 100%; padding: 10px; background-color: #2e7d32; color: #fff; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; transition: background-color 0.3s; }
    .login-container button:hover { background-color: #1b5e20; }
    .login-container .links { margin-top: 15px; text-align: center; }
    .login-container .links a { display: block; color: #2e7d32; text-decoration: none; margin-top: 8px; font-size: 14px; }
    .login-container .links a:hover { text-decoration: underline; }
    .switch-button { background-color: transparent; border: none; color: #2e7d32; font-size: 14px; margin-top: 10px; cursor: pointer; text-decoration: underline; }
    #adminLoginBox { display: none; }
    .error-message { color: #c0392b; text-align: center; margin-bottom: 10px; font-size: 15px; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); } to { transform: translateY(0); } }
    @media (max-width: 768px) {
      .nav-links { flex-direction: column; align-items: center; width: 100%; padding-top: 10px; }
      .main-content { flex-direction: column; height: auto; }
      .animation-container, .login-container { max-width: 100%; }
      .login-container { padding: 20px; }
    }
    .wave-svg { position: relative; width: 100%; height: 100px; overflow: hidden; margin-top: 40px; }
    .wave-svg svg { position: absolute; top: 0; left: 0; width: 200%; height: 100px; animation: waveMove 6s linear infinite; }
    @keyframes waveMove { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    footer { background-color: #2e7d32; color: white; text-align: center; padding: 20px 0; }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <div class="logo">
      <img src="97b6d99e-4463-47ed-afea-810bc603a85b.jpg" alt="Marshall Logo" />
      <h1>JeevanSafa</h1>
    </div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Help</a></li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Animation -->
    <div class="animation-container">
      <lottie-player src="login.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
    </div>

    <!-- User Login -->
    <div class="login-container" id="userLoginBox" style="<?php if (!empty($adminError)) echo 'display:none;'; ?>">
      <h2>User Login</h2>
      <?php if (!empty($userError)): ?>
        <div class="error-message"><?php echo htmlspecialchars($userError); ?></div>
      <?php endif; ?>
      <form id="userLoginForm" method="POST" autocomplete="off">
        <div class="input-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" name="userLogin">Login</button>
        <div class="links">
          <a href="#">Forgot Password?</a>
          <a href="user_signup.php">Create a New Account</a>
        </div>
      </form>
      <button class="switch-button" onclick="showAdminLogin()">Login as Admin</button>
    </div>

    <!-- Admin Login -->
    <div class="login-container" id="adminLoginBox" style="<?php if (empty($adminError)) echo 'display:none;'; ?>">
      <h2>Admin Login</h2>
      <?php if (!empty($adminError)): ?>
        <div class="error-message"><?php echo htmlspecialchars($adminError); ?></div>
      <?php endif; ?>
      <form id="adminLoginForm" method="POST" autocomplete="off">
        <div class="input-group">
          <label for="adminEmail">Admin Email:</label>
          <input type="email" id="adminEmail" name="adminEmail" required />
        </div>
        <div class="input-group">
          <label for="adminPassword">Password:</label>
          <input type="password" id="adminPassword" name="adminPassword" required />
        </div>
        <button type="submit" name="adminLogin">Login as Admin</button>
        <div class="links">
          <a href="#" onclick="hideAdminLogin();return false;">Back to User Login</a>
        </div>
      </form>
    </div>
  </div>

  <!-- SVG Wave -->
  <div class="wave-svg">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M0,0 C300,100 900,0 1200,100 L1200,0 L0,0 Z" fill="#2e7d32" opacity="0.5"></path>
    </svg>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 JeevanSafa Waste Management. All rights reserved.</p>
  </footer>

  <!-- Script -->
  <script>
    function showAdminLogin() {
      document.getElementById("userLoginBox").style.display = "none";
      document.getElementById("adminLoginBox").style.display = "block";
    }
    function hideAdminLogin() {
      document.getElementById("adminLoginBox").style.display = "none";
      document.getElementById("userLoginBox").style.display = "block";
    }
    // Toggle on error
    <?php if (!empty($adminError)): ?>
      showAdminLogin();
    <?php endif; ?>
  </script>
</body>
</html>
<?php
$conn->close();
?>
=======
<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Error messages
$userError = "";
$adminError = "";

// Handle User Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['userLogin'])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Updated query: select first_name, last_name, and password
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and verify hashed password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        header("Location: home.php");
        exit();
    } else {
        $userError = "Invalid user credentials.";
    }
}

// Handle Admin Login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['adminLogin'])) {
    $email = trim($_POST["adminEmail"]);
    $password = $_POST["adminPassword"];

    // Query to get the admin credentials
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if admin exists and verify plain text password
    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header("Location: homeadmin.php");
        exit();
    } else {
        $adminError = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jeevansafa Waste Management - Login</title>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <style>
    /* Your CSS from original file */
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
    .login-container { flex: 1; max-width: 400px; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: slideUp 1s forwards; }
    .login-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
    .input-group { margin-bottom: 15px; }
    .input-group label { display: block; margin-bottom: 5px; color: #555; }
    .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .login-container button { width: 100%; padding: 10px; background-color: #2e7d32; color: #fff; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; transition: background-color 0.3s; }
    .login-container button:hover { background-color: #1b5e20; }
    .login-container .links { margin-top: 15px; text-align: center; }
    .login-container .links a { display: block; color: #2e7d32; text-decoration: none; margin-top: 8px; font-size: 14px; }
    .login-container .links a:hover { text-decoration: underline; }
    .switch-button { background-color: transparent; border: none; color: #2e7d32; font-size: 14px; margin-top: 10px; cursor: pointer; text-decoration: underline; }
    #adminLoginBox { display: none; }
    .error-message { color: #c0392b; text-align: center; margin-bottom: 10px; font-size: 15px; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); } to { transform: translateY(0); } }
    @media (max-width: 768px) {
      .nav-links { flex-direction: column; align-items: center; width: 100%; padding-top: 10px; }
      .main-content { flex-direction: column; height: auto; }
      .animation-container, .login-container { max-width: 100%; }
      .login-container { padding: 20px; }
    }
    .wave-svg { position: relative; width: 100%; height: 100px; overflow: hidden; margin-top: 40px; }
    .wave-svg svg { position: absolute; top: 0; left: 0; width: 200%; height: 100px; animation: waveMove 6s linear infinite; }
    @keyframes waveMove { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    footer { background-color: #2e7d32; color: white; text-align: center; padding: 20px 0; }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav class="navbar">
    <div class="logo">
      <img src="97b6d99e-4463-47ed-afea-810bc603a85b.jpg" alt="Marshall Logo" />
      <h1>JeevanSafa</h1>
    </div>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="#">Help</a></li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Animation -->
    <div class="animation-container">
      <lottie-player src="login.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay></lottie-player>
    </div>

    <!-- User Login -->
    <div class="login-container" id="userLoginBox" style="<?php if (!empty($adminError)) echo 'display:none;'; ?>">
      <h2>User Login</h2>
      <?php if (!empty($userError)): ?>
        <div class="error-message"><?php echo htmlspecialchars($userError); ?></div>
      <?php endif; ?>
      <form id="userLoginForm" method="POST" autocomplete="off">
        <div class="input-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div class="input-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" name="userLogin">Login</button>
        <div class="links">
          <a href="forget_password.php">Forgot Password?</a>
          <a href="user_signup.php">Create a New Account</a>
        </div>
      </form>
      <button class="switch-button" onclick="showAdminLogin()">Login as Admin</button>
    </div>

    <!-- Admin Login -->
    <div class="login-container" id="adminLoginBox" style="<?php if (empty($adminError)) echo 'display:none;'; ?>">
      <h2>Admin Login</h2>
      <?php if (!empty($adminError)): ?>
        <div class="error-message"><?php echo htmlspecialchars($adminError); ?></div>
      <?php endif; ?>
      <form id="adminLoginForm" method="POST" autocomplete="off">
        <div class="input-group">
          <label for="adminEmail">Email:</label>
          <input type="email" id="adminEmail" name="adminEmail" required />
        </div>
        <div class="input-group">
          <label for="adminPassword">Password:</label>
          <input type="password" id="adminPassword" name="adminPassword" required />
        </div>
        <button type="submit" name="adminLogin">Login</button>
        <div class="links">
          <a href="forget_password.php">Forgot Password?</a>
        </div>
      </form>
      <button class="switch-button" onclick="showUserLogin()">Login as User</button>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 JeevanSafa Waste Management</p>
  </footer>

  <script>
    function showAdminLogin() {
      document.getElementById('userLoginBox').style.display = 'none';
      document.getElementById('adminLoginBox').style.display = 'block';
    }

    function showUserLogin() {
      document.getElementById('adminLoginBox').style.display = 'none';
      document.getElementById('userLoginBox').style.display = 'block';
    }
  </script>

</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
