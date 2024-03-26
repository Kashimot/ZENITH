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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['newUserUsername'];
    $password = password_hash($_POST['newUserPassword'], PASSWORD_DEFAULT);
    $department = $_POST['newUserDepartment'];
    $added_by_admin = "admin"; // Change this according to your logic
    $is_admin = ($department == '5') ? 1 : 0; // Check if user is an admin

    // Prepare SQL statement
    $sql = "INSERT INTO user (username, password, added_by_admin, is_admin) VALUES (?, ?, ?, ?)";
    
    // Create prepared statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $password, $added_by_admin, $is_admin);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
