<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    // File upload directory
    $targetDir = "uploads/";

    // Initialize an array to store uploaded file names
    $uploadedFiles = [];

    // Loop through each uploaded file
    foreach ($_FILES["fileToUpload"]["name"] as $key => $fileName) {
        // Get the temporary file path
        $tmpFilePath = $_FILES["fileToUpload"]["tmp_name"][$key];

        // Check if the file is uploaded successfully
        if ($tmpFilePath != "") {
            // Generate a unique file name to avoid overwriting existing files
            $targetFilePath = $targetDir . uniqid() . "_" . basename($fileName);

            // Move the file to the upload directory
            if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
                // Add the uploaded file name to the array
                $uploadedFiles[] = htmlspecialchars(basename($fileName));
            } else {
                // Error message if file upload fails
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Check if any files were uploaded
    if (!empty($uploadedFiles)) {
        // Display success message with the list of uploaded files
        echo "The following files have been uploaded successfully:<br>";
        foreach ($uploadedFiles as $file) {
            echo "- $file<br>";
        }
    } else {
        // Error message if no files were uploaded
        echo "No files were uploaded.";
    }
} else {
    // Redirect back if accessed directly
    header("Location: send_document.html");
    exit;
}
?>
