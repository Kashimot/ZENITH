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

// Prepare and execute SQL query to fetch pending requests
$sql = "SELECT * FROM pending_requests WHERE status = 'pending'";
$result = $conn->query($sql);

// Initialize an empty array to store the results
$pendingRequests = array();

// Check if there are any pending requests
if ($result->num_rows > 0) {
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Append each row to the pendingRequests array
        $pendingRequests[] = $row;
    }
}

// Convert the pendingRequests array to JSON and output it
echo json_encode($pendingRequests);

// Close the database connection
$conn->close();
?>
