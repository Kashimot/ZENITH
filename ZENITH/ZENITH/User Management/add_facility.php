<?php

// Check if the facility name is provided
if(isset($_POST['facilityName'])) {
    // Get the facility name from the POST data
    $facilityName = $_POST['facilityName'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'zenith');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the facility
    $sql = "INSERT INTO facilities (name) VALUES ('$facilityName')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Facility added successfully
        echo json_encode(array('success' => true));
    } else {
        // Error adding facility
        echo json_encode(array('success' => false, 'message' => 'Error adding facility: ' . $conn->error));
    }

    // Close the database connection
    $conn->close();
} else {
    // If facility name is not provided, return an error
    echo json_encode(array('success' => false, 'message' => 'Facility name is required'));
}

?>
