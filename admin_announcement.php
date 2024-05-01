<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_announcement.css">
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

    <div class="container">
    <!-- Main content area -->
    <div class="main-content">
        <h2>Send Announcement</h2>
        <form id="announcementForm">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title">
            <label for="departments">Departments:</label>
            <select id="departments" name="departments[]" multiple>
                <option value="Facilities Management">Facilities Management</option>
                <option value="Operations Department">Operations Department</option>
                <option value="Training Department">Training Department</option>
                <option value="Supply Department">Supply Department</option>
            </select>
            <label for="sendToAll">Send to all departments</label>
            <input type="checkbox" id="sendToAll" name="sendToAll">
            <label for="announcement">Announcement:</label>
            <textarea id="announcement" name="announcement" rows="4" cols="50"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</div>


    <!-- JavaScript for hamburger menu and sending announcement functionality -->
    <script>
  $(document).ready(function() {
    // Toggle sidebar on hamburger icon click
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });

    // Form submission handler for sending announcement
    $('#announcementForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get announcement text
        var announcement = $('#announcement').val();

        // Get the selected departments
        var departments = $('#departments').val();

        // Check if 'send to all' checkbox is checked
        var sendToAll = $('#sendToAll').is(':checked');

        // If 'send to all' checkbox is checked, set departments to 'all'
        if (sendToAll) {
            departments = 'all';
        }

        // Validate form inputs
        if (!announcement.trim()) {
            alert('Please enter the announcement text.');
            return;
        }

        if (!departments || departments.length === 0) {
            alert('Please select at least one department.');
            return;
        }

        // Send announcement to selected departments or all departments
        $.ajax({
            url: 'send_announcement.php',
            type: 'POST',
            data: {
                departments: departments,
                announcement: announcement
            },
            success: function(response) {
                // Show confirmation dialog
                if (confirm('Announcement sent successfully. Do you want to clear the form?')) {
                    // Clear form fields after sending announcement
                    $('#announcementForm')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending announcement:', error);
                alert('Failed to send announcement. Please try again later.');
            }
        });
    });
});

    </script>
</body>
</html>
