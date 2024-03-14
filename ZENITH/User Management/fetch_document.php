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

// Check if document ID is provided
if(isset($_GET['id'])) {
    $documentId = $_GET['id'];

    // Fetch document details from the database
    $sql = "SELECT * FROM documents WHERE id='$documentId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch document details as an associative array
        $document = $result->fetch_assoc();

        // Return JSON response with document details
        echo json_encode($document);
    } else {
        // Document not found
        echo json_encode(array("error" => "Document not found"));
    }
} else {
    // Document ID not provided
    echo json_encode(array("error" => "Document ID not provided"));
}

// Close connection
$conn->close();
?>
