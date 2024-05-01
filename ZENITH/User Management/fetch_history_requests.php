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

// Prepare SQL statement to fetch pending requests
$sql = "SELECT id, date, facility, requester, granted_by FROM pending_requests";
$result = $conn->query($sql);

// Initialize an array to store pending requests
$pendingRequests = array();

// Check if there are pending requests
if ($result->num_rows > 0) {
    // Fetch pending requests and add them to the array
    while ($row = $result->fetch_assoc()) {
        $pendingRequest = array(
            'id' => $row['id'],
            'date' => $row['date'],
            'facility' => $row['facility'],
            'requester' => $row['requester'],
            'grantedBy' => $row['granted_by'] // Add the grantedBy field
        );
        $pendingRequests[] = $pendingRequest;
    }
}

// Output pending requests as JSON
echo json_encode($pendingRequests);

// Close connection
$conn->close();
?>
