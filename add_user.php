<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Enter your database password here
$dbname = "zenith";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['newUserUsername'];
    $password = password_hash($_POST['newUserPassword'], PASSWORD_DEFAULT);
    $department = $_POST['newUserDepartment'];
    $added_by_admin = "admin"; // Change this according to your logic
    $is_admin = ($department == 'Admin') ? 1 : 0; // Check if user is an admin

    // Check if the username already exists
    $sql_check_username = "SELECT * FROM users WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();

    // If username exists, display an error message
    if ($result_check_username->num_rows > 0) {
        echo " Username already exists ";
    } else {
        // Prepare SQL statement to insert a new user
        $sql_insert_user = "INSERT INTO users (username, password, department, added_by_admin, is_admin) VALUES (?, ?, ?, ?, ?)";
        
        // Create prepared statement
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bind_param("ssssi", $username, $password, $department, $added_by_admin, $is_admin);

        // Execute the statement
        if ($stmt_insert_user->execute()) {
            echo "User added successfully";
        } else {
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }

        // Close the statement for inserting user
        $stmt_insert_user->close();
    }

    // Close statement and connection for checking username
    $stmt_check_username->close();
    $conn->close();
}
?>
