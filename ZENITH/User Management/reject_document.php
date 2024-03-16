<?php
// Assuming you have a database connection established
// Handle rejection of the document with comments

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve document ID and reason for rejection from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input
    if (isset($data['documentId']) && isset($data['reason'])) {
        $documentId = $data['documentId'];
        $reason = $data['reason'];
        
        // Here, you would update your database with the rejection reason for the document with the provided ID
        // Replace this with your actual database update query
        
        // Send a success response
        echo "Document with ID $documentId rejected successfully with reason: $reason";
    } else {
        // If document ID or reason is not provided, return an error response
        http_response_code(400);
        echo "Error: Document ID or reason is missing.";
    }
} else {
    // If the request method is not POST, return an error response
    http_response_code(405);
    echo "Error: Method not allowed.";
}
?>
