<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the form is submitted and the file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    // Process the uploaded document
    $targetDir = "uploads/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFile = $targetDir . $fileName;
    $uploadOk = 1;
    $documentFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedFormats = array("pdf", "doc", "docx");
    if (!in_array($documentFileType, $allowedFormats)) {
        echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Move the file to the target directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars($fileName). " has been uploaded.";

            // Store information about the uploaded document in the database
            // Connect to your database (replace 'hostname', 'username', 'password', and 'database' with your database credentials)
            $conn = new mysqli('localhost', 'root', '', 'zenith');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL statement to insert data into the table
            $stmt = $conn->prepare("INSERT INTO uploaded_files (file_name, original_name, file_path, uploaded_by) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fileName, $_FILES["fileToUpload"]["name"], $targetFile, $_SESSION['username']);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    // Handle the case where the form is not submitted properly
    echo "Invalid request.";
}
?>