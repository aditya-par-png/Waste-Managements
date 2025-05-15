<?php
session_start();

$error = "";
$success = "";

// Check if coming from forget_password.php
if (!isset($_SESSION['otp_email']) || !isset($_SESSION['otp'])) {
    header("Location: forget_password.php");
    exit();
}

$email = $_SESSION['otp_email'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredOtp = trim($_POST["otp"]);

    if ($enteredOtp === strval($_SESSION['otp'])) {
        unset($_SESSION['otp']); // Clear OTP from session after successful verification
        $success = "OTP verified successfully! <a href='reset_password.php'>Click here to reset your password</a>";
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
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
            background: #007bff;
            border: none;
            color: white;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
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
