<?php
// Include database connection file
include "db_connection.php";

// Initialize array to store folder data
$folders = [];

// Prepare and execute SQL query to fetch folders
$sql = "SELECT * FROM folders";
$result = $conn->query($sql);

// Check if query was successful
if ($result && $result->num_rows > 0) {
    // Fetch each row of data and add it to the $folders array
    while ($row = $result->fetch_assoc()) {
        $folders[] = $row;
    }
}

// Close database connection
$conn->close();

// Send JSON response
header("Content-Type: application/json");
echo json_encode($folders);
?>
