<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "waste_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wasteType = htmlspecialchars($_POST['waste-type']);
    $pickupDate = htmlspecialchars($_POST['pickup-date']);
    $pickupTime = htmlspecialchars($_POST['pickup-time']);
    $pickupRoute = htmlspecialchars($_POST['pickup-route']);

    // Save data to the database
    $sql = "INSERT INTO collection_schedule (area_name, day_of_week, time_slot, notes, driver_id, route_id, created_by_admin_id) 
            VALUES ('$pickupRoute', '$pickupDate', '$pickupTime', '$wasteType', NULL, NULL, NULL)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Your pickup request has been submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting your request. Please try again.');</script>";
    }
}

$conn->close();
?>
