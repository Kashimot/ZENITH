<?php
// Establish database connection (replace with your database credentials)
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

// Initialize total documents counter
$totalDocuments = 0;

// Query to fetch total documents for each department
$sql = "(
    SELECT COUNT(*) AS total_documents FROM facilities_department_documents
)
UNION ALL
(
    SELECT COUNT(*) AS total_documents FROM operations_department_documents
)
UNION ALL
(
    SELECT COUNT(*) AS total_documents FROM supply_department_documents
)
UNION ALL
(
    SELECT COUNT(*) AS total_documents FROM training_department_documents
)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $totalDocuments += $row["total_documents"];
    }
}

// Output the total documents for all departments combined
echo $totalDocuments;

// Close the database connection
$conn->close();
?>
