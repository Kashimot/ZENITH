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

// Prepare SQL statement to fetch notifications
$sql = "SELECT * FROM notifications ORDER BY sent_at DESC";
$result = $conn->query($sql);

// Output notifications as list items
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['message'] . '</li>';
    }
} else {
    echo '<li>No notifications found</li>';
}

// Close connection
$conn->close();
?>
