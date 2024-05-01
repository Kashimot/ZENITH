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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve facility ID and requester from POST data
    $facilityId = $_POST['facilityId'];
    $requester = 'Facilities Department'; // Set requester as 'Facilities Department'
    $status = 'pending'; // Set initial status as pending
    
    // Retrieve the name of the facility based on the facility ID
    $facilityName = '';
    $sql_facility = "SELECT name FROM facilities WHERE id = ?";
    $stmt_facility = $conn->prepare($sql_facility);
    $stmt_facility->bind_param("i", $facilityId);
    $stmt_facility->execute();
    $stmt_facility->bind_result($facilityName);
    $stmt_facility->fetch();
    $stmt_facility->close();

    // Prepare SQL statement to insert the pending request
    $sql = "INSERT INTO pending_requests (facility, requester, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $facilityName, $requester, $status);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Facility request sent successfully";
    } else {
        echo "Error sending facility request: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>
