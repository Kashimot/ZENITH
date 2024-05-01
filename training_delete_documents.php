<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "zenith"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if document IDs are received
if(isset($_POST['documentIds'])) {
    $documentIds = $_POST['documentIds'];
    // Convert received IDs to comma-separated string for SQL query
    $documentIdsString = implode(",", $documentIds);

    // Delete documents from database
    $sql = "DELETE FROM  training_department_documents WHERE id IN ($documentIdsString)";
    if ($conn->query($sql) === TRUE) {
        echo count($documentIds) . " document(s) deleted successfully.";
    } else {
        echo "Error deleting documents: " . $conn->error;
    }
} else {
    echo "No document IDs received for deletion.";
}

// Close connection
$conn->close();
?>
