<?php
// Establish database connection (replace with your database credentials)
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

// Retrieve notification data from POST request
$recipient = $_POST['recipient'];
$message = $_POST['message'];

// Prepare SQL statement to insert notification into database
$sql = "INSERT INTO notifications (recipient, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $recipient, $message);

// Execute SQL statement based on the recipient department
if ($recipient === 'facilities_management' ||
    $recipient === 'operations_department' ||
    $recipient === 'training_department' ||
    $recipient === 'supply_department') {
    if ($stmt->execute()) {
        echo "Notification sent successfully to " . $recipient;
    } else {
        echo "Error sending notification: " . $conn->error;
    }
} else {
    echo "Invalid recipient department";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
