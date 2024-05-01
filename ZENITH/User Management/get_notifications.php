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

// Prepare SQL statement to fetch latest notifications with a limit of 10
$sql = "SELECT * FROM notifications ORDER BY sent_at DESC LIMIT 1";
$result = $conn->query($sql);

// Initialize an array to store notifications
$notifications = array();

// Check if there are notifications
if ($result->num_rows > 0) {
    // Fetch notifications and add them to the array
    while ($row = $result->fetch_assoc()) {
        $notification = array(
            'id' => $row['id'],
            'message' => $row['message'],
            'sent_at' => $row['sent_at']
        );
        $notifications[] = $notification;
    }
}

// Output notifications as JSON
echo json_encode($notifications);

// Close connection
$conn->close();
?>
