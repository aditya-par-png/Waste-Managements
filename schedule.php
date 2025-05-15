<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$userId = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);

    // Delete only if the pickup belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM pickup_requests WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $deleteId, $userId);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid form resubmission on refresh
    header("Location: schedule.php");
    exit();
}

// Fetch user's pickup requests
$stmt = $conn->prepare("SELECT id, waste_type, pickup_date, pickup_time, pickup_route, status FROM pickup_requests WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JeevanSafa - Schedule</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
    html { scroll-behavior: smooth; }
    .fade-up {
      animation: fadeUp 1s ease-out forwards;
      opacity: 0;
      transform: translateY(30px);
    }
    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    /* Style for delete button */
    .delete-btn {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      background-color: #e53e3e;
      color: white;
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.75rem;
      cursor: pointer;
      border: none;
      transition: background-color 0.2s;
    }
    .delete-btn:hover {
      background-color: #c53030;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4"></path>
        </svg>
        <a href="#" class="text-2xl font-bold">JeevanSafa</a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <a href="home.html" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline font-semibold underline">Schedule</a>
        <a href="profile.html" class="hover:underline">Profile</a>
        <a href="recycling-info.html" class="hover:underline">Recycling Info</a>
        <a href="help.html" class="hover:underline">Help</a>
        <a href="logout.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </nav>

  <main>
    <!-- Header -->
    <header class="bg-green-100 py-10 text-center fade-up">
      <h1 class="text-4xl font-bold text-green-700 mb-2">Scheduled Pickups</h1>
      <p class="text-gray-600">View and manage your upcoming waste pickups</p>
    </header>

    <!-- Schedule Cards -->
    <section class="max-w-5xl mx-auto mt-8 p-6">
      <div id="schedule-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 fade-up">
        <?php if (empty($requests)): ?>
          <div class="col-span-full text-center text-gray-500">No pickups scheduled yet.</div>
        <?php else: ?>
          <?php foreach ($requests as $request): ?>
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500 relative transition hover:shadow-xl">
              <form method="POST" onsubmit="return confirm('Are you sure you want to delete this pickup?');" style="position:absolute; top:0.5rem; right:0.5rem;">
                <input type="hidden" name="delete_id" value="<?= $request['id'] ?>">
                <button type="submit" class="delete-btn" title="Delete Pickup">&times;</button>
              </form>
              <p class="text-sm text-gray-400"><?= date('D, M j, Y', strtotime($request['pickup_date'])) ?></p>
              <h3 class="text-lg font-semibold text-green-700 mt-1 mb-2"><?= htmlspecialchars($request['waste_type']) ?></h3>
              <p class="text-gray-700 text-sm">Time: <span class="font-medium"><?= htmlspecialchars($request['pickup_time']) ?></span></p>
              <p class="text-gray-700 text-sm">Route: <span class="font-medium"><?= htmlspecialchars($request['pickup_route']) ?></span></p>
              <p class="mt-2 text-green-600 font-medium">Status: <?= htmlspecialchars($request['status'] ?? 'Scheduled') ?></p>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

</body>
</html>
=======
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Deleting schedule request if 'delete' button is clicked
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteStmt = $conn->prepare("DELETE FROM pickup_requests WHERE id = ? AND user_id = ?");
    $deleteStmt->bind_param("ii", $deleteId, $userId);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Redirect to refresh the page
    header("Location: schedule.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, waste_type, pickup_date, pickup_time, pickup_route, status, driver, vehicle FROM pickup_requests WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JeevanSafa - Schedule</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .delete-btn {
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      background-color: #e53e3e;
      color: white;
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.75rem;
      cursor: pointer;
      border: none;
      transition: background-color 0.2s;
    }
    .delete-btn:hover {
      background-color: #c53030;
    }
    .notification-bell {
      position: relative;
    }
    .notification-count {
      position: absolute;
      top: -0.4rem;
      right: -0.4rem;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 10px;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <a href="home.html" class="text-2xl font-bold flex items-center">
          <svg class="w-8 h-8 mr-1" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4"></path>
          </svg>
          JeevanSafa
        </a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:flex items-center">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline font-semibold underline">Schedule</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="recycling-info.html" class="hover:underline">Recycling Info</a>
        <a href="help.php" class="hover:underline">Help</a>
        <a href="login.php" class="hover:underline">Logout</a>

        <!-- Notification Icon -->
        <div class="relative notification-bell cursor-pointer" onclick="viewNotifications()">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
          </svg>
          <div id="notificationCount" class="notification-count hidden">0</div>
        </div>
      </div>
    </div>
  </nav>

  <main>
    <header class="bg-green-100 py-10 text-center">
      <h1 class="text-4xl font-bold text-green-700 mb-2">Scheduled Pickups</h1>
      <p class="text-gray-600">View and manage your upcoming waste pickups</p>
    </header>

    <section class="max-w-5xl mx-auto mt-8 p-6">
      <div id="schedule-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($requests)): ?>
          <div class="col-span-full text-center text-gray-500">No pickups scheduled yet.</div>
        <?php else: ?>
          <?php foreach ($requests as $request): ?>
            <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500 relative">
              <p class="text-sm text-gray-400"><?= date('D, M j, Y', strtotime($request['pickup_date'])) ?></p>
              <h3 class="text-lg font-semibold text-green-700 mt-1 mb-2"><?= htmlspecialchars($request['waste_type']) ?></h3>
              <p class="text-gray-700 text-sm">Time: <span class="font-medium"><?= htmlspecialchars($request['pickup_time']) ?></span></p>
              <p class="text-gray-700 text-sm">Route: <span class="font-medium"><?= htmlspecialchars($request['pickup_route']) ?></span></p>
              <p class="text-gray-700 text-sm">Status: <span class="font-medium"><?= htmlspecialchars($request['status']) ?></span></p>
              <?php if ($request['driver']): ?>
                <p class="text-sm mt-1 text-gray-700">Driver: <strong><?= htmlspecialchars($request['driver']) ?></strong></p>
                <p class="text-sm text-gray-700">Vehicle: <strong><?= htmlspecialchars($request['vehicle']) ?></strong></p>
              <?php endif; ?>
              <!-- Delete Button -->
              <a href="schedule.php?delete_id=<?= $request['id'] ?>" class="delete-btn">Delete</a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
    // Notification check
    const userId = <?= json_encode($userId) ?>;
    const notifications = JSON.parse(localStorage.getItem('notifications_' + userId)) || [];

    const unreadCount = notifications.length;
    const countEl = document.getElementById("notificationCount");
    if (unreadCount > 0) {
      countEl.textContent = unreadCount;
      countEl.classList.remove("hidden");
    }

    function viewNotifications() {
      if (notifications.length > 0) {
        let messages = notifications.map(n => `${n.message} (${n.date})`).join('\n');
        alert("Notifications:\n\n" + messages);
        localStorage.setItem('notifications_' + userId, JSON.stringify([]));
        countEl.classList.add("hidden");
      } else {
        alert("No new notifications.");
      }
    }
  </script>
</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
