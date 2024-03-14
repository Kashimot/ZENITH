<?php
// Include database connection file
include "db_connection.php";

// Check if the form is submitted and 'folder_id' key is set in $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["folder_id"])) {
    // Get folder ID from the POST data
    $folder_id = $_POST["folder_id"];

    // Prepare and execute SQL query to delete folder
    $sql = "DELETE FROM folders WHERE folder_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $folder_id);

    if ($stmt->execute()) {
        // Folder deleted successfully
        echo json_encode(array("status" => "success", "message" => "Folder deleted successfully."));
    } else {
        // Error occurred while deleting folder
        echo json_encode(array("status" => "error", "message" => "Error deleting folder: " . $stmt->error));
    }

    // Close statement
    $stmt->close();
} else {
    // Return error if 'folder_id' is not set
    echo json_encode(array("status" => "error", "message" => "Folder ID not provided."));
}

// Close database connection
$conn->close();
?>
