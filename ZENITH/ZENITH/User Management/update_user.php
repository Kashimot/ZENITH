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

// Check if the form is submitted
if(isset($_POST['userId']) && isset($_POST['newUsername']) && isset($_POST['newPassword'])) {
    $userId = $_POST['userId'];
    $newUsername = $_POST['newUsername'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Hash the new password

    // Update the user's record in the database
    $sql = "UPDATE users SET username='$newUsername', password='$newPassword' WHERE id='$userId'";
    if ($conn->query($sql) === TRUE) {
        echo "User details updated successfully";
    } else {
        echo "Error updating user details: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
