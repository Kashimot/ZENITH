<?php
// Database connection
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

// Pagination parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10; // Number of documents per page

// Calculate offset
$offset = ($page - 1) * $limit;

// Fetch documents from the database with pagination
$sql = "SELECT id, original_name, upload_date FROM supply_department_documents LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$documents = array();

if ($result) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Construct document object
        $document = array(
            "id" => $row["id"],
            "original_name" => $row["original_name"],
            "upload_date" => $row["upload_date"]
        );

        // Add document to documents array
        $documents[] = $document;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$stmt->close();
$conn->close();

// Output documents array as JSON
echo json_encode($documents);
?>
