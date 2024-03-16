<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the form is submitted for deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["selectedFiles"])) {
    // Include database connection
    include_once 'db_connection.php';

    // Iterate through selected files and delete them from database and file system
    foreach ($_POST["selectedFiles"] as $fileId) {
        // Prepare statement to delete file from database
        $stmt = $conn->prepare("DELETE FROM uploaded_files WHERE id = ?");
        $stmt->bind_param("i", $fileId);
        $stmt->execute();
        $stmt->close();

        // Fetch file path to delete from file system
        $sql = "SELECT file_path FROM uploaded_files WHERE id = $fileId";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['file_path'];
        unlink($filePath); // Delete file from file system
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
