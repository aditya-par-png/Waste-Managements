<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function to sanitize input
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// User Login
if (isset($_POST['userLogin'])) {
    $userUsername = sanitize($_POST['userUsername']);
    $userPassword = $_POST['userPassword']; // Password should not be sanitized to preserve characters

    $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE full_name = ? OR email = ?");
    $stmt->bind_param("ss", $userUsername, $userUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify hashed password
        if (password_verify($userPassword, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: home.html");
            exit();
        } else {
            $error = "Invalid password for User.";
        }
    } else {
        $error = "User not found.";
    }

    header("Location: login.html?user_error=" . urlencode($error));
    exit();
}

// Admin Login
if (isset($_POST['adminLogin'])) {
    $adminUsername = sanitize($_POST['adminUsername']);
    $adminPassword = $_POST['adminPassword'];

    $stmt = $conn->prepare("SELECT id, username, email, password FROM admins WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $adminUsername, $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin) {
        if (password_verify($adminPassword, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: homeadmin.html");
            exit();
        } else {
            $error = "Invalid password for Admin.";
        }
    } else {
        $error = "Admin not found.";
    }

    header("Location: login.html?admin_error=" . urlencode($error));
    exit();
}

$conn->close();
?>
