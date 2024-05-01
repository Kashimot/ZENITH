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

// Fetch documents from the database
$sql = "SELECT * FROM operations_department_documents";
$result = $conn->query($sql);

// Output data
$documents = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $documents[] = $row;
    }
}

// Close connection
$conn->close();

// Return documents as JSON
echo json_encode($documents);
?>
