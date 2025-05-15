<<<<<<< HEAD
<?php
session_start();

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch POST data
    $wasteType = $_POST['waste_type'] ?? '';
    $pickupDate = $_POST['pickup_date'] ?? '';
    $pickupTime = $_POST['pickup_time'] ?? '';
    $pickupRoute = $_POST['pickup_route'] ?? '';

    // Basic validation
    if (!$wasteType || !$pickupDate || !$pickupTime || !$pickupRoute) {
        $error = "Please fill in all fields.";
    } else {
        $userId = $_SESSION['user_id'];

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO pickup_requests (user_id, waste_type, pickup_date, pickup_time, pickup_route, status, created_at) VALUES (?, ?, ?, ?, ?, 'Pending', NOW())");
        $stmt->bind_param("issss", $userId, $wasteType, $pickupDate, $pickupTime, $pickupRoute);

        if ($stmt->execute()) {
            // Redirect to schedule page after successful insert
            header("Location: schedule.php");
            exit();
        } else {
            $error = "Database error: " . $stmt->error;
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
  <title>Request Waste Pickup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
    .fade-up {
      animation: fadeUp 0.8s ease-out forwards;
      opacity: 0;
      transform: translateY(30px);
    }
    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="home.html" class="text-2xl font-bold flex items-center space-x-2">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4"></path>
        </svg>
        <span>JeevanSafa</span>
      </a>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="recycling-info.php" class="hover:underline">Recycling Info</a>
        <a href="request-pickup.php" class="hover:underline font-semibold underline">Request Pickup</a>
        <a href="help.php" class="hover:underline">Help</a>
        <a href="logout.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </nav>

  <main class="flex-grow">

    <!-- Header -->
    <header class="bg-green-100 py-10 text-center fade-up">
      <h1 class="text-4xl font-bold text-green-700 mb-2">Request Waste Pickup</h1>
      <p class="text-gray-600">Fill in your details to schedule a pickup at your convenience</p>
    </header>

    <!-- Form Section -->
    <section class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6 fade-up">
      <h2 class="text-2xl font-semibold text-green-700 mb-6">Pickup Request Form</h2>

      <?php if ($success): ?>
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded"><?= htmlspecialchars($success) ?></div>
      <?php elseif ($error): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form id="pickup-form" class="space-y-5" method="POST" action="">
        <div>
          <label for="waste-type" class="block text-sm font-medium mb-1">Type of Waste</label>
          <select id="waste-type" name="waste_type" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required>
            <option value="">Select Waste Type</option>
            <option value="Biodegradable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Biodegradable') ? 'selected' : '' ?>>Biodegradable</option>
            <option value="Non-Biodegradable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Non-Biodegradable') ? 'selected' : '' ?>>Non-Biodegradable</option>
            <option value="Recyclable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Recyclable') ? 'selected' : '' ?>>Recyclable</option>
          </select>
        </div>

        <div>
          <label for="pickup-date" class="block text-sm font-medium mb-1">Preferred Pickup Date</label>
          <input type="date" id="pickup-date" name="pickup_date" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>" />
        </div>

        <div>
          <label for="pickup-time" class="block text-sm font-medium mb-1">Preferred Pickup Time</label>
          <input type="time" id="pickup-time" name="pickup_time" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required value="<?= htmlspecialchars($_POST['pickup_time'] ?? '') ?>" />
        </div>

        <div>
          <label for="pickup-route" class="block text-sm font-medium mb-1">Pickup Location (Route)</label>
          <select id="pickup-route" name="pickup_route" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required>
            <option value="">Select Route</option>
            <option value="Koteshwor-Baneswor-Chabahil-Mulpani-Koteshwor" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Koteshwor-Baneswor-Chabahil-Mulpani-Koteshwor') ? 'selected' : '' ?>>
              Koteshwor - Baneswor - Chabahil - Mulpani - Koteshwor
            </option>
            <option value="Mulpani-Chabahil-Baneswor-Koteshwor-Mulpani" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Mulpani-Chabahil-Baneswor-Koteshwor-Mulpani') ? 'selected' : '' ?>>
              Mulpani - Chabahil - Baneswor - Koteshwor - Mulpani
            </option>
            <option value="Chabahil-Baneswor-Koteshwor-Mulpani-Chabahil" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Chabahil-Baneswor-Koteshwor-Mulpani-Chabahil') ? 'selected' : '' ?>>
              Chabahil - Baneswor - Koteshwor - Mulpani - Chabahil
            </option>
            <option value="Koteshwor-Chabahil-Baneswor-Mulpani-Koteshwor" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Koteshwor-Chabahil-Baneswor-Mulpani-Koteshwor') ? 'selected' : '' ?>>
              Koteshwor - Chabahil - Baneswor - Mulpani - Koteshwor
            </option>
          </select>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded text-lg transition duration-200">
          Request Pickup
        </button>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 text-center text-sm">
      &copy; 2025 EcoWaste. All rights reserved.
    </div>
  </footer>

</body>
</html>
=======
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wasteType = $_POST['waste_type'] ?? '';
    $pickupDate = $_POST['pickup_date'] ?? '';
    $pickupTime = $_POST['pickup_time'] ?? '';
    $pickupRoute = $_POST['pickup_route'] ?? '';

    if (!$wasteType || !$pickupDate || !$pickupTime || !$pickupRoute) {
        $error = "Please fill in all fields.";
    } else {
        $userId = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO pickup_requests (user_id, waste_type, pickup_date, pickup_time, pickup_route, status, created_at) VALUES (?, ?, ?, ?, ?, 'Pending', NOW())");
        $stmt->bind_param("issss", $userId, $wasteType, $pickupDate, $pickupTime, $pickupRoute);

        if ($stmt->execute()) {
            header("Location: schedule.php");
            exit();
        } else {
            $error = "Database error: " . $stmt->error;
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
  <title>Request Waste Pickup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body { height: 100%; }
    body { display: flex; flex-direction: column; }
    main { flex: 1; }
    .fade-up {
      animation: fadeUp 0.8s ease-out forwards;
      opacity: 0;
      transform: translateY(30px);
    }
    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Image display fix */
    #start-image img {
      width: 100%;
      height: auto;
      object-fit: cover;
      border-radius: 8px;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="home.html" class="text-2xl font-bold flex items-center space-x-2">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4"></path>
        </svg>
        <span>JeevanSafa</span>
      </a>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="recycling-info.html" class="hover:underline">Recycling Info</a>
        <a href="request-pickup.php" class="hover:underline font-semibold underline">Request Pickup</a>
        <a href="help.php" class="hover:underline">Help</a>
        <a href="login.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </nav>

  <main class="flex-grow">

    <!-- Header -->
    <header class="bg-green-100 py-10 text-center fade-up">
      <h1 class="text-4xl font-bold text-green-700 mb-2">Request Waste Pickup</h1>
      <p class="text-gray-600">Fill in your details to schedule a pickup at your convenience</p>
    </header>

    <!-- Form Section -->
    <section class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6 fade-up">
      <h2 class="text-2xl font-semibold text-green-700 mb-6">Pickup Request Form</h2>

      <?php if ($success): ?>
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded"><?= htmlspecialchars($success) ?></div>
      <?php elseif ($error): ?>
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form id="pickup-form" class="space-y-5" method="POST" action="">

        <div>
          <label for="waste-type" class="block text-sm font-medium mb-1">Type of Waste</label>
          <select id="waste-type" name="waste_type" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required>
            <option value="">Select Waste Type</option>
            <option value="Biodegradable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Biodegradable') ? 'selected' : '' ?>>Biodegradable</option>
            <option value="Non-Biodegradable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Non-Biodegradable') ? 'selected' : '' ?>>Non-Biodegradable</option>
            <option value="Recyclable" <?= (isset($_POST['waste_type']) && $_POST['waste_type'] === 'Recyclable') ? 'selected' : '' ?>>Recyclable</option>
          </select>
        </div>

        <div>
          <label for="pickup-date" class="block text-sm font-medium mb-1">Preferred Pickup Date</label>
          <input type="date" id="pickup-date" name="pickup_date" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>" />
        </div>

        <div>
          <label for="pickup-time" class="block text-sm font-medium mb-1">Preferred Pickup Time</label>
          <input type="time" id="pickup-time" name="pickup_time" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required value="<?= htmlspecialchars($_POST['pickup_time'] ?? '') ?>" />
        </div>

        <div>
          <label for="pickup-route" class="block text-sm font-medium mb-1">Pickup Location (Route)</label>
          <select id="pickup-route" name="pickup_route" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500" required onchange="updateStartImage()">
            <option value="">Select Route</option>
            <option value="Koteshwor-Baneswor-Chabahil-Mulpani-Koteshwor" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Koteshwor-Baneswor-Chabahil-Mulpani-Koteshwor') ? 'selected' : '' ?>>
              Koteshwor - Baneswor - Chabahil - Mulpani - Koteshwor
            </option>
            <option value="Mulpani-Chabahil-Baneswor-Koteshwor-Mulpani" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Mulpani-Chabahil-Baneswor-Koteshwor-Mulpani') ? 'selected' : '' ?>>
              Mulpani - Chabahil - Baneswor - Koteshwor - Mulpani
            </option>
            <option value="Chabahil-Baneswor-Koteshwor-Mulpani-Chabahil" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Chabahil-Baneswor-Koteshwor-Mulpani-Chabahil') ? 'selected' : '' ?>>
              Chabahil - Baneswor - Koteshwor - Mulpani - Chabahil
            </option>
            <option value="Koteshwor-Chabahil-Baneswor-Mulpani-Koteshwor" <?= (isset($_POST['pickup_route']) && $_POST['pickup_route'] === 'Koteshwor-Chabahil-Baneswor-Mulpani-Koteshwor') ? 'selected' : '' ?>>
              Boudha - Chabahil - Baneswor - Mulpani - Boudha
            </option>
          </select>
        </div>

        <div id="start-image" class="mt-4 hidden">
          <label class="block text-sm font-medium mb-1">Starting Point Preview</label>
          <img id="start-point-img" src="" alt="Starting point" class="w-full object-cover rounded border">
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded text-lg transition duration-200">
          Request Pickup
        </button>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 text-center text-sm">
      &copy; 2025 EcoWaste. All rights reserved.
    </div>
  </footer>

  <script>
    function updateStartImage() {
      const route = document.getElementById('pickup-route').value;
      const imgContainer = document.getElementById('start-image');
      const imgTag = document.getElementById('start-point-img');

      if (route) {
        let imageSrc = '';
        if (route === 'Koteshwor-Baneswor-Chabahil-Mulpani-Koteshwor') {
          imageSrc = 'koteswor.jpg';  // First image for this route
        } else if (route === 'Mulpani-Chabahil-Baneswor-Koteshwor-Mulpani') {
          imageSrc = 'mulpani.jpg';  // Second image for this route
        } else if (route === 'Chabahil-Baneswor-Koteshwor-Mulpani-Chabahil') {
          imageSrc = 'chabahil.jpg';  // Third image for this route
        } else if (route === 'Koteshwor-Chabahil-Baneswor-Mulpani-Koteshwor') {
          imageSrc = 'boudha.jpg';  // Fourth image for this route
        }
        
        imgTag.src = imageSrc;
        imgContainer.classList.remove('hidden');
      } else {
        imgContainer.classList.add('hidden');
      }
    }

    // Call function on page load if a route is already selected
    window.onload = updateStartImage;
  </script>

</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
