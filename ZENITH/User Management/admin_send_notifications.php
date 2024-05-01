<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_send_notifications.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body>

    <!-- Hamburger menu -->
    <div class="hamburger-menu">
        <div class="hamburger-icon"></div>
        <span class="menu-label">Menu</span>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
        <li><a href="admin_document_approval.php" class="nav-btn">Document Approval</a></li>
            <li><a href="admin_document_send_document.php" class="nav-btn">Send Document</a></li>
            <li><a href="Documents_dashboard.php" class="nav-btn">View Documents</a></li>
            <li><a href="admin_user_management.php" class="nav-btn">User Management</a></li>
            <li><a href="admin_send_notifications.php" class="nav-btn">Send Notification</a></li>
            <li><a href="admin_facility_manage.php" class="nav-btn">Manage Facility</a></li>
            <li><a href="admin_borrow_request.php" class="nav-btn">Borrow Request</a></li>
            <li><a href="admin_announcement.php" class="nav-btn">Announcement</a></li>
            <li><a href="admin_dashboard.php" class="nav-btn">Home</a></li>
        </ul>
</aside>


<!-- Notification form -->
<form id="notificationForm">
    <label for="recipient">Recipient Department</label>
    <select id="recipient" name="recipient[]" multiple required>
        <option value="facilities_management">Facilities Management</option>
        <option value="operations_department">Operations Department</option>
        <option value="training_department">Training Department</option>
        <option value="supply_department">Supply Department</option>
        <option value="select_all">Select All</option> <!-- Add the "Select All" option -->
    </select>
    <label for="message">Message</label>
    <textarea id="message" name="message" required></textarea>
    <button type="button" onclick="sendNotification()">Send Notification</button>
</form>



<script>

   $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });
    function sendNotification() {
    var recipients = [];
    $('#recipient option:selected').each(function() {
        recipients.push($(this).val());
    });

    // Check if "Select All" is selected
    if (recipients.includes('select_all')) {
        recipients = ['facilities_management', 'operations_department', 'training_department', 'supply_department'];
    }

    var message = $('#message').val();

    // Perform AJAX request to send notification with recipients and message data
    $.ajax({
        url: 'notifications.php', // Use notifications.php as the handler
        type: 'POST',
        data: { recipient: recipients, message: message },
        success: function(response) {
            alert(response); // Display success or error message
        },
        error: function(xhr, status, error) {
            console.error('Error sending notification:', error);
        }
    });
}

    </script>
    </body>
    </html>    