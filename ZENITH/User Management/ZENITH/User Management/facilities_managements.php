<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenith";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
if (!isset($_SESSION['username']) || $_SESSION['department'] !== 'Facilities Management') {
    // Redirect unauthorized users to the login page or display an error message
    header("Location: login.php");
    exit();
}

// Fetch files specific to the Facilities Management department from the database
$sql = "SELECT id, filename, filepath FROM files WHERE department = 'Facilities Management'";
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
$conn->close();
?>
