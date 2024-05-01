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

// Handle file upload
$newFilename = $_POST['newFilename']; // New filename entered by the user
$fileToUpload = $_FILES['fileToUpload'];
$urgency = $_POST['urgency']; // Urgency level selected by the user
$fileType = $_POST['fileType']; // File type selected by the user

$originalFileName = $fileToUpload['name'];
$uploadDate = date("Y-m-d H:i:s");

// Determine the filename to use
$targetDir = "uploads/";
if (!empty($newFilename)) {
    $targetFile = $targetDir . basename($newFilename); // Use the new filename
} else {
    $targetFile = $targetDir . basename($originalFileName); // Use the original filename
}

// Upload file to server
if (move_uploaded_file($fileToUpload["tmp_name"], $targetFile)) {
    // File uploaded successfully, now insert file details into database
    $sql = "INSERT INTO files (file_name, original_name, upload_date, urgency, file_type) 
            VALUES ('$targetFile', '$originalFileName', '$uploadDate', '$urgency', '$fileType')";

    if ($conn->query($sql) === TRUE) {
        // Return the inserted file details as JSON response
        $response = array(
            "original_name" => $originalFileName,
            "urgency" => $urgency,
            "file_type" => $fileType
        );
        echo json_encode($response);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error uploading file";
}

// Close database connection
$conn->close();
?>
