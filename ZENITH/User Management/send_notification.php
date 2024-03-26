<?php
// Include your database connection file
include 'db_connection.php';

// Function to insert notification into the database
function sendNotification($recipient, $message) {
    global $conn; // Assuming $conn is your database connection object

    // SQL statement to insert notification
    $sql = "INSERT INTO notifications (recipient, message, created_at) VALUES (?, ?, NOW())";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false; // Failed to prepare statement
    }

    // Bind parameters and execute statement
    $stmt->bind_param("ss", $recipient, $message);
    $result = $stmt->execute();
    
    // Check if the execution was successful
    if ($result) {
        return true; // Notification sent successfully
    } else {
        return false; // Failed to send notification
    }
}
?>
