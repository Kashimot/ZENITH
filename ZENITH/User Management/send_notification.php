<?php
// Establish database connection (replace with your database credentials)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve notification data from POST request
$recipient = $_POST['recipient'];
$message = $_POST['message'];

// Prepare SQL statement to insert notification into database
$sql = "INSERT INTO notifications (recipient, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $recipient, $message);

// Execute SQL statement
if ($stmt->execute()) {
    echo "Notification sent successfully";
} else {
    echo "Error sending notification: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
