<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the form is submitted for download
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["download"]) && isset($_POST["selectedFiles"])) {
    // Include database connection
    include_once 'db_connection.php';

    // Iterate through selected files and initiate download
    foreach ($_POST["selectedFiles"] as $fileId) {
        // Fetch file path from database
        $sql = "SELECT file_path FROM uploaded_files WHERE id = $fileId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['file_path'];

        // Force download the file
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($filePath) . "\"");
        readfile($filePath);
    }

    // Close database connection
    mysqli_close($conn);

    // Redirect back to the upload page
    header("Location: upload_page.php");
    exit;
} else {
    // If not submitted properly, redirect to upload page
    header("Location: upload_page.php");
    exit;
}
?>
