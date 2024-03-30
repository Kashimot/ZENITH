<?php
// Establish database connection
$servername = "localhost";
$username = "username"; // Your database username
$password = "password"; // Your database password
$dbname = "database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $borrowerName = $_POST["borrowerName"];
    $borrowDateTime = $_POST["borrowDateTime"];
    $itemBorrowed = $_POST["itemBorrowed"];

    // Insert the borrow request into the database
    $sql = "INSERT INTO borrow_history (item_name, borrower_name, borrow_date) VALUES ('$itemBorrowed', '$borrowerName', '$borrowDateTime')";

    if ($conn->query($sql) === TRUE) {
        echo "Borrow request submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
