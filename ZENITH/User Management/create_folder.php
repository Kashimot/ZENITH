<?php
// Include database connection file
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $folder_name = $_POST["folder_name"];
    $parent_folder_id = isset($_POST["parent_folder"]) ? $_POST["parent_folder"] : null;

    // Prepare and execute SQL query to insert folder into the database
    $sql = "INSERT INTO folders (folder_name, parent_folder_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $folder_name, $parent_folder_id);

    if ($stmt->execute()) {
        // Folder inserted successfully
        echo "Folder created successfully.";
    } else {
        // Error occurred while inserting folder
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Redirect back to the form if accessed directly
    header("Location: create_folder_form.php");
    exit;
}

// Close database connection
$conn->close();
?>
