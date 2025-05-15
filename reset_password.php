<?php
session_start();

$success = "";
$error = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to DB
    $conn = new mysqli('localhost', 'root', '', 'waste_management_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Make sure email exists in session
    if (!isset($_SESSION['otp_email'])) {
        $error = "Session expired. Please request OTP again.";
    } else {
        $email = $_SESSION['otp_email'];
        $new_pass = $conn->real_escape_string($_POST['password']);
        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

        $update = $conn->query("UPDATE admins SET password = '$hashed' WHERE email = '$email'");

        if ($update) {
            $success = "Password changed successfully. <a href='login.php'>Login here</a>.";
            session_destroy();
        } else {
            $error = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .reset-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .reset-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .success, .error {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php else: ?>
            <form method="POST">
                <input type="password" name="password" placeholder="Enter new password" required>
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
