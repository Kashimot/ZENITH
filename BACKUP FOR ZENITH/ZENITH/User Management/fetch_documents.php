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
$sql = "SELECT id, name FROM documents";
$result = $conn->query($sql);

$documents = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $documents[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}

// Return JSON response
echo json_encode($documents);

// Close connection
$conn->close();
?>
