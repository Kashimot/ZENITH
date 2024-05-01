<?php
// Database connection
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

// Fetch POST data
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to check for duplicate user
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows are returned (duplicate user)
if ($result->num_rows > 0) {
    echo 'duplicate';
} else {
    echo 'not_duplicate';
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
