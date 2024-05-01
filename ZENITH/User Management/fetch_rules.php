<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "zenith"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch rules based on the selected departments
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['departments'])) {
    $departments = $_GET['departments'];

    // Prepare SQL statement to fetch rules based on the selected departments
    $sql = "SELECT * FROM rules WHERE department IN (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $departments);
    $stmt->execute();
    $result = $stmt->get_result();

    // Output fetched rules as JSON
    $rules = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($rules);

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
