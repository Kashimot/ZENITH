<?php

// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "zenith"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rejected documents from the database
$sql = "SELECT name, url FROM rejected_documents";
$result = $conn->query($sql);

$rejectedDocuments = array();

if ($result->num_rows > 0) {
    // Fetch each row from the result set
    while($row = $result->fetch_assoc()) {
        // Add document details to the array
        $rejectedDocuments[] = array(
            'name' => $row['name'],
            'url' => $row['url']
        );
    }
}

// Close database connection
$conn->close();

// Encode the rejected documents array as JSON
$rejectedDocumentsJSON = json_encode($rejectedDocuments);

// Set the response header to indicate JSON content
header('Content-Type: application/json');

// Echo the JSON response
echo $rejectedDocumentsJSON;

?>
