<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and parse full name into first and last
$first_name = '';
$last_name = '';
if (!empty($_POST['name'])) {
    $nameParts = explode(' ', trim($_POST['name']), 2);
    $first_name = $conn->real_escape_string($nameParts[0]);
    $last_name = isset($nameParts[1]) ? $conn->real_escape_string($nameParts[1]) : '';
}

// Sanitize other inputs
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$dob = $_POST['dob'] ?? null;

// Input validation
$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if ($dob && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    $errors[] = "Invalid date format for Date of Birth.";
}

if ($phone && !preg_match('/^[0-9+\-\s\(\)]*$/', $phone)) {
    $errors[] = "Invalid phone number format.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red; font-weight:bold;'>$error</p>";
    }
    exit();
}

// Handle profile image upload
$profile_image_path = null;
$maxFileSize = 2 * 1024 * 1024; // 2MB

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        die("File upload error code: " . $_FILES['profile_image']['error']);
    }

    if ($_FILES['profile_image']['size'] > $maxFileSize) {
        die("File size exceeds 2MB limit.");
    }

    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_tmp = $_FILES['profile_image']['tmp_name'];
    $file_name = basename($_FILES['profile_image']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed)) {
        die("Invalid image file type. Allowed types: jpg, jpeg, png, gif.");
    }

    $new_file_name = uniqid('profile_', true) . '.' . $file_ext;
    $target_file = $upload_dir . $new_file_name;

    if (!move_uploaded_file($file_tmp, $target_file)) {
        die("Failed to upload image.");
    }

    $profile_image_path = $target_file;
}

// Update users table for name and email
$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
$stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
if (!$stmt->execute()) {
    die("Error updating users table: " . htmlspecialchars($stmt->error));
}
$stmt->close();

// Check if profile exists
$checkStmt = $conn->prepare("SELECT user_id FROM user_profiles WHERE user_id = ?");
$checkStmt->bind_param("i", $user_id);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Update existing profile
    if ($profile_image_path) {
        $updateStmt = $conn->prepare("UPDATE user_profiles SET phone=?, address=?, bio=?, dob=?, profile_image=? WHERE user_id=?");
        $updateStmt->bind_param("sssssi", $phone, $address, $bio, $dob, $profile_image_path, $user_id);
    } else {
        $updateStmt = $conn->prepare("UPDATE user_profiles SET phone=?, address=?, bio=?, dob=? WHERE user_id=?");
        $updateStmt->bind_param("ssssi", $phone, $address, $bio, $dob, $user_id);
    }
    if (!$updateStmt->execute()) {
        die("Error updating user_profiles table: " . htmlspecialchars($updateStmt->error));
    }
    $updateStmt->close();
} else {
    // Insert new profile
    $insertStmt = $conn->prepare("INSERT INTO user_profiles (user_id, phone, address, bio, dob, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("isssss", $user_id, $phone, $address, $bio, $dob, $profile_image_path);
    if (!$insertStmt->execute()) {
        die("Error inserting into user_profiles table: " . htmlspecialchars($insertStmt->error));
    }
    $insertStmt->close();
}
$checkStmt->close();

$conn->close();

header("Location: profile.php?success=1");
exit();
?>
=======
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and parse full name into first and last
$first_name = '';
$last_name = '';
if (!empty($_POST['name'])) {
    $nameParts = explode(' ', trim($_POST['name']), 2);
    $first_name = $conn->real_escape_string($nameParts[0]);
    $last_name = isset($nameParts[1]) ? $conn->real_escape_string($nameParts[1]) : '';
}

// Sanitize other inputs
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$dob = $_POST['dob'] ?? null;

// Input validation
$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if ($dob && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    $errors[] = "Invalid date format for Date of Birth.";
}

if ($phone && !preg_match('/^[0-9+\-\s\(\)]*$/', $phone)) {
    $errors[] = "Invalid phone number format.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red; font-weight:bold;'>$error</p>";
    }
    exit();
}

// Handle profile image upload
$profile_image_path = null;
$maxFileSize = 2 * 1024 * 1024; // 2MB

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        die("File upload error code: " . $_FILES['profile_image']['error']);
    }

    if ($_FILES['profile_image']['size'] > $maxFileSize) {
        die("File size exceeds 2MB limit.");
    }

    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_tmp = $_FILES['profile_image']['tmp_name'];
    $file_name = basename($_FILES['profile_image']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed)) {
        die("Invalid image file type. Allowed types: jpg, jpeg, png, gif.");
    }

    $new_file_name = uniqid('profile_', true) . '.' . $file_ext;
    $target_file = $upload_dir . $new_file_name;

    if (!move_uploaded_file($file_tmp, $target_file)) {
        die("Failed to upload image.");
    }

    $profile_image_path = $target_file;
}

// Update users table for name and email
$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
$stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
if (!$stmt->execute()) {
    die("Error updating users table: " . htmlspecialchars($stmt->error));
}
$stmt->close();

// Check if profile exists
$checkStmt = $conn->prepare("SELECT user_id FROM user_profiles WHERE user_id = ?");
$checkStmt->bind_param("i", $user_id);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // Update existing profile
    if ($profile_image_path) {
        $updateStmt = $conn->prepare("UPDATE user_profiles SET phone=?, address=?, bio=?, dob=?, profile_image=? WHERE user_id=?");
        $updateStmt->bind_param("sssssi", $phone, $address, $bio, $dob, $profile_image_path, $user_id);
    } else {
        $updateStmt = $conn->prepare("UPDATE user_profiles SET phone=?, address=?, bio=?, dob=? WHERE user_id=?");
        $updateStmt->bind_param("ssssi", $phone, $address, $bio, $dob, $user_id);
    }
    if (!$updateStmt->execute()) {
        die("Error updating user_profiles table: " . htmlspecialchars($updateStmt->error));
    }
    $updateStmt->close();
} else {
    // Insert new profile
    $insertStmt = $conn->prepare("INSERT INTO user_profiles (user_id, phone, address, bio, dob, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("isssss", $user_id, $phone, $address, $bio, $dob, $profile_image_path);
    if (!$insertStmt->execute()) {
        die("Error inserting into user_profiles table: " . htmlspecialchars($insertStmt->error));
    }
    $insertStmt->close();
}
$checkStmt->close();

$conn->close();

header("Location: profile.php?success=1");
exit();
?>
>>>>>>> c2e25da (Initial commit: add all project files)
