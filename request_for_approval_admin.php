<?php
// Check if file upload is successful
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    // File details
    $fileName = $_FILES['fileToUpload']['name'];
    $newFilename = $_POST['newFilename'];
    $urgency = $_POST['urgency'];
    $fileType = $_POST['fileType'];
    $department = $_POST['department'];
    $uploadDate = date('Y-m-d H:i:s'); // Current date and time

    // Move uploaded file to desired directory
    $uploadDir = "uploads/";
    $targetFilePath = $uploadDir . basename($fileName);
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath)) {
        // Read the content of the uploaded file
        $fileContent = file_get_contents($targetFilePath);

        if ($fileContent === false) {
            // Error reading file content
            echo "Error reading file content.";
        } else {
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

            // Prepare and bind the SQL statement
            $stmt = $conn->prepare("INSERT INTO facilities_uploaded_files (file_name, new_filename, urgency, file_type, department, upload_date, document_content) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fileName, $newFilename, $urgency, $fileType, $department, $uploadDate, $fileContent);

            // Execute the statement
            if ($stmt->execute()) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file: " . $stmt->error;
            }

            // Close statement and database connection
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "Failed to move file to destination directory.";
    }
} else {
    echo "File upload failed.";
}
?>
