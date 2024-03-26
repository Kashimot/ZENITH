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

// Check if document ID and comments are provided
if(isset($_POST['documentId']) && isset($_POST['comments'])) {
    $documentId = $_POST['documentId'];
    $comments = $_POST['comments'];

    // Add comments to the database
    $sql = "INSERT INTO document_comments (document_id, comments) VALUES ('$documentId', '$comments')";
    if ($conn->query($sql) === TRUE) {
        // Comments added successfully
        echo json_encode(array("status" => "success", "message" => "Comments added successfully"));
    } else {
        // Error adding comments
        echo json_encode(array("status" => "error", "message" => "Error adding comments: " . $conn->error));
    }
} else {
    // Document ID or comments not provided
    echo json_encode(array("status" => "error", "message" => "Document ID or comments not provided"));
}

// Close connection
$conn->close();
?>
