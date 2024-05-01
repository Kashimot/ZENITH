<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" type="text/css" href="./login.css">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <!-- Use the id "signin-form" for the form -->
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
          <!-- Use a button with type "button" to prevent form submission -->
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
$(document).ready(function(){
    console.log("Document ready!"); // Check if document ready function is executed
    
    $("#login-btn").click(function(event){
        console.log("Login button clicked!"); // Check if the button click event is triggered
        
        // Prevent default button behavior
        event.preventDefault();
        
        // Get username and password
        var username = $("#username").val();
        var password = $("#password").val();
        console.log("Username: " + username + ", Password: " + password); // Check if username and password are correctly retrieved
        
        // Send AJAX request
        $.ajax({
            type: "POST",
            url: "login.php",
            data: { username: username, password: password },
            success: function(response){
                console.log("AJAX Success!"); // Check if AJAX request is successful
                
                // Redirect to appropriate page or display error message
                if(response.trim() == "admin_dashboard.php" || response.trim() == "facilities_management.php" || response.trim() == "operations_department.php" || response.trim() == "training_department.php" || response.trim() == "supply_department.php") {
                    window.location.href = response.trim();
                } else {
                    $("#error").html(response);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", error); // Log AJAX error if any
            }
        });
    });
});
</script>

</body>
</html>
