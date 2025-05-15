<<<<<<< HEAD
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

$user_id = $_SESSION['user_id'];

// Fetch user basic info from users table
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email);
$stmt->fetch();
$stmt->close();

// Fetch profile info from user_profiles table
$stmt = $conn->prepare("SELECT phone, address, bio, dob, profile_image FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($phone, $address, $bio, $dob, $profile_image);
$stmt->fetch();
$stmt->close();

$conn->close();

$full_name = htmlspecialchars(trim($first_name . ' ' . $last_name));
$email = htmlspecialchars($email ?? '');
$phone = htmlspecialchars($phone ?? '');
$address = htmlspecialchars($address ?? '');
$bio = htmlspecialchars($bio ?? '');
$dob = $dob ?? '';
$profile_image = $profile_image ? htmlspecialchars($profile_image) : 'defaultprofilepicture/sillhoutte.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JeevanSafa - Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
        <a href="home.php" class="text-2xl font-bold">JeevanSafa</a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="recycling-info.php" class="hover:underline">Recycling Info</a>
        <a href="help.php" class="hover:underline">Help</a>
        <a href="logout.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-green-100 py-10 text-center fade-up">
    <h1 class="text-4xl font-bold text-green-700 mb-2">User Profile</h1>
    <p class="text-gray-600">Manage your account details and preferences</p>
  </header>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="max-w-4xl mx-auto mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
      Profile updated successfully!
    </div>
  <?php endif; ?>

  <!-- Profile Section -->
  <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6 fade-up">
    <form id="profileForm" enctype="multipart/form-data" method="POST" action="save-profile.php">
      <div class="flex flex-col items-center mb-6">
        <label for="profile-pic" class="cursor-pointer relative inline-block">
          <img id="profileImage" src="<?= $profile_image ?>" alt="Profile Picture" class="w-40 h-40 rounded-full border-4 border-green-300 shadow-md object-cover">
          <input type="file" id="profile-pic" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
        </label>
        <button type="button" onclick="document.getElementById('profile-pic').click()" id="changePicBtn" class="mt-2 text-sm text-green-700 hover:underline">Change Profile Picture</button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="name" class="text-gray-700 font-semibold">Full Name</label>
          <input id="name" name="name" type="text" class="border border-gray-300 rounded p-2 w-full" value="<?= $full_name ?>" required>
        </div>
        <div>
          <label for="email" class="text-gray-700 font-semibold">Email</label>
          <input id="email" name="email" type="email" class="border border-gray-300 rounded p-2 w-full" value="<?= $email ?>" required>
        </div>
        <div>
          <label for="phone" class="text-gray-700 font-semibold">Phone</label>
          <input id="phone" name="phone" type="tel" class="border border-gray-300 rounded p-2 w-full" value="<?= $phone ?>">
        </div>
        <div>
          <label for="address" class="text-gray-700 font-semibold">Address</label>
          <input id="address" name="address" type="text" class="border border-gray-300 rounded p-2 w-full" value="<?= $address ?>">
        </div>
        <div class="md:col-span-2">
          <label for="bio" class="text-gray-700 font-semibold">Bio</label>
          <textarea id="bio" name="bio" class="border border-gray-300 rounded p-2 w-full" rows="3"><?= $bio ?></textarea>
        </div>
        <div>
          <label for="dob" class="text-gray-700 font-semibold">Date of Birth</label>
          <input id="dob" name="dob" type="date" class="border border-gray-300 rounded p-2 w-full" value="<?= $dob ?>">
        </div>
      </div>

      <div class="text-center mt-8">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Save Changes</button>
      </div>
    </form>
  </section>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-sm">&copy; 2025 EcoWaste. All rights reserved.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 001.88-2.37 8.59 8.59 0 01-2.72 1.04A4.28 4.28 0 0016.11 4c-2.4 0-4.34 1.95-4.34 4.34 0 .34.04.67.1.98C7.73 9.21 4.1 7.4 1.67 4.66a4.3 4.3 0 00-.58 2.18c0 1.5.76 2.82 1.92 3.6a4.26 4.26 0 01-1.97-.54v.05c0 2.1 1.49 3.85 3.46 4.25a4.3 4.3 0 01-1.96.07 4.3 4.3 0 004.02 2.99A8.6 8.6 0 012 19.54a12.1 12.1 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2v-.56A8.7 8.7 0 0024 5.32a8.51 8.51 0 01-2.54.7z" />
          </svg></a>
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 3A2 2 0 0121 5v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zm-5.5 14.5h2v-6h-2v6zM10 17.5h2v-6H10v6zM12 9.5a1 1 0 100-2 1 1 0 000 2z" />
          </svg></a>
      </div>
    </div>
  </footer>

  <script>
    function previewImage(event) {
      const reader = new FileReader();
      reader.onload = function () {
        document.getElementById('profileImage').src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
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

$user_id = $_SESSION['user_id'];

// Fetch user basic info from users table
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email);
$stmt->fetch();
$stmt->close();

// Fetch profile info from user_profiles table
$stmt = $conn->prepare("SELECT phone, address, bio, dob, profile_image FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($phone, $address, $bio, $dob, $profile_image);
$stmt->fetch();
$stmt->close();

$conn->close();

$full_name = htmlspecialchars(trim($first_name . ' ' . $last_name));
$email = htmlspecialchars($email ?? '');
$phone = htmlspecialchars($phone ?? '');
$address = htmlspecialchars($address ?? '');
$bio = htmlspecialchars($bio ?? '');
$dob = $dob ?? '';
$profile_image = $profile_image ? htmlspecialchars($profile_image) : 'defaultprofilepicture/sillhoutte.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JeevanSafa - Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
        <a href="home.php" class="text-2xl font-bold">JeevanSafa</a>
      </div>
      <div class="space-x-5 text-sm font-medium hidden md:block">
        <a href="home.php" class="hover:underline">Home</a>
        <a href="request-pickup.php" class="hover:underline">Request Pickup</a>
        <a href="schedule.php" class="hover:underline">Schedule</a>
        <a href="profile.php" class="hover:underline">Profile</a>
        <a href="recycling-info.php" class="hover:underline">Recycling Info</a>
        <a href="help.php" class="hover:underline">Help</a>
        <a href="logout.php" class="hover:underline">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-green-100 py-10 text-center fade-up">
    <h1 class="text-4xl font-bold text-green-700 mb-2">User Profile</h1>
    <p class="text-gray-600">Manage your account details and preferences</p>
  </header>

  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="max-w-4xl mx-auto mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
      Profile updated successfully!
    </div>
  <?php endif; ?>

  <!-- Profile Section -->
  <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6 fade-up">
    <form id="profileForm" enctype="multipart/form-data" method="POST" action="save-profile.php">
      <div class="flex flex-col items-center mb-6">
        <label for="profile-pic" class="cursor-pointer relative inline-block">
          <img id="profileImage" src="<?= $profile_image ?>" alt="Profile Picture" class="w-40 h-40 rounded-full border-4 border-green-300 shadow-md object-cover">
          <input type="file" id="profile-pic" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
        </label>
        <button type="button" onclick="document.getElementById('profile-pic').click()" id="changePicBtn" class="mt-2 text-sm text-green-700 hover:underline">Change Profile Picture</button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="name" class="text-gray-700 font-semibold">Full Name</label>
          <input id="name" name="name" type="text" class="border border-gray-300 rounded p-2 w-full" value="<?= $full_name ?>" required>
        </div>
        <div>
          <label for="email" class="text-gray-700 font-semibold">Email</label>
          <input id="email" name="email" type="email" class="border border-gray-300 rounded p-2 w-full" value="<?= $email ?>" required>
        </div>
        <div>
          <label for="phone" class="text-gray-700 font-semibold">Phone</label>
          <input id="phone" name="phone" type="tel" class="border border-gray-300 rounded p-2 w-full" value="<?= $phone ?>">
        </div>
        <div>
          <label for="address" class="text-gray-700 font-semibold">Address</label>
          <input id="address" name="address" type="text" class="border border-gray-300 rounded p-2 w-full" value="<?= $address ?>">
        </div>
        <div class="md:col-span-2">
          <label for="bio" class="text-gray-700 font-semibold">Bio</label>
          <textarea id="bio" name="bio" class="border border-gray-300 rounded p-2 w-full" rows="3"><?= $bio ?></textarea>
        </div>
        <div>
          <label for="dob" class="text-gray-700 font-semibold">Date of Birth</label>
          <input id="dob" name="dob" type="date" class="border border-gray-300 rounded p-2 w-full" value="<?= $dob ?>">
        </div>
      </div>

      <div class="text-center mt-8">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Save Changes</button>
      </div>
    </form>
  </section>

  <!-- Footer -->
  <footer class="bg-green-700 text-white py-6 mt-16 fade-up">
    <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
      <p class="text-sm">&copy; 2025 EcoWaste. All rights reserved.</p>
      <div class="flex space-x-4 mt-4 md:mt-0">
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 001.88-2.37 8.59 8.59 0 01-2.72 1.04A4.28 4.28 0 0016.11 4c-2.4 0-4.34 1.95-4.34 4.34 0 .34.04.67.1.98C7.73 9.21 4.1 7.4 1.67 4.66a4.3 4.3 0 00-.58 2.18c0 1.5.76 2.82 1.92 3.6a4.26 4.26 0 01-1.97-.54v.05c0 2.1 1.49 3.85 3.46 4.25a4.3 4.3 0 01-1.96.07 4.3 4.3 0 004.02 2.99A8.6 8.6 0 012 19.54a12.1 12.1 0 006.56 1.92c7.88 0 12.2-6.53 12.2-12.2v-.56A8.7 8.7 0 0024 5.32a8.51 8.51 0 01-2.54.7z" />
          </svg></a>
        <a href="#"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 3A2 2 0 0121 5v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14zm-5.5 14.5h2v-6h-2v6zM10 17.5h2v-6H10v6zM12 9.5a1 1 0 100-2 1 1 0 000 2z" />
          </svg></a>
      </div>
    </div>
  </footer>

  <script>
    function previewImage(event) {
      const reader = new FileReader();
      reader.onload = function () {
        document.getElementById('profileImage').src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</body>
</html>
>>>>>>> c2e25da (Initial commit: add all project files)
