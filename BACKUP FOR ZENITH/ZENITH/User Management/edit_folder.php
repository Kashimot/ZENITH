<?php
// Include database connection file
include "db_connection.php";

// Check if the form is submitted and 'folder_id' key is set in $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["folder_id"])) {
    // Get folder ID and new name from the POST data
    $folder_id = $_POST["folder_id"];
    $new_name = $_POST["new_name"];

    // Prepare and execute SQL query to update folder name
    $sql = "UPDATE folders SET folder_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_name, $folder_id);

    if ($stmt->execute()) {
        // Folder name updated successfully
        echo "Folder name updated successfully.";
    } else {
        // Error occurred while updating folder name
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Redirect back if accessed directly or 'folder_id' is not set
    header("Location: create.php");
    exit;
}

// Close database connection
$conn->close();
?>
