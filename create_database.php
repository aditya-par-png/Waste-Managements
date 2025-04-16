<?php
$servername = "localhost"; // your server host
$username = "root";        // your MySQL username
$password = "";            // your MySQL password
$db = "waste_management_system"; // Your database name

// Connect to MySQL
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if ($conn->query($sql) === TRUE) {
    echo "Database '$db' created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database using the $db variable
$conn->select_db($db);

// USERS table
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") or die($conn->error);

// ADMINS table
$conn->query("
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") or die($conn->error);

// ROUTES table
$conn->query("
CREATE TABLE IF NOT EXISTS routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    route_name VARCHAR(100) NOT NULL,
    area_covered TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") or die($conn->error);

// Insert Kathmandu routes
$kathmandu_routes = array(
    array("route_name" => "Ring Road", "area_covered" => "All areas along the Ring Road"),
    array("route_name" => "Thamel", "area_covered" => "Thamel area"),
    array("route_name" => "Patan", "area_covered" => "Patan area"),
    array("route_name" => "Bhaktapur", "area_covered" => "Bhaktapur area")
);

foreach ($kathmandu_routes as $route) {
    $route_name = $conn->real_escape_string($route['route_name']);
    $area_covered = $conn->real_escape_string($route['area_covered']);

    $sql = "INSERT INTO routes (route_name, area_covered) VALUES ('$route_name', '$area_covered')";

    if ($conn->query($sql) === TRUE) {
        echo "Route '$route_name' added successfully.<br>";
    } else {
        echo "Error adding route '$route_name': " . $conn->error;
    }
}

// DRIVERS table
$conn->query("
CREATE TABLE IF NOT EXISTS drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    license_number VARCHAR(50) NOT NULL,
    assigned_route_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_route_id) REFERENCES routes(id)
)") or die($conn->error);

// COLLECTION SCHEDULE table
$conn->query("
CREATE TABLE IF NOT EXISTS collection_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    area_name VARCHAR(100) NOT NULL,
    day_of_week VARCHAR(20) NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    notes TEXT,
    driver_id INT,
    route_id INT,
    created_by_admin_id INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES drivers(id),
    FOREIGN KEY (route_id) REFERENCES routes(id),
    FOREIGN KEY (created_by_admin_id) REFERENCES admins(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)") or die($conn->error);


// RECYCLING TIPS table
$conn->query("
CREATE TABLE IF NOT EXISTS recycling_tips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") or die($conn->error);

// HELP REQUESTS table
$conn->query("
CREATE TABLE IF NOT EXISTS help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)") or die($conn->error);

// USER FEEDBACK table
$conn->query("
CREATE TABLE IF NOT EXISTS user_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    feedback TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)") or die($conn->error);

echo "All tables created successfully.";

$conn->close();
?>
