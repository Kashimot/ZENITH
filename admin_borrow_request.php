<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_borrow_request.css">
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

<!-- Admin Section -->
<section class="admin-section">
    <h2>Admin Panel - Borrow History</h2>
    <!-- Borrow History Table -->
    <table id="historyTable">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Borrower Name</th>
                <th>Borrow Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Borrow history records will be displayed here -->
            <tr>
                <td>Item Name 1</td>
                <td>Borrower Name 1</td>
                <td>Borrow Date 1</td>
                <td><button onclick="deleteRecord()">Delete</button></td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</section>
<script>
$(document).ready(function() {
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });
});
</script>
</body>
</html>