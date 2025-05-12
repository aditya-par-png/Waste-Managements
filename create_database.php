<?php
$servername = "localhost"; //your server host
$username = "root";        //MySQL username
$password = "";            //MySQL password
$db = "waste_management_system"; //database name

// Connect to MySQL
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) === TRUE) {
    echo "Database '$db' created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database using the $db variable
$conn->select_db($db);

// USERS table
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    dob DATE DEFAULT NULL,
    profile_image TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

$conn->query("
CREATE TABLE IF NOT EXISTS user_profiles (
    user_id INT PRIMARY KEY,
    phone VARCHAR(20) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    dob DATE DEFAULT NULL,
    profile_image TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// ADMINS table
$conn->query("
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// ROUTES table
$conn->query("
CREATE TABLE IF NOT EXISTS routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    route_name VARCHAR(100) NOT NULL,
    area_covered TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// Insert Kathmandu routes
$kathmandu_routes = array(
    array("route_name" => "Route A", "area_covered" => "Koteshwor - Baneswor - Chabahil - Mulpani - Koteshwor"),
    array("route_name" => "Route B", "area_covered" => "Mulpani - Chabahil - Baneswor - Koteshwor - Mulpani"),
    array("route_name" => "Route C", "area_covered" => "Chabahil - Baneswor - Koteshwor - Mulpani - Chabahil"),
    array("route_name" => "Route D", "area_covered" => "Koteshwor - Chahil - Baneswor - Mulpani - Koteshwor")
);

foreach ($kathmandu_routes as $route) {
    $route_name = $conn->real_escape_string($route['route_name']);
    $area_covered = $conn->real_escape_string($route['area_covered']);

    // Use INSERT IGNORE to avoid duplicates on reruns
    $sql = "INSERT IGNORE INTO routes (route_name, area_covered) VALUES ('$route_name', '$area_covered')";

    if ($conn->query($sql) === TRUE) {
        echo "Route '$route_name' added successfully.<br>";
    } else {
        echo "Error adding route '$route_name': " . $conn->error . "<br>";
    }
}

// DRIVERS table
$conn->query("
CREATE TABLE IF NOT EXISTS drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// TRUCKS table (NEW)
$conn->query("
CREATE TABLE IF NOT EXISTS trucks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    truck_id VARCHAR(50) NOT NULL UNIQUE,
    driver VARCHAR(100) NOT NULL,
    status ENUM('Active', 'Idle', 'Maintenance') NOT NULL DEFAULT 'Idle',
    location VARCHAR(255) NOT NULL,
    next_pickup VARCHAR(50) DEFAULT '--',
    available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

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
    FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (created_by_admin_id) REFERENCES admins(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// RECYCLING TIPS table
$conn->query("
CREATE TABLE IF NOT EXISTS recycling_tips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// HELP REQUESTS table
$conn->query("
CREATE TABLE IF NOT EXISTS help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// USER FEEDBACK table
$conn->query("
CREATE TABLE IF NOT EXISTS user_feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    feedback TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// PICKUP REQUESTS table with added driver and vehicle columns
$conn->query("
CREATE TABLE IF NOT EXISTS pickup_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    waste_type VARCHAR(50) NOT NULL,
    pickup_date DATE NOT NULL,
    pickup_time TIME NOT NULL,
    pickup_route VARCHAR(255) NOT NULL,
    driver VARCHAR(100) DEFAULT NULL,
    vehicle VARCHAR(100) DEFAULT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

// ASSIGNED REQUESTS table
$conn->query("
CREATE TABLE IF NOT EXISTS assigned_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT,
    driver VARCHAR(100),
    vehicle VARCHAR(100),
    route VARCHAR(100),
    waste_type VARCHAR(100),
    pickup_date DATE,
    pickup_time TIME,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES pickup_requests(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
") or die($conn->error);

echo "All tables created successfully.";

$conn->close();
?>
