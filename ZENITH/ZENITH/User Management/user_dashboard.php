<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body>
    <img src="marine.png" alt="Marine Logo">
    <div class="container transparent-container">
        <!-- Show Menu -->
        <span class="show-menu" onclick="toggleSidebar()">Show Menu</span>
        
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

      <!-- Notification Modal -->
<div id="notificationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeNotificationModal()">&times;</span>
        <p>Notification area</p>
    </div>
</div>

<!-- Bell image positioned at top right corner -->
<div class="notification-bell" onclick="showNotification()">
    <img src="User Management/bell.png" alt="Notification Bell">
    <span class="notification-label">Notification</span> <!-- Notification label -->
</div>

        

        <!-- Hamburger Menu -->
        <div class="hamburger-menu" onclick="toggleSidebar()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h1>User Dashboard</h1>
            <!-- Navigation Buttons -->
            <button class="nav-btn" onclick="window.location.href = 'upload.php'">Upload File</button>
            <button class="nav-btn" onclick="window.location.href = 'create.php'">Folder</button>
            <button class="nav-btn" onclick="window.location.href = 'search.php'">Search</button>
            <button class="nav-btn" onclick="window.location.href = 'send_document.php'">Send Document to Admin</button>
            <button class="nav-btn" onclick="window.location.href = 'login.php'">Logout</button>
        </div>

        <!-- Files Container -->
        <div class="files-container">
            <h2>Recently Added Files</h2>
            <ul>
                <!-- Display list of recently added files here -->
                <li>File 1</li>
                <li>File 2</li>
                <li>File 3</li>
            </ul>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("show-sidebar");
        }

        function showNotification() {
            var modal = document.getElementById("notificationModal");
            modal.style.display = "block";
        }

        function closeNotificationModal() {
            var modal = document.getElementById("notificationModal");
            modal.style.display = "none";
        }

        document.addEventListener('DOMContentLoaded', () =>
            requestAnimationFrame(updateTime)
        );

        function updateTime() {
            var currentTime = moment();
            document.querySelector('.clock-day').textContent = currentTime.format('dd');
            document.querySelector('.clock-hours').textContent = currentTime.format('HH');
            document.querySelector('.clock-minutes').textContent = currentTime.format('mm');
            document.querySelector('.clock-seconds').textContent = currentTime.format('ss');
            requestAnimationFrame(updateTime);
        }
    </script>
</body>
</html>
