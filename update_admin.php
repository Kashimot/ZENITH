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
if(isset($_POST['adminId']) && isset($_POST['newUsername']) && isset($_POST['newPassword'])) {
    // Escape user inputs for security
    $adminId = $conn->real_escape_string($_POST['adminId']);
    $newUsername = $conn->real_escape_string($_POST['newUsername']);
    // Hash the new password for security
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

    // Check if the new username already exists for other admins
    $sql_check_username = "SELECT * FROM users WHERE username = ? AND id != ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("si", $newUsername, $adminId);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    // If username exists for other admins, send error response
    if ($result_check_username->num_rows > 0) {
        echo "Username already exists for another admin";
    } else {
        // Update the admin's record in the database
        $sql = "UPDATE users SET username=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newUsername, $newPassword, $adminId);
        
        if ($stmt->execute()) {
            // If update is successful, send success response
            $response = array('message' => 'Admin details updated successfully');
            echo json_encode($response);
        } else {
            // If update fails, send error response
            $response = array('message' => 'Error updating admin details: ' . $stmt->error);
            echo json_encode($response);
        }

        // Close the prepared statement
        $stmt->close();
    }

    // Close statement and connection for checking username
    $stmt_check_username->close();
} else {
    // If form data is not submitted, send error response
    $response = array('message' => 'Form data not submitted');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
