<?php
session_start();

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
        // User found, verify the password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password verified, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['isAdmin'] = $row['is_admin'] == 1; // Set isAdmin based on database value

            // Redirect to appropriate dashboard
            $dashboard = $row['is_admin'] == 1 ? 'admin_dashboard.php' : 'user_dashboard.php';
            echo $dashboard; // Send dashboard URL as response
            exit(); // Stop script execution after sending response
        } else {
            // Incorrect password
            echo "Incorrect password";
        }
    } else {
        // User not found
        echo "User not found";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" type="text/css" href="./login.css">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form id="signin-form" class="sign-in-form">
          <h2 class="title">Sign In</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="username" name="username" placeholder="Username">
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Password">
          </div>
          <button type="button" id="login-btn" class="btn solid">Login</button>
        </form>
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <img src="marine.png" alt="Marines Logo" style="width:500px;height:400px;">
        </div>
        <img src="./img/log.svg" class="image" alt="">
      </div>
      <img src="./img/register.svg" class="image" alt="">
    </div>
  </div>

  <script>
    document.getElementById("login-btn").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    var form = document.getElementById("signin-form");
    var formData = new FormData(form); // Get form data

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.text();
    })
    .then(data => {
        // Check if the response contains "Incorrect password" or "User not found"
        if (data.includes("Incorrect password") || data.includes("User not found")) {
            alert("Incorrect username or password. Please try again."); // Show pop-up for incorrect credentials
        } else {
            // Redirect to the appropriate dashboard based on the response
            window.location.href = data.trim(); // Trim any leading/trailing whitespace from the response URL
        }
    })
    .catch(error => {
        // Handle errors here
        console.error("Error:", error);
        alert("An error occurred. Please try again."); // Example: display error message in an alert
    });
});

  </script>

</body>
</html>
