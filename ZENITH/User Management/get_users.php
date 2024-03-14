<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenith";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all regular users from the database
$sql = "SELECT id, username FROM users WHERE is_admin = 0"; // Filter regular users
$result = $conn->query($sql);

$userList = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $userList[] = array(
            'id' => $row['id'],
            'username' => $row['username']
        );
    }
}

// Return JSON response
echo json_encode($userList);

// Close connection
$conn->close();
?>
