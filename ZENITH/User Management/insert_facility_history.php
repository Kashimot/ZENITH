<?php
// Establish database connection (replace with your database credentials)
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

// Check if the request contains the necessary data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date']) && isset($_POST['facilityName']) && isset($_POST['granted_by'])) {
    $date = $_POST['date'];
    $facilityName = $_POST['facilityName'];
    $grantedBy = $_POST['granted_by'];

    // Prepare SQL statement to insert facility history record
    $sql = "INSERT INTO facility_history (date, facilityName, granted_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $date, $facilityName, $grantedBy);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "Facility history inserted successfully";
    } else {
        echo "Error inserting facility history: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
