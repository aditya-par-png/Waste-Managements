<<<<<<< HEAD
<?php
session_start();

// Simple login logic (for demonstration only)
// Replace with your actual authentication logic and secure password handling
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy check: replace with DB lookup & password_verify
    if ($email === 'user@example.com' && $password === 'password123') {
        $_SESSION['user_id'] = 1; // example user ID
        $_SESSION['user_email'] = $email;
        header("Location: home.php");
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}

// Check login status
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JeevanSafa - Smart Waste Management</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }

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
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4">
          </path>
        </svg>
        <a href="home.php" class="text-2xl font-bold">JeevanSafa</a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:flex items-center">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="recycling-info.php" class="hover:underline">Recycling Info</a>
        <a href="help.php" class="hover:underline">Help</a>
        <?php if ($isLoggedIn): ?>
          <a href="?logout=1" class="hover:underline">Logout</a>
        <?php else: ?>
          <button id="loginBtn" class="hover:underline bg-green-600 px-3 py-1 rounded">Login</button>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-green-100 py-20">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between space-y-10 md:space-y-0">
      <!-- Text -->
      <div class="max-w-xl text-center md:text-left fade-up">
        <h1 class="text-5xl font-extrabold text-green-700 mb-4 leading-tight">Smart Waste Management System</h1>
        <p class="text-lg text-gray-700 mb-6">Creating a cleaner and greener future by managing waste efficiently.</p>
        <div>
          <a href="request-pickup.php"
            class="bg-green-700 text-white px-6 py-3 rounded-md shadow hover:bg-green-800 transition">Get Started</a>
        </div>
      </div>

      <!-- Animation -->
      <div class="fade-up">
        <lottie-player src="eco.json"
          background="transparent" speed="1" style="width: 350px; height: 350px;" loop autoplay>
        </lottie-player>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="max-w-7xl mx-auto px-4 py-16 fade-up">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-12">Our Services</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 13h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10zM5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Waste Collection</h3>
        <p class="text-center text-gray-600 mt-2">Timely and efficient collection of residential and commercial waste.
        </p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M19 11H5m14 0a2 2 0 100-4H5a2 2 0 100 4m14 0a2 2 0 100 4H5a2 2 0 100-4">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Recycling Programs</h3>
        <p class="text-center text-gray-600 mt-2">Eco-friendly initiatives to reduce, reuse, and recycle waste
          materials.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M13 10V3L4 14h7v7l9-11h-7z">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Smart Monitoring</h3>
        <p class="text-center text-gray-600 mt-2">IoT tech to monitor waste bins and optimize collection routes.</p>
      </div>
    </div>
  </section>

  <!-- About Us -->
  <section class="bg-white py-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-10">
      <div class="md:w-1/2">
        <img src="https://via.placeholder.com/600x400.png?text=Team+Photo+Placeholder" alt="Team Placeholder"
          class="rounded-lg shadow-md" />
      </div>
      <div class="md:w-1/2">
        <h2 class="text-3xl font-bold text-green-700 mb-4">Why Choose EcoWaste?</h2>
        <p class="text-gray-700 mb-6">
          EcoWaste is committed to sustainability and innovation. Our system ensures real-time tracking, efficient
          collection, and responsible disposal, helping cities reduce their carbon footprint and promote a healthier
          environment.
        </p>
        <a href="#" class="inline-block border border-green-700 text-green-700 px-6 py-2 rounded-md hover:bg-green-100 transition">Learn More</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-sm">&copy; 2025 EcoWaste. All rights reserved.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 001.88-2.37 8.59 8.59 0 01-2.72 1.04A4.28 4.28 0 0016.11 4c-2.4 0-4.34 1.95-4.34 4.34 0 .34.04.67.1.98C7.73 9.21 4.1 7.4 1.67 4.66a4.3 4.3 0 00-.58 2.18c0 1.5.76 2.82 1.92 3.6a4.26 4.26 0 01-1.97-.54v.05c0 2.1 1.49 3.85 3.46 4.25a4.3 4.3 0 01-1.96.07 4.3 4.3 0 004.02 2.99A8.6 8.6 0 012 19.54a12.1 12.1 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2v-.56A8.7 8.7 0 0024 5.32a8.51 8.51 0 01-2.54.7z" />
          </svg></a>
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M19 3A2 2 0 0121 5v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zm-5.5 14.5h2v-6h-2v6zM10 17.5h2v-6H10v6zM12 9.5a1 1 0 100-2 1 1 0 000 2z" />
          </svg></a>
      </div>
    </div>
  </footer>

  <script>
    // Login button redirects to login page
    document.getElementById('loginBtn')?.addEventListener('click', () => {
      window.location.href = 'login.php';
    });
  </script>

</body>

</html>
=======
<?php
session_start();

// Simple login logic (for demonstration only)
// Replace with your actual authentication logic and secure password handling
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy check: replace with DB lookup & password_verify
    if ($email === 'user@example.com' && $password === 'password123') {
        $_SESSION['user_id'] = 1; // example user ID
        $_SESSION['user_email'] = $email;
        header("Location: home.php");
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check login status
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JeevanSafa - Smart Waste Management</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }

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
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-green-700 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 17v-4a2 2 0 012-2h2a2 2 0 012 2v4m4 0v-4a6 6 0 00-12 0v4m4 0h4">
          </path>
        </svg>
        <a href="home.php" class="text-2xl font-bold">JeevanSafa</a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:flex items-center">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="recycling-info.php" class="hover:underline">Recycling Info</a>
        <a href="help.php" class="hover:underline">Help</a>
        <?php if ($isLoggedIn): ?>
          <a href="?logout=1" class="hover:underline">Logout</a>
        <?php else: ?>
          <button id="loginBtn" class="hover:underline bg-green-600 px-3 py-1 rounded">Login</button>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-green-100 py-20">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between space-y-10 md:space-y-0">
      <!-- Text -->
      <div class="max-w-xl text-center md:text-left fade-up">
        <h1 class="text-5xl font-extrabold text-green-700 mb-4 leading-tight">Smart Waste Management System</h1>
        <p class="text-lg text-gray-700 mb-6">Creating a cleaner and greener future by managing waste efficiently.</p>
        <div>
          <a href="request-pickup.php"
            class="bg-green-700 text-white px-6 py-3 rounded-md shadow hover:bg-green-800 transition">Get Started</a>
        </div>
      </div>

      <!-- Animation -->
      <div class="fade-up">
        <lottie-player src="eco.json"
          background="transparent" speed="1" style="width: 350px; height: 350px;" loop autoplay>
        </lottie-player>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="max-w-7xl mx-auto px-4 py-16 fade-up">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-12">Our Services</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 13h6m2 0a2 2 0 100-4H7a2 2 0 100 4h10zM5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Waste Collection</h3>
        <p class="text-center text-gray-600 mt-2">Timely and efficient collection of residential and commercial waste.
        </p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M19 11H5m14 0a2 2 0 100-4H5a2 2 0 100 4m14 0a2 2 0 100 4H5a2 2 0 100-4">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Recycling Programs</h3>
        <p class="text-center text-gray-600 mt-2">Eco-friendly initiatives to reduce, reuse, and recycle waste
          materials.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-lg transform hover:-translate-y-2 transition duration-300">
        <div class="text-green-600 mb-3">
          <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M13 10V3L4 14h7v7l9-11h-7z">
            </path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-center text-green-700">Smart Monitoring</h3>
        <p class="text-center text-gray-600 mt-2">IoT tech to monitor waste bins and optimize collection routes.</p>
      </div>
    </div>
  </section>

  <!-- About Us -->
  <section class="bg-white py-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-10">
      <div class="md:w-1/2">
        <img src="https://via.placeholder.com/600x400.png?text=Team+Photo+Placeholder" alt="Team Placeholder"
          class="rounded-lg shadow-md" />
      </div>
      <div class="md:w-1/2">
        <h2 class="text-3xl font-bold text-green-700 mb-4">Why Choose EcoWaste?</h2>
        <p class="text-gray-700 mb-6">
          EcoWaste is committed to sustainability and innovation. Our system ensures real-time tracking, efficient
          collection, and responsible disposal, helping cities reduce their carbon footprint and promote a healthier
          environment.
        </p>
        <a href="#" class="inline-block border border-green-700 text-green-700 px-6 py-2 rounded-md hover:bg-green-100 transition">Learn More</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-sm">&copy; 2025 EcoWaste. All rights reserved.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 001.88-2.37 8.59 8.59 0 01-2.72 1.04A4.28 4.28 0 0016.11 4c-2.4 0-4.34 1.95-4.34 4.34 0 .34.04.67.1.98C7.73 9.21 4.1 7.4 1.67 4.66a4.3 4.3 0 00-.58 2.18c0 1.5.76 2.82 1.92 3.6a4.26 4.26 0 01-1.97-.54v.05c0 2.1 1.49 3.85 3.46 4.25a4.3 4.3 0 01-1.96.07 4.3 4.3 0 004.02 2.99A8.6 8.6 0 012 19.54a12.1 12.1 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2v-.56A8.7 8.7 0 0024 5.32a8.51 8.51 0 01-2.54.7z" />
          </svg></a>
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M19 3A2 2 0 0121 5v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zm-5.5 14.5h2v-6h-2v6zM10 17.5h2v-6H10v6zM12 9.5a1 1 0 100-2 1 1 0 000 2z" />
          </svg></a>
      </div>
    </div>
  </footer>

  <script>
    // Login button redirects to login page
    document.getElementById('loginBtn')?.addEventListener('click', () => {
      window.location.href = 'login.php';
    });
  </script>

</body>

</html>
>>>>>>> c2e25da (Initial commit: add all project files)
