<?php

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'zenith');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to fetch pending requests
$sql = "SELECT facility, requester, id FROM pending_requests";

// Execute the SQL statement
$result = $conn->query($sql);

// Initialize an empty array to store pending requests data
$pendingRequests = array();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch each row and add it to the pending requests array
    while ($row = $result->fetch_assoc()) {
        $pendingRequests[] = $row;
    }
} else {
    // No pending requests found
    echo json_encode(array('success' => false, 'message' => 'No pending requests found'));
}

// Close the database connection
$conn->close();

// Return the pending requests data as JSON
echo json_encode($pendingRequests);

?>
