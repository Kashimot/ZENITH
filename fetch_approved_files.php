<?php
// Connect to your database
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "zenith   "; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch approved files
$sql = "SELECT file_name FROM approved_files";
$result = $conn->query($sql);

$approvedFiles = array();

// If there are results, fetch them into an array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $approvedFiles[] = $row["file_name"];
    }
}

// Close the connection
$conn->close();

// Return the list of approved files as JSON
echo json_encode($approvedFiles);
?>
