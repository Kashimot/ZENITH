<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password is set for root user
$dbname = "zenith";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$newUserUsername = $_POST['newUserUsername'];
$newUserPassword = $_POST['newUserPassword'];

// Insert new user into the database
$sql = "INSERT INTO users (username, password) VALUES ('$newUserUsername', '$newUserPassword')";

if ($conn->query($sql) === TRUE) {
    echo "New user added successfully";
} else {
    echo "Error adding new user: " . $conn->error;
}

// Close connection
$conn->close();
?>
