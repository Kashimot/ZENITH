<?php
// Check if the document ID parameter is set in the URL
if(isset($_GET['documentId'])) {
    // Retrieve the document ID from the URL parameter
    $documentId = $_GET['documentId'];
    
    // Connect to your database (replace the placeholders with your actual database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "zenith";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the database to fetch the document content based on the document ID
    $sql = "SELECT document_content FROM facilities_uploaded_files WHERE document_id = $documentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the document content from the query result
        $row = $result->fetch_assoc();
        $documentContent = $row['document_content'];

        // Output the document content
        echo $documentContent;
    } else {
        // Handle the case where no document with the provided ID is found
        echo "Document not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case where the document ID parameter is not provided in the URL
    echo "Document ID not provided.";
}
?>
