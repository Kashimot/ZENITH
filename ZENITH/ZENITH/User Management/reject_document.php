<?php
// Include database connection
include_once 'db_connection.php';

// Check if document ID and reason are provided
if (isset($_POST['documentId']) && isset($_POST['reason'])) {
    $documentId = $_POST['documentId'];
    $reason = $_POST['reason'];

    // Implement rejection logic here
    // Example: Update document status to rejected in the database

    // Return success response
    echo json_encode(array('success' => true, 'message' => 'Document rejected successfully'));
} else {
    // Return error response if required parameters are not provided
    echo json_encode(array('error' => 'Invalid request'));
}

// Close database connection
mysqli_close($conn);
?>
