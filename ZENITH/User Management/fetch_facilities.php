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

// Prepare SQL statement to fetch facilities
$sql = "SELECT id, name FROM facilities";
$result = $conn->query($sql);

// Initialize an array to store facilities
$facilities = array();

// Check if there are facilities
if ($result->num_rows > 0) {
    // Fetch facilities and add them to the array
    while ($row = $result->fetch_assoc()) {
        $facility = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
        $facilities[] = $facility;
    }
}

// Output facilities as JSON
echo json_encode($facilities);

// Close connection
$conn->close();
?>
