<?php
session_start();
// Check if the user is authenticated and authorized
if (!isset($_SESSION['username']) || $_SESSION['department'] !== 'Facilities Management') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Management Files</title>
</head>
<body>
    <h1>Facilities Management Files</h1>
    <?php
    // Include database connection code here
    // Example:
    // $conn = new mysqli($servername, $username, $password, $dbname);

    // Fetch files specific to the Facilities Management department from the database
    $sql = "SELECT id, filename, filepath FROM files WHERE department = 'Training Management'";
    $result = $conn->query($sql);

    // Check if files are found
    if ($result->num_rows > 0) {
        // Output data of each file
        while ($row = $result->fetch_assoc()) {
            echo "<a href='" . $row["filepath"] . "' target='_blank'>" . $row["filename"] . "</a><br>";
        }
    } else {
        echo "No files found for Facilities Management department.";
    }

    // Close database connection
    // $conn->close();
    ?>
</body>
</html>
