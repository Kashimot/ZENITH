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
if(isset($_POST['newAdminUsername']) && isset($_POST['newAdminPassword'])) {
    $username = $_POST['newAdminUsername'];
    $password = password_hash($_POST['newAdminPassword'], PASSWORD_DEFAULT); // Hash the password

    // Query to insert new admin into the database
    $sql = "INSERT INTO users (username, password, is_admin) VALUES ('$username', '$password', 1)";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        $response = "New admin added successfully";
    } else {
        $response = "Error adding new admin: " . $conn->error;
    }

    echo $response;
}

// Close connection
$conn->close();
?>
