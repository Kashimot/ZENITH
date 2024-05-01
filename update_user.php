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

    // Check if the new username already exists for other users
    $sql_check_username = "SELECT * FROM users WHERE username = ? AND id != ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("si", $newUsername, $userId);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    // If username exists for other users, display an error message
    if ($result_check_username->num_rows > 0) {
        echo "Username already exists for another user";
    } else {
        // Update the user's record in the database
        $sql = "UPDATE users SET username=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newUsername, $newPassword, $userId);
        
        if ($stmt->execute()) {
            echo "User details updated successfully";
        } else {
            echo "Error updating user details: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    }

    // Close statement and connection for checking username
    $stmt_check_username->close();
}

// Close connection
$conn->close();
?>
