<?php
// Function to retrieve file content based on file path
function getFileContent($filePath) {
    // Check if the file exists
    if (file_exists($filePath)) {
        // Read and return file content
        return file_get_contents($filePath);
    } else {
        // File not found
        return false;
    }
}

// Check if file ID is provided in the request
if (isset($_GET['file_id'])) {
    // Get the file ID from the request
    $fileId = $_GET['file_id'];

    // Retrieve file information from the database based on the file ID
    // Assuming you have a database connection established

    // Sample database query (replace with your actual query)
    $query = "SELECT file_path FROM files WHERE id = $fileId";

    // Execute the query and fetch file path
    // Assuming $conn is your database connection
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $filePath = $row['file_path'];

        // Retrieve file content
        $fileContent = getFileContent($filePath);

        // Output file content if retrieved successfully
        if ($fileContent !== false) {
            // Set appropriate content type for the file (e.g., PDF, image, text)
            header('Content-Type: application/pdf'); // Change as needed

            // Optionally, you can specify content disposition to force download or inline viewing
            // header('Content-Disposition: attachment; filename="filename.pdf"'); // Force download
            // header('Content-Disposition: inline; filename="filename.pdf"'); // Inline viewing

            // Output file content
            echo $fileContent;
            exit();
        } else {
            // File not found or unable to read
            echo 'File not found or unable to read.';
        }
    } else {
        // No file found with the provided ID
        echo 'No file found with the provided ID.';
    }
} else {
    // File ID not provided in the request
    echo 'File ID not provided.';
}
?>
