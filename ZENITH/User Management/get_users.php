<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Enter your database password here
$dbname = "zenith";

// Pagination parameters
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1
$offset = ($page - 1) * $limit; // Offset calculation

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select users (excluding admins) with their department information, with pagination
$sql = "SELECT id, username, department, is_admin 
        FROM users 
        WHERE is_admin = 0
        LIMIT $limit OFFSET $offset";

// Execute query
$result = $conn->query($sql);

// Check if any users are found
if ($result->num_rows > 0) {
    // Fetch users and store them in an array
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    // Send JSON response with users
    echo json_encode($users);
} else {
    // No users found
    echo json_encode(array());
}

// Close connection
$conn->close();
?>
