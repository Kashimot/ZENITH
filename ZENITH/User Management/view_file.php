<?php
// Include database connection
include_once 'db_connection.php';

// Check if document ID is provided
if (isset($_GET['documentId'])) {
    $documentId = $_GET['documentId'];

    // Fetch document content from the database
    $query = "SELECT content FROM documents WHERE id = $documentId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $content = $row['content'];

        // Return document content
        echo $content;
    } else {
        // Return error response if document not found
        echo json_encode(array('error' => 'Document not found'));
    }
} else {
    // Return error response if document ID is not provided
    echo json_encode(array('error' => 'Document ID is required'));
}

// Close database connection
mysqli_close($conn);
?>
