<?php
session_start();

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Home - Waste Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      display: flex;
      margin: 0;
      height: 100vh;
    }
    .sidebar {
      width: 200px;
      background-color: #333;
      padding: 20px;
      color: white;
      height: 100vh;
      box-sizing: border-box;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 4px;
    }
    .sidebar a:hover {
      background-color: #45a049;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
      overflow-y: auto;
      box-sizing: border-box;
    }
    .container {
      max-width: 900px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    a.logout {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background-color: #f44336;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    a.logout:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="homeadmin.php">Home</a>
    <a href="manage-schedule.html">Manage Schedules</a>
  </div>
  <div class="content">
    <div class="container">
      <h3>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h3>
      <p>Manage waste collection schedules, track trucks.</p>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </div>
</body>
</html>
