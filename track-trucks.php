<?php
session_start();

// Optional: check admin login here
// if (!isset($_SESSION['admin_id'])) {
//   header("Location: login.php");
//   exit();
// }

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

// Handle form submission to add a truck
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $truckId = trim($_POST['truckId'] ?? '');
    $driver = trim($_POST['driver'] ?? '');
    $status = $_POST['status'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $nextPickup = trim($_POST['nextPickup'] ?? '') ?: '--';
    $available = 1;

    if (!$truckId || !$driver || !$status || !$location) {
        $error = "Please fill in all required fields.";
    } else {
        // Check if truck ID already exists
        $stmt = $conn->prepare("SELECT id FROM trucks WHERE truck_id = ?");
        $stmt->bind_param("s", $truckId);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Truck ID already exists.";
        } else {
            $stmt->close();
            // Insert new truck
            $stmt = $conn->prepare("INSERT INTO trucks (truck_id, driver, status, location, next_pickup, available) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $truckId, $driver, $status, $location, $nextPickup, $available);
            if ($stmt->execute()) {
                $success = "Truck added successfully.";
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Fetch all trucks
$result = $conn->query("SELECT * FROM trucks ORDER BY created_at DESC");
$trucks = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $trucks[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Track Trucks - JeevanSafa</title>
  <style>
    body {
      display: flex;
      min-height: 100vh;
      background-color: #eef5f1;
      font-family: Arial, sans-serif;
    }
    .sidebar {
      width: 240px;
      background-color: #2e7d32;
      padding: 20px;
      color: white;
    }
    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 12px 15px;
      border-radius: 5px;
      margin-bottom: 10px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: #1b5e20;
    }
    .main-content {
      flex: 1;
      padding: 40px;
    }
    .main-content h1 {
      color: #2e7d32;
      margin-bottom: 20px;
    }
    form {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      max-width: 600px;
    }
    form input, form select {
      padding: 10px;
      margin-bottom: 15px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    form button {
      padding: 10px 20px;
      background-color: #2e7d32;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #2e7d32;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .message {
      max-width: 600px;
      margin-bottom: 20px;
      padding: 10px;
      border-radius: 5px;
    }
    .error {
      background-color: #fed7d7;
      color: #c53030;
    }
    .success {
      background-color: #c6f6d5;
      color: #2f855a;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="homeadmin.html">🏠 Dashboard</a>
    <a href="manage-schedule.html">📅 Manage Schedules</a>
    <a href="track-trucks.php">🚛 Track Trucks</a>
    <a href="reports.html">📊 Reports</a>
    <a href="index.html">🔓 Logout</a>
  </div>

  <div class="main-content">
    <h1>Truck Tracking</h1>

    <?php if ($error): ?>
      <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" id="truckForm">
      <input type="text" name="truckId" placeholder="Truck ID (e.g., BA.2 KHA 4567)" required>
      <input type="text" name="driver" placeholder="Driver Name (e.g., Ram Bahadur Thapa)" required>
      <select name="status" required>
        <option value="">Select Status</option>
        <option value="Active">Active</option>
        <option value="Idle">Idle</option>
        <option value="Maintenance">Maintenance</option>
      </select>
      <input type="text" name="location" placeholder="Last Location (e.g., Dillibazar)" required>
      <input type="text" name="nextPickup" placeholder="Next Pickup Time (e.g., 10:30 AM)">
      <button type="submit">Add Truck</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Truck ID</th>
          <th>Driver</th>
          <th>Status</th>
          <th>Last Location</th>
          <th>Next Pickup</th>
          <th>Availability</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($trucks as $truck): ?>
          <tr>
            <td><?= htmlspecialchars($truck['truck_id']) ?></td>
            <td><?= htmlspecialchars($truck['driver']) ?></td>
            <td><?= htmlspecialchars($truck['status']) ?></td>
            <td><?= htmlspecialchars($truck['location']) ?></td>
            <td><?= htmlspecialchars($truck['next_pickup']) ?></td>
            <td><?= $truck['available'] ? "✅ Available" : "❌ Assigned" ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
