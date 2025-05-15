<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// If user is not coming from signup page, redirect
if (!isset($_SESSION['email'])) {
    header("Location: user_signup.php");
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredOtp = trim($_POST["otp"]);

    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedOtp, $otpExpiry);
    $stmt->fetch();
    $stmt->close();

    if ($storedOtp == $enteredOtp) {
        $currentTime = date("Y-m-d H:i:s");
        if ($currentTime <= $otpExpiry) {
            // Mark account as verified (you may want to add a 'verified' column in your users table)
            $stmt = $conn->prepare("UPDATE users SET otp = NULL, otp_expiry = NULL WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $success = "Email verified successfully! <a href='login.php'>Login now</a>";
            unset($_SESSION['email']);
        } else {
            $error = "OTP has expired. Please sign up again.";
        }
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - Marshall Waste Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .otp-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 350px;
        }
        .otp-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            background: #28a745;
            border: none;
            color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="otp-container">
    <h2>Verify OTP</h2>
    <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="success-message"><?= $success ?></div>
    <?php else: ?>
        <form method="POST">
            <div class="input-group">
                <input type="text" name="otp" placeholder="Enter OTP" required />
            </div>
            <button type="submit">Verify</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
