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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];

    // Retrieve data from pending_requests table
    $sql_select = "SELECT facility, requester FROM pending_requests WHERE id = ? AND status = 'pending'";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $requestId);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    // Check if a pending request was found
    if ($result->num_rows > 0) {
        // Fetch the result row
        $row = $result->fetch_assoc();
        $facilityName = $row['facility'];
        $requester = $row['requester'];

        // Get the username of the Admin user from the users table
        $sql_admin = "SELECT username FROM users WHERE department = 'Admin' AND is_admin = 1 LIMIT 1";
        $result_admin = $conn->query($sql_admin);

        if ($result_admin->num_rows > 0) {
            $row_admin = $result_admin->fetch_assoc();
            $grantedBy = $row_admin['username'];

            // Prepare SQL statement to insert into facility_history table
            $sql_insert = "INSERT INTO facility_history (date, facilityName, rejected_by) VALUES (NOW(), ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ss", $facilityName, $grantedBy);

            // Execute the SQL statement
            if ($stmt_insert->execute()) {
                // Update status in pending_requests table to rejected
                $sql_update = "UPDATE pending_requests SET status = 'rejected' WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("i", $requestId);
                $stmt_update->execute();
                echo "Facility request rejected successfully by: " . $grantedBy;
            } else {
                echo "Error rejecting facility request: " . $stmt_insert->error;
            }

            // Close the prepared statements
            $stmt_insert->close();
            $stmt_update->close();
        } else {
            echo "Error: Admin user not found.";
        }
    } else {
        echo "No pending request found with ID: " . $requestId . " or request already processed.";
    }

    // Close the prepared statement and connection
    $stmt_select->close();
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
