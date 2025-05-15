<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - JeevanSafa</title>
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
    .dashboard-header {
      margin-bottom: 30px;
    }
    .dashboard-header h1 {
      color: #2e7d32;
    }
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .card h3 {
      color: #333;
    }
    .card p {
      color: #666;
    }
  </style>
  <script>
    function loadDashboardStats() {
      const requests = JSON.parse(localStorage.getItem("scheduleList")) || [];
      const assigned = requests.filter(r => r.status === "Assigned");
      const pending = requests.filter(r => r.status !== "Assigned");

      document.getElementById("todays-pickups").textContent = `${assigned.length} pickups assigned`;
      document.getElementById("pending-requests").textContent = `${pending.length} requests pending`;
      document.getElementById("truck-status").textContent = `Trucks assigned: ${[...new Set(assigned.map(r => r.vehicle))].length}`;
      document.getElementById("system-logs").textContent = `${requests.length} total schedule entries.`;
    }

    document.addEventListener("DOMContentLoaded", loadDashboardStats);
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
    <div class="dashboard-header">
      <h1>Welcome, Admin</h1>
      <p>Monitor today's activity and manage operations.</p>
    </div>
    <div class="dashboard-grid">
      <div class="card">
        <h3>Today's Pickups</h3>
        <p id="todays-pickups">Loading...</p>
      </div>
      <div class="card">
        <h3>Truck Status</h3>
        <p id="truck-status">Loading...</p>
      </div>
      <div class="card">
        <h3>Pending Requests</h3>
        <p id="pending-requests">Loading...</p>
      </div>
      <div class="card">
        <h3>System Logs</h3>
        <p id="system-logs">Loading...</p>
      </div>
    </div>
  </div>

</body>
</html>
=======
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - JeevanSafa</title>
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
    .dashboard-header {
      margin-bottom: 30px;
    }
    .dashboard-header h1 {
      color: #2e7d32;
    }
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .card h3 {
      color: #333;
    }
    .card p {
      color: #666;
    }
  </style>
  <script>
    function loadDashboardStats() {
      // Retrieve the schedule data from localStorage
      const requests = JSON.parse(localStorage.getItem("scheduleList")) || [];

      // Filter the requests into 'Assigned' and 'Pending'
      const assigned = requests.filter(r => r.status === "Assigned");
      const pending = requests.filter(r => r.status !== "Assigned");

      // Update the DOM elements with the calculated values
      document.getElementById("todays-pickups").textContent = `${assigned.length} pickups assigned`;
      document.getElementById("pending-requests").textContent = `${pending.length} requests pending`;

      // Calculate the number of unique trucks assigned
      const truckSet = new Set(assigned.map(r => r.vehicle));
      document.getElementById("truck-status").textContent = `Trucks assigned: ${truckSet.size}`;

      // Total number of schedule entries
      document.getElementById("system-logs").textContent = `${requests.length} total schedule entries.`;
    }

    // Load the stats when the page is loaded
    document.addEventListener("DOMContentLoaded", loadDashboardStats);
  </script>
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
    <div class="dashboard-header">
      <h1>Welcome, Admin</h1>
      <p>Monitor today's activity and manage operations.</p>
    </div>
    <div class="dashboard-grid">
      <div class="card">
        <h3>Today's Pickups</h3>
        <p id="todays-pickups">Loading...</p>
      </div>
      <div class="card">
        <h3>Truck Status</h3>
        <p id="truck-status">Loading...</p>
      </div>
      <div class="card">
        <h3>Pending Requests</h3>
        <p id="pending-requests">Loading...</p>
      </div>
      <div class="card">
        <h3>System Logs</h3>
        <p id="system-logs">Loading...</p>
      </div>
    </div>
  </div>

</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
