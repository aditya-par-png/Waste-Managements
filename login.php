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

// User Login
if (isset($_POST['userLogin'])) {
    $userUsername = $_POST['userUsername'];
    $userPassword = $_POST['userPassword'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE full_name = ? OR email = ?");
    $stmt->bind_param("ss", $userUsername, $userUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // If you store hashed passwords, use password_verify()
    if ($user && $userPassword == $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: home.html");
        exit();
    } else {
        echo "<script>alert('Invalid credentials for User.'); window.location.href='login.html';</script>";
        exit();
    }
}

// Admin Login
if (isset($_POST['adminLogin'])) {
    $adminUsername = $_POST['adminUsername'];
    $adminPassword = $_POST['adminPassword'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $adminUsername, $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // If you store hashed passwords, use password_verify()
    if ($admin && $adminPassword == $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: homeadmin.html");
        exit();
    } else {
        echo "<script>alert('Invalid credentials for Admin.'); window.location.href='login.html';</script>";
        exit();
    }
}

$conn->close();
?>
