<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_document_send_document.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <!-- Main content area -->
    <div class="main-content">
        <form id="sendDocumentForm" enctype="multipart/form-data">
            <label for="documentFile">Choose File:</label>
            <input type="file" id="documentFile" name="documentFile" required><br>
            <label for="targetDepartment">Select Department:</label>
            <select id="targetDepartment" name="targetDepartment" required>
                <option value="">Select Department</option>
                <option value="1">Facilities Management Department</option>
                <option value="2">Operations Department</option>
                <option value="3">Training Department</option>
                <option value="4">Supply Department</option>
            </select><br>
            <label for="documentType">Select Document Type:</label>
            <select id="documentType" name="documentType" required>
                <option value="">Select Document Type</option>
                <option value="Report">Report</option>
                <option value="Memorandum">Memorandum</option>
                <option value="Letter">Letter</option>
                <option value="Finance">Finance</option>
                <option value="Document">Document</option>
                <option value="Presentation">Presentation</option>
                <option value="PDF">PDF</option>
                <option value="Spreadsheet">Spreadsheet</option>
                <option value="Proposal">Proposal</option>
            </select><br>
            <button type="submit">Send Document</button>
        </form>
    </div>
    

    <!-- JavaScript for hamburger menu -->
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>
