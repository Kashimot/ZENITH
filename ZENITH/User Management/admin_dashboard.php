<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_dashboard.css">
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
        </ul>

        <!-- Clock -->
        <div class="clock-container">
            <div class="clock-col">
                <p class="clock-day clock-timer"></p>
                <p class="clock-label">Day</p>
            </div>
            <div class="clock-col">
                <p class="clock-hours clock-timer"></p>
                <p class="clock-label">Hours</p>
            </div>
            <div class="clock-col">
                <p class="clock-minutes clock-timer"></p>
                <p class="clock-label">Minutes</p>
            </div>
            <div class="clock-col">
                <p class="clock-seconds clock-timer"></p>
                <p class="clock-label">Seconds</p>
            </div>
        </div>

        <section class="logout-btn">
            <button class="nav-btn" onclick="window.location.href = 'login.php'">Logout</button>
        </section>
    </aside>

     <!-- Container for document and user counters -->
     <div class="counter-container">
        <div class="counter" id="total-documents">
            <p class="counter-value">Loading...</p>
            <p class="counter-label">Total Documents</p>
        </div>
        <div class="counter" id="pending-documents">
            <p class="counter-value">Loading...</p>
            <p class="counter-label">Pending Documents</p>
        </div>
        <div class="counter" id="total-users">
            <p class="counter-value">Loading...</p>
            <p class="counter-label">Total Users</p>
        </div>
    </div>

    <!-- JavaScript for hamburger menu -->
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });
            
            // Fetch and update counter values
            updateCounterValues();
        });

        // Function to fetch and update counter values
        function updateCounterValues() {
            $.get("fetch_fourdepartments.php", function(data) {
                $('#total-documents .counter-value').text(data);
            });
            
            $.get("pending_documents.php", function(data) {
                $('#pending-documents .counter-value').text(data);
            });
            
            $.get("total_users.php", function(data) {
                $('#total-users .counter-value').text(data);
            });
        }

        // Function to update time
        document.addEventListener('DOMContentLoaded', () =>
            requestAnimationFrame(updateTime)
        );
        function updateTime() {
            var currentTime = moment();
            document.querySelector('.clock-day').textContent = currentTime.format('dd');
            document.querySelector('.clock-hours').textContent = currentTime.format('hh'); // 'hh' for 12-hour format
            document.querySelector('.clock-minutes').textContent = currentTime.format('mm');
            document.querySelector('.clock-seconds').textContent = currentTime.format('ss');
            requestAnimationFrame(updateTime);
        }
    </script>
</body>
</html>