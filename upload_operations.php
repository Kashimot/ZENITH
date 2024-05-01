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

// File upload handling
$targetDir = "uploads/operations_department/"; // Directory to store uploaded files under facilities_department

// Ensure that the facilities_department folder exists, create it if not
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true); // Create facilities_department folder with full permissions
}

// Retrieve uploaded file information
$originalName = $_FILES["fileToUpload"]["name"];
$fileName = basename($originalName);
$tempFilePath = $_FILES["fileToUpload"]["tmp_name"];
$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

// Allow certain file formats
$allowedTypes = array('pdf', 'doc', 'docx', 'txt');
if (in_array($fileType, $allowedTypes)) {
    // Generate new filename
    $newFilename = isset($_POST['newFilename']) ? $_POST['newFilename'] : "";
    $newFileName = $newFilename !== "" ? $newFilename . '.' . $fileType : $fileName;

    // Move uploaded file to destination with new filename
    $targetFilePath = $targetDir . $newFileName;
    if (move_uploaded_file($tempFilePath, $targetFilePath)) {
        // Insert file details into database
        $uploadedBy = "User"; // Change this to reflect the actual user who uploaded the file
        $uploadDate = date("Y-m-d H:i:s");

        // Insert data into the database
        $sql = "INSERT INTO operations_department_documents (file_name, original_name, file_path, upload_date) 
                VALUES ('$newFileName', '$originalName', '$targetFilePath', '$uploadDate')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid file type.";
}

// Close connection
$conn->close();
?>
