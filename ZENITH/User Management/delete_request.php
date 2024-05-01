<?php
// Establish database connection
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

// Check if the request ID is provided via POST
if (isset($_POST['requestId'])) {
    // Sanitize the input to prevent SQL injection
    $requestId = $_POST['requestId'];

    // Prepare SQL statement to delete the request
    $sql = "DELETE FROM pending_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $requestId);

    // Execute the statement
    if ($stmt->execute()) {
        // Request deleted successfully
        echo "Request deleted successfully";
    } else {
        // Error occurred while deleting request
        echo "Error deleting request: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Request ID not provided
    echo "Request ID not provided";
}
?>
