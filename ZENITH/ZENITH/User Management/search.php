<?php
// Include database connection file
include "db_connection.php";

// Check if the search query is provided
if (isset($_POST["searchQuery"])) {
    // Get the search query
    $searchQuery = $_POST["searchQuery"];

    // Prepare and execute SQL query to search for files
    $sql = "SELECT filename FROM files WHERE filename LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchPattern = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $searchPattern);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to store search results
    $searchResults = array();

    // Fetch search results and add them to the array
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row["filename"];
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Return search results as JSON
    header('Content-Type: application/json');
    echo json_encode($searchResults);
} else {
    // Return error if search query is not provided
    echo json_encode(array("status" => "error", "message" => "Search query not provided."));
}
?>
