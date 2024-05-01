<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "zenith"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['announcement'];
    $departments = implode(', ', $_POST['departments']); // Convert array to comma-separated string
    $created_at = date("Y-m-d H:i:s"); // Current timestamp

    // Prepare SQL statement to insert data into announcements table
    $sql = "INSERT INTO announcements (title, content, departments, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $title, $content, $departments, $created_at);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Announcement inserted successfully
        echo "Announcement sent successfully.";
    } else {
        // Error inserting announcement
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
