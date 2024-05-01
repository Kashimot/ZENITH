<?php
// Database connection parameters
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

// Fetch documents from the database
$sql = "SELECT id, file_name FROM facilities_department_documents";
$result = $conn->query($sql);

$documents = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Build document object
        $document = array(
            'id' => $row['id'],
            'file_name' => $row['file_name']
        );
        // Add document to the array
        $documents[] = $document;
    }
} else {
    // No documents found
    echo json_encode(array());
}

// Close database connection
$conn->close();

// Output documents in JSON format
echo json_encode($documents);
?>
