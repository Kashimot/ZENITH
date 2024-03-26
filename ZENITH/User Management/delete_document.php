<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Check if document ID is provided via POST request
if (isset($_POST['document_id'])) {
    $documentId = $_POST['document_id'];

    try {
        // Establish database connection using PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute SQL query to delete document
        $query = "DELETE FROM documents WHERE id = :document_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':document_id', $documentId, PDO::PARAM_INT);
        $statement->execute();

        // Check if document was deleted successfully
        if ($statement->rowCount() > 0) {
            echo json_encode(array('success' => 'Document deleted successfully'));
        } else {
            echo json_encode(array('error' => 'Document not found'));
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo json_encode(array('error' => 'Failed to delete document'));
    }
} else {
    // Error message if document ID is not provided
    echo json_encode(array('error' => 'Document ID not provided'));
}
?>
