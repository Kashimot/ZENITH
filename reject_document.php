<?php
// Check if document ID and reason for rejection are provided
if (isset($_POST['documentId']) && isset($_POST['reason'])) {
    // Get document ID and reason for rejection from POST data
    $documentId = $_POST['documentId'];
    $reason = $_POST['reason'];

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

    // Update rejection status and reason in the database
    $sql = "UPDATE facilities_uploaded_files SET status = 'rejected', reason_for_rejection = '$reason' WHERE id = $documentId";

    if ($conn->query($sql) === TRUE) {
        echo "Document rejected successfully.";
    } else {
        echo "Error updating document status: " . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    echo "Document ID or reason for rejection not provided.";
}
?>
