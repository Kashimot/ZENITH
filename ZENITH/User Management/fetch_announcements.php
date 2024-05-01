<?php
// Database connection parameters
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

// Check if the user's department information is provided
if(isset($_GET['department'])) {
    // Get the user's department
    $userDepartment = $_GET['department'];

    // Query to fetch announcements relevant to the user's department
    $sql = "SELECT announcement FROM announcements WHERE FIND_IN_SET(?, departments) > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userDepartment);
    $stmt->execute();
    $result = $stmt->get_result();

    $announcements = array();

    // Check if there are any announcements
    if ($result->num_rows > 0) {
        // Fetch data for each announcement
        while($row = $result->fetch_assoc()) {
            $announcements[] = $row['announcement']; // Only fetch the announcement column
        }
    }

    // Close statement
    $stmt->close();
} else {
    // If department information is not provided, fetch all announcements
    $sql = "SELECT announcement FROM announcements";
    $result = $conn->query($sql);

    $announcements = array();

    // Check if there are any announcements
    if ($result->num_rows > 0) {
        // Fetch data for each announcement
        while($row = $result->fetch_assoc()) {
            $announcements[] = $row['announcement']; // Only fetch the announcement column
        }
    }
}

// Close database connection
$conn->close();

// Output announcements as JSON
echo json_encode($announcements);
?>
