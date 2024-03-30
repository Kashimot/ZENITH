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

// Handle borrowing items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrowItem'])) {
    $itemName = $_POST['itemName'];
    $borrowerName = $_POST['borrowerName'];
    $borrowDate = date("Y-m-d");

    // Insert a record into the borrow_history table
    $sql = "INSERT INTO borrow_history (item_name, borrower_name, borrow_date) VALUES ('$itemName', '$borrowerName', '$borrowDate')";

    if ($conn->query($sql) === TRUE) {
        echo "Item borrowed successfully";
    } else {
        echo "Error borrowing item: " . $conn->error;
    }
}

// Handle returning items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['returnItem'])) {
    $itemId = $_POST['itemId'];
    $returnDate = date("Y-m-d");

    // Update the return_date for the specified item in the borrow_history table
    $sql = "UPDATE borrow_history SET return_date='$returnDate' WHERE id=$itemId";

    if ($conn->query($sql) === TRUE) {
        echo "Item returned successfully";
    } else {
        echo "Error returning item: " . $conn->error;
    }
}

// Fetch borrow history
$sql = "SELECT * FROM borrow_history";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["item_name"] . "</td>";
        echo "<td>" . $row["borrower_name"] . "</td>";
        echo "<td>" . $row["borrow_date"] . "</td>";
        echo "<td>" . $row["return_date"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No borrow history found</td></tr>";
}

// Close connection
$conn->close();
?>
