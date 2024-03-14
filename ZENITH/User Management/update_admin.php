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

// Check if the form data is submitted
if(isset($_POST['newUsername']) && isset($_POST['newPassword'])) {
    // Escape user inputs for security
    $newUsername = $conn->real_escape_string($_POST['newUsername']);
    // Hash the new password for security
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

    // Update the admin's record in the database
    $sql = "UPDATE users SET username='$newUsername', password='$newPassword' WHERE username='admin'";
    if ($conn->query($sql) === TRUE) {
        // If update is successful, send success response
        $response = array('status' => 'success', 'message' => 'Admin details updated successfully');
        echo json_encode($response);
    } else {
        // If update fails, send error response
        $response = array('status' => 'error', 'message' => 'Error updating admin details: ' . $conn->error);
        echo json_encode($response);
    }
} else {
    // If form data is not submitted, send error response
    $response = array('status' => 'error', 'message' => 'Form data not submitted');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
