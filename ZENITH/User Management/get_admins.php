<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Enter your database password here
$dbname = "zenith";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select admins
$sql = "SELECT id, username FROM users WHERE is_admin = 1";

// Execute query
$result = $conn->query($sql);

// Check if any admins are found
if ($result->num_rows > 0) {
    // Fetch admins and store them in an array
    $admins = array();
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
    
    // Send JSON response with admins
    echo json_encode($admins);
} else {
    // No admins found
    echo json_encode(array());
}

// Close connection
$conn->close();
?>
