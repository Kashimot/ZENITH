<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the facility ID is provided in the POST data
    if (isset($_POST['facilityId'])) {
        // Get the facility ID from the POST data
        $facilityId = $_POST['facilityId'];

        // Include database configuration
        include_once "db_config.php";

        // Function to sanitize input data
        function sanitize($data)
        {
            return htmlspecialchars(strip_tags(trim($data)));
        }

        // Sanitize the facility ID
        $facilityId = sanitize($facilityId);

        // Prepare an SQL statement to update the facility status to unavailable
        $sql = "UPDATE facilities SET status = 'unavailable' WHERE id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $facilityId);

        // Execute the statement
        if ($stmt->execute()) {
            // Facility marked as unavailable successfully
            echo json_encode(array("success" => true, "message" => "Facility marked as unavailable."));
        } else {
            // Error occurred while marking facility as unavailable
            echo json_encode(array("success" => false, "message" => "Error marking facility as unavailable: " . $stmt->error));
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // Facility ID not provided in the POST data
        echo json_encode(array("success" => false, "message" => "Facility ID is missing."));
    }
} else {
    // Invalid request method
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}
?>
