<?php
// Connect to the database
$servername = "localhost";
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "zenith";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total number of pending documents
$sql = "SELECT COUNT(*) AS pending_documents FROM documents WHERE status = 'pending'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pending_documents = $row["pending_documents"];

echo $pending_documents;

$conn->close();
?>
