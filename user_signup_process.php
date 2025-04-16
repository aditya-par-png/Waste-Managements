<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input function
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize inputs
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password']; // Do NOT sanitize password to preserve characters

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['signup_error'] = "All fields are required.";
        header("Location: user_signup.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format.";
        header("Location: user_signup.php");
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE full_name = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = "Username or email already exists.";
        $stmt->close();
        header("Location: user_signup.php");
        exit();
    }
    $stmt->close();

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['signup_success'] = "Registration successful! Please log in.";
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['signup_error'] = "Error during registration: " . $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: user_signup.php");
        exit();
    }
} else {
    // If accessed without POST, redirect to signup form
    header("Location: user_signup.php");
    exit();
}
