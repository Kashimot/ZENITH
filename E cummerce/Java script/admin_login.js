$(document).ready(function() {
    $("#login_btn").click(function() {
        var adminUsername = $("#admin_username").val();
        var adminPassword = $("#admin_password").val();
        
        $.ajax({
            url: "admin_login_process.php",
            method: "POST",
            data: {
                admin_username: adminUsername,
                admin_password: adminPassword
            },
            success: function(data) {
                if (data === "success") {
                    window.location.href = "admin_dashboard.php"; // Redirect to admin dashboard on successful login
                } else {
                    $("#error_message").html("Invalid username or password.");
                }
            }
        });
    });
});
