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

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['signup_error'] = "All fields are required.";
        header("Location: admin_signup.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format.";
        header("Location: admin_signup.php");
        exit();
    }

    // Check for existing username or email
    $stmt = $conn->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['signup_error'] = "Username or email already exists.";
        $stmt->close();
        header("Location: admin_signup.php");
        exit();
    }
    $stmt->close();

    // REMOVE THIS LINE - NO NEED TO HASH
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
    // CHANGE THIS LINE to use the plain password
    $stmt->bind_param("sss", $username, $email, $password);

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
        header("Location: admin_signup.php");
        exit();
    }
} else {
    header("Location: admin_signup.php");
    exit();
}
?>