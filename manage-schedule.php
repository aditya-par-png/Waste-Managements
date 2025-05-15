<<<<<<< HEAD
<?php
session_start();
// TODO: Add your admin authentication check here
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit();
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle assignment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $requestId = intval($_POST['request_id']);
    $driver = trim($_POST['driver'] ?? '');
    $vehicle = trim($_POST['vehicle'] ?? '');

    if ($driver !== '' && $vehicle !== '') {
        $stmt = $conn->prepare("UPDATE pickup_requests SET driver=?, vehicle=?, status='Assigned' WHERE id=?");
        $stmt->bind_param("ssi", $driver, $vehicle, $requestId);
        if ($stmt->execute()) {
            $stmt->close();
            // Redirect to reports.php after successful assignment
            header("Location: reports.php");
            exit();
        } else {
            $message = "Database error: " . $stmt->error;
            $stmt->close();
        }
    } else {
        $message = "Please fill all assignment fields.";
    }
}

// Fetch pickup requests
$requests = [];
$result = $conn->query("SELECT * FROM pickup_requests ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

// Fetch distinct drivers from trucks table
$drivers = [];
$driverResult = $conn->query("SELECT DISTINCT driver FROM trucks WHERE driver <> '' ORDER BY driver");
if ($driverResult) {
    while ($row = $driverResult->fetch_assoc()) {
        $drivers[] = $row['driver'];
    }
}

// Fetch trucks (truck_ids)
$trucks = [];
$truckResult = $conn->query("SELECT truck_id FROM trucks ORDER BY truck_id");
if ($truckResult) {
    while ($row = $truckResult->fetch_assoc()) {
        $trucks[] = $row['truck_id'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Schedules - JeevanSafa</title>
  <style>
    body { display: flex; min-height: 100vh; background-color: #eef5f1; font-family: Arial, sans-serif; }
    .sidebar { width: 240px; background-color: #2e7d32; padding: 20px; color: white; }
    .sidebar h2 { text-align: center; margin-bottom: 30px; }
    .sidebar a { display: block; color: white; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 10px; transition: background 0.3s; }
    .sidebar a:hover { background-color: #1b5e20; }
    .main-content { flex: 1; padding: 40px; }
    .container { background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); }
    h3 { margin-top: 0; color: #2e7d32; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    .button { padding: 10px 16px; background-color: #2e7d32; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .button:hover { background-color: #1b5e20; }
    select { padding: 6px; width: 90%; }
    .message { margin-bottom: 15px; color: green; font-weight: bold; }
    form { margin: 0; }
  </style>
</head>
<body>

<div class="sidebar">
  <h2>Admin Panel</h2>
  <a href="homeadmin.html">🏠 Dashboard</a>
  <a href="manage-schedule.php">📅 Manage Schedules</a>
  <a href="track-trucks.php">🚛 Track Trucks</a>
  <a href="reports.php">📊 Reports</a>
  <a href="index.html">🔓 Logout</a>
</div>

<div class="main-content">
  <div class="container">
    <h3>Manage Garbage Pickup Schedules</h3>

    <?php if (!empty($message)): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Waste Type</th>
          <th>Pickup Route</th>
          <th>Driver</th>
          <th>Vehicle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $request): ?>
          <tr>
            <td><?= htmlspecialchars($request['pickup_date']) ?></td>
            <td><?= htmlspecialchars($request['pickup_time']) ?></td>
            <td><?= htmlspecialchars($request['waste_type']) ?></td>
            <td><?= htmlspecialchars($request['pickup_route']) ?></td>

            <td>
              <?php if (!empty($request['driver'])): ?>
                <?= htmlspecialchars($request['driver']) ?>
              <?php else: ?>
                <form method="POST" style="margin:0;">
                  <input type="hidden" name="request_id" value="<?= $request['id'] ?>" />
                  <select name="driver" required>
                    <option value="">Select Driver</option>
                    <?php foreach ($drivers as $driver): ?>
                      <option value="<?= htmlspecialchars($driver) ?>"><?= htmlspecialchars($driver) ?></option>
                    <?php endforeach; ?>
                  </select>
            </td>
            <td>
                  <select name="vehicle" required>
                    <option value="">Select Truck</option>
                    <?php foreach ($trucks as $truck): ?>
                      <option value="<?= htmlspecialchars($truck) ?>"><?= htmlspecialchars($truck) ?></option>
                    <?php endforeach; ?>
                  </select>
            </td>
            <td>
                  <button type="submit" name="assign" class="button">Assign</button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
=======
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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $requestId = intval($_POST['request_id']);
    $driver = trim($_POST['driver'] ?? '');
    $vehicle = trim($_POST['vehicle'] ?? '');

    if ($driver !== '' && $vehicle !== '') {
        $stmt = $conn->prepare("UPDATE pickup_requests SET driver=?, vehicle=?, status='Assigned' WHERE id=?");
        $stmt->bind_param("ssi", $driver, $vehicle, $requestId);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: reports.php?assigned=1&request_id=$requestId&driver=$driver&vehicle=$vehicle");
            exit();
        } else {
            $message = "Database error: " . $stmt->error;
            $stmt->close();
        }
    } else {
        $message = "Please fill all assignment fields.";
    }
}

$requests = [];
$result = $conn->query("SELECT * FROM pickup_requests ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

// Get only unassigned drivers from trucks table
$drivers = [];
$driverResult = $conn->query("
    SELECT DISTINCT driver 
    FROM trucks 
    WHERE driver <> '' 
    AND driver NOT IN (
        SELECT driver FROM pickup_requests WHERE status = 'Assigned'
    )
    ORDER BY driver
");
if ($driverResult) {
    while ($row = $driverResult->fetch_assoc()) {
        $drivers[] = $row['driver'];
    }
}

// Get only unassigned trucks from trucks table
$trucks = [];
$truckResult = $conn->query("
    SELECT truck_id 
    FROM trucks 
    WHERE truck_id NOT IN (
        SELECT vehicle FROM pickup_requests WHERE status = 'Assigned'
    )
    ORDER BY truck_id
");
if ($truckResult) {
    while ($row = $truckResult->fetch_assoc()) {
        $trucks[] = $row['truck_id'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Schedules - JeevanSafa</title>
  <style>
    body { display: flex; min-height: 100vh; background-color: #eef5f1; font-family: Arial, sans-serif; }
    .sidebar { width: 240px; background-color: #2e7d32; padding: 20px; color: white; }
    .sidebar h2 { text-align: center; margin-bottom: 30px; }
    .sidebar a { display: block; color: white; text-decoration: none; padding: 12px 15px; border-radius: 5px; margin-bottom: 10px; transition: background 0.3s; }
    .sidebar a:hover { background-color: #1b5e20; }
    .main-content { flex: 1; padding: 40px; }
    .container { background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); }
    h3 { margin-top: 0; color: #2e7d32; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    .button { padding: 10px 16px; background-color: #2e7d32; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .button:hover { background-color: #1b5e20; }
    select { padding: 6px; width: 90%; }
    .message { margin-bottom: 15px; color: green; font-weight: bold; }
    form { margin: 0; }
  </style>
</head>
<body>
<div class="sidebar">
  <h2>Admin Panel</h2>
  <a href="homeadmin.php">🏠 Dashboard</a>
  <a href="manage-schedule.php">📅 Manage Schedules</a>
  <a href="track-trucks.php">🚛 Track Trucks</a>
  <a href="reports.php">📊 Reports</a>
  <a href="login.php">🔓 Logout</a>
</div>
<div class="main-content">
  <div class="container">
    <h3>Manage Garbage Pickup Schedules</h3>
    <?php if (!empty($message)): ?>
      <div class="message"> <?= htmlspecialchars($message) ?> </div>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Waste Type</th>
          <th>Pickup Route</th>
          <th>Driver</th>
          <th>Vehicle</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $request): ?>
          <?php if ($request['status'] !== 'Assigned'): ?>
            <tr>
              <td><?= htmlspecialchars($request['pickup_date']) ?></td>
              <td><?= htmlspecialchars($request['pickup_time']) ?></td>
              <td><?= htmlspecialchars($request['waste_type']) ?></td>
              <td><?= htmlspecialchars($request['pickup_route']) ?></td>
              <td>
                <form method="POST">
                  <input type="hidden" name="request_id" value="<?= $request['id'] ?>" />
                  <select name="driver" required>
                    <option value="">Select Driver</option>
                    <?php foreach ($drivers as $driver): ?>
                      <option value="<?= htmlspecialchars($driver) ?>"><?= htmlspecialchars($driver) ?></option>
                    <?php endforeach; ?>
                  </select>
              </td>
              <td>
                  <select name="vehicle" required>
                    <option value="">Select Truck</option>
                    <?php foreach ($trucks as $truck): ?>
                      <option value="<?= htmlspecialchars($truck) ?>"><?= htmlspecialchars($truck) ?></option>
                    <?php endforeach; ?>
                  </select>
              </td>
              <td>
                  <button type="submit" name="assign" class="button">Assign</button>
                </form>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (isset($_GET['assigned'])): ?>
<script>
  const notification = {
    message: `Driver <?= htmlspecialchars($_GET['driver']) ?> assigned with vehicle <?= htmlspecialchars($_GET['vehicle']) ?> for request ID <?= htmlspecialchars($_GET['request_id']) ?>`,
    timestamp: new Date().toISOString()
  };
  let notifications = JSON.parse(localStorage.getItem("pickupNotifications") || "[]");
  notifications.push(notification);
  localStorage.setItem("pickupNotifications", JSON.stringify(notifications));
</script>
<?php endif; ?>
</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
