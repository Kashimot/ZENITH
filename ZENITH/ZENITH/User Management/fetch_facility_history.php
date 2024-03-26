<?php

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'zenith');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to fetch facility history
$sql = "SELECT date, facility_name FROM facility_history";

// Execute the SQL statement
$result = $conn->query($sql);

// Initialize an empty array to store facility history data
$facilityHistory = array();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch each row and add it to the facility history array
    while ($row = $result->fetch_assoc()) {
        $facilityHistory[] = $row;
    }
} else {
    // No facility history found
    echo json_encode(array('success' => false, 'message' => 'No facility history found'));
}

// Close the database connection
$conn->close();

// Return the facility history data as JSON
echo json_encode($facilityHistory);

?>
