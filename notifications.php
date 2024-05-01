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
$recipients = $_POST['recipient']; // Array of selected recipients
$message = $_POST['message'];

// Prepare SQL statement to insert notifications into database
$sql = "INSERT INTO notifications (recipient, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters and execute the statement for each recipient
foreach ($recipients as $recipient) {
    $stmt->bind_param("ss", $recipient, $message);
    if ($stmt->execute()) {
        // Notification sent successfully
        echo "Notification sent successfully to $recipient<br>";
    } else {
        // Error sending notification
        echo "Error sending notification to $recipient: " . $conn->error . "<br>";
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
