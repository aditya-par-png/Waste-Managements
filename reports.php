<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch assigned pickups
$sql = "SELECT pickup_date, pickup_time, waste_type, driver, vehicle, pickup_route 
        FROM pickup_requests WHERE status = 'Assigned' ORDER BY pickup_date DESC, pickup_time DESC";

$result = $conn->query($sql);
$assignedRequests = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $assignedRequests[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reports - JeevanSafa</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
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
    .report-container {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background-color: #f1f1f1;
    }
    .button {
      background-color: #2e7d32;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 20px;
      font-size: 16px;
    }
    .button:hover {
      background-color: #1b5e20;
    }
  </style>
  <script>
    function generateReport() {
      const table = document.querySelector("table");

      const ws = XLSX.utils.table_to_sheet(table, { cellDates: true });

      const colCount = table.rows[0].cells.length;
      ws["!cols"] = Array.from({ length: colCount }, () => ({ wch: 25 }));

      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Assigned Drivers");

      XLSX.writeFile(wb, "Assigned_Drivers_Report.xlsx");
    }
  </script>
</head>
<body>

  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="homeadmin.php">🏠 Dashboard</a>
    <a href="manage-schedule.php">📅 Manage Schedules</a>
    <a href="track-trucks.php">🚛 Track Trucks</a>
    <a href="reports.php">📊 Reports</a>
    <a href="home.php">🔓 Logout</a>
  </div>

  <div class="main-content">
    <h1>Reports - Assigned Drivers</h1>
    <div class="report-container">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Waste Type</th>
            <th>Driver</th>
            <th>Vehicle</th>
            <th>Route</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($assignedRequests as $req): ?>
            <tr>
              <td><?= htmlspecialchars($req['pickup_date']) ?></td>
              <td><?= htmlspecialchars($req['pickup_time']) ?></td>
              <td><?= htmlspecialchars($req['waste_type']) ?></td>
              <td><?= htmlspecialchars($req['driver']) ?></td>
              <td><?= htmlspecialchars($req['vehicle']) ?></td>
              <td><?= htmlspecialchars($req['pickup_route']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button class="button" onclick="generateReport()">📥 Generate Report</button>
    </div>
  </div>

</body>
</html>
