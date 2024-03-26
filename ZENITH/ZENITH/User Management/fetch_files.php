<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch files for Facilities Management
$facilitiesManagementFiles = fetchFilesByDepartment($conn, 'Facilities Management');

// Fetch files for Operations Department
$operationsFiles = fetchFilesByDepartment($conn, 'Operations Department');

// Fetch files for Training Department
$trainingFiles = fetchFilesByDepartment($conn, 'Training Department');

// Fetch files for Supply Department
$supplyFiles = fetchFilesByDepartment($conn, 'Supply Department');

// Function to fetch files by department
function fetchFilesByDepartment($conn, $department) {
    $sql = "SELECT id, filename, filepath FROM files WHERE department = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();
    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
    return $files;
}

// Close connection
$conn->close();
?>
