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

// Fetch file details from the database based on provided ID
$fileId = isset($_GET['id']) ? $_GET['id'] : 0;
$sql = "SELECT file_name, original_name, file_path FROM training_department_documents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $fileId);
$stmt->execute();
$stmt->store_result();

// Execute the SQL query
if (!$stmt->execute()) {
    die('Error executing query: ' . $stmt->error);
}

// Fetch file details
$stmt->bind_result($fileName, $originalName, $filePath);
if ($stmt->fetch()) {
    // Set headers for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $originalName . '"');
    header('Content-Length: ' . filesize($filePath));

    // Read the file and output it to the browser
    readfile($filePath);
} else {
    // File not found in the database
    echo 'File not found in the database for ID: ' . $fileId;
}
$stmt->close();
$conn->close();
?>
