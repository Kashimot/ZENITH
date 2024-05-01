<?php
// Check if document ID is provided
if (isset($_POST['documentId'])) {
    // Get document ID from POST data
    $documentId = $_POST['documentId'];

    // Database connection parameters
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

    // Prepare and bind parameters
    $stmt = $conn->prepare("UPDATE facilities_uploaded_files SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $documentId);

    // Execute statement
    if ($stmt->execute()) {
        echo "Document approved successfully.";
    } else {
        echo "Error updating document status: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Document ID not provided.";
}
?>
