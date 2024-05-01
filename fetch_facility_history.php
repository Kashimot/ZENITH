<?php
// Establish database connection (replace with your database credentials)
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

// Pagination parameters
$recordsPerPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

// Calculate the starting record for the current page
$start = ($page - 1) * $recordsPerPage;

// Prepare SQL statement to fetch facility history with pagination
$sql = "SELECT date, facilityName, granted_by, rejected_by FROM facility_history LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start, $recordsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store facility history
$facilityHistory = array();

// Fetch facility history and add them to the array
while ($row = $result->fetch_assoc()) {
    $facility = array(
        'date' => $row['date'],
        'facilityName' => $row['facilityName'],
        'granted_by' => $row['granted_by'],
        'rejected_by' => $row['rejected_by'] // Include rejected_by column
    );
    $facilityHistory[] = $facility;
}

// Output facility history as JSON
echo json_encode($facilityHistory);

// Close statement and connection
$stmt->close();
$conn->close();
?>
