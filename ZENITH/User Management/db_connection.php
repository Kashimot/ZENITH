<?php
// Database configuration
$dbHost = "localhost"; // Host name
$dbUsername = "root"; // MySQL username
$dbPassword = ""; // MySQL password
$dbName = "zenith"; // Database name

// Create database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
