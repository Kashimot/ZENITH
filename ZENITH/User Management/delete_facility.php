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

// Check if facility ID is set in the POST data
if (isset($_POST['id'])) {
    $facilityId = $_POST['id'];

    // Prepare SQL statement to delete the facility
    $sql = "DELETE FROM facilities WHERE id = ?";

    // Create prepared statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $facilityId);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Facility deleted successfully";
    } else {
        echo "Error deleting facility: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Facility ID not provided";
}
?>
