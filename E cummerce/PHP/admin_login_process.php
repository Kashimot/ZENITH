<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "green_thumb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch admin credentials from the database
$stmt = $conn->prepare("SELECT admin_id FROM admins WHERE admin_username = ? AND admin_password = ?");
$stmt->bind_param("ss", $adminUsername, $adminPassword);

$adminUsername = $_POST["admin_username"];
$adminPassword = $_POST["admin_password"];

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "success";
} else {
    echo "failure";
}

$stmt->close();
$conn->close();
?>
