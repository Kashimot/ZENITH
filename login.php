<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Enter your database password here
$dbname = "zenith";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if(isset($_POST['username']) && isset($_POST['password'])) {
    // Trim input to remove leading/trailing whitespace
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password verified, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['department'] = $row['department'];

            // Check if the user is an admin
            if ($row['is_admin'] == 1) {
                // Admin user
                echo "admin_dashboard.php";
            } else {
                // Non-admin user
                // Redirect to department page based on user's department
                $department = $row['department'];
                switch ($department) {
                    case 'Facilities Management':
                        echo "facilities_management.php";
                        break;
                    case 'Operations Department':
                        echo "operations_department.php";
                        break;
                        case 'Supply Department':
                            echo "supply_department.php";
                            break;
                    case 'Training Department':
                        echo "training_department.php";
                        break;
                    default:
                        // Redirect to a default page if department not recognized
                        echo "login.php";
                        break;
                }
            }
        } else {
            // Incorrect password
            echo "Incorrect password";
        }
    } else {
        // User not found
        echo "User not found";
    }

    $stmt->close();
} else {
    // Invalid request
    echo "Invalid request";
}

// Close connection
$conn->close();
?>
