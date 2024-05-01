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

// SQL query to fetch data from the facilities_uploaded_files table
$sql = "SELECT file_name, status, reason_for_rejection FROM facilities_uploaded_files";

// Execute the query
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die("Error fetching data: " . $conn->error);
}

// Array to store fetched data
$files = [];

if ($result->num_rows > 0) {
    // Fetch data row by row
    while($row = $result->fetch_assoc()) {
        // Add each row to the $files array
        $files[] = $row;
    }
} 

// Close database connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($files);
?>
