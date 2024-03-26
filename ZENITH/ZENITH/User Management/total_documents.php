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

// Query to get the total number of documents
$sql = "SELECT COUNT(*) AS total_documents FROM documents";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_documents = $row["total_documents"];

echo $total_documents;

$conn->close();
?>
