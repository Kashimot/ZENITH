<?php
// Establish database connection (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenith"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if facility name is set in the POST data
if (isset($_POST['facilityName'])) {
    $facilityName = $_POST['facilityName'];

    // Prepare SQL statement to insert facility into the database
    $sql = "INSERT INTO facilities (name) VALUES (?)";

    // Create prepared statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $facilityName);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Facility added successfully";
    } else {
        echo "Error adding facility: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Facility name not provided";
}
?>
