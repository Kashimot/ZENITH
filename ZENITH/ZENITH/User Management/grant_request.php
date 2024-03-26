<?php

// Check if the request ID is provided
if(isset($_POST['requestId'])) {
    // Get the request ID from the POST data
    $requestId = $_POST['requestId'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'zenith');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to grant the request
    $sql = "UPDATE pending_requests SET status = 'granted' WHERE id = $requestId";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Request granted successfully
        echo json_encode(array('success' => true));
    } else {
        // Error occurred while granting the request
        echo json_encode(array('success' => false, 'message' => 'Error granting request: ' . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // If request ID is not provided, return an error
    echo json_encode(array('success' => false, 'message' => 'Request ID is required'));
}

?>
