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
if(isset($_POST['adminId'])) {
    $adminId = $_POST['adminId'];

    // Delete the admin's record from the database
    $sql = "DELETE FROM users WHERE id='$adminId' AND is_admin=1";
    if ($conn->query($sql) === TRUE) {
        echo "Admin deleted successfully";
    } else {
        echo "Error deleting admin: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
