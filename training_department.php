<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Department</title>
    <link rel="stylesheet" href="training_department.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="training_send_to_admin.php">Send to Admin</a></li>
            <li><a href="training_document.php">Documents</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
                <span class="menu-label">Menu</span>
            </div>
            <h1>Training Department</h1>
    </header>

    <div class="container">
        <!-- Announcements Section -->
        <section class="announcements">
            <h2>Announcements</h2>
            <!-- Announcements content -->
        </section>

        <!-- Featured Documents Section -->
            <div class="container">
        <!-- Main content area -->
        <div class="main-content">
            <!-- Featured Documents -->
            <section class="featured-documents">
                <h2>Featured Documents</h2>
                <ul id="documentList">
                    <!-- Featured documents will be dynamically added here -->
                </ul>
            </section>
        </div>

    
     <!-- Notification popup (modal) -->
   <button class="notification-btn" onclick="showNotification()">Notification</button>
   <div id="notificationPopup" class="notification-popup">
     <div class="modal-content">
         <span class="close" onclick="closeNotificationModal()">&times;</span>
         <h2>Notifications</h2>
         <!-- Notification items will be dynamically added here -->
         <ul id="notificationList">
             <!-- Notifications will be added dynamically here -->
         </ul>
         <button id="clearNotificationsButton" class="clear-btn" onclick="clearNotifications()">Clear Notifications</button>
     </div>
 </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });
        });
         // Function to fetch notifications using AJAX
         function fetchNotifications() {
                $.ajax({
                    url: 'get_notifications.php',
                    type: 'GET',
                    success: function(response) {
                        var notifications = JSON.parse(response);
                        if (notifications && notifications.length > 0) {
                            $('#notificationList').empty();
                            notifications.forEach(function(notification) {
                                $('#notificationList').append('<li>' + notification.message + '</li>');
                            });
                        } else {
                            $('#notificationList').html('<li>No notifications found</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching notifications:', error);
                    }
                });
            }
        
            // Call the fetchNotifications function initially
            fetchNotifications();
        function showNotification() {
            var modal = document.getElementById("notificationPopup");
            modal.classList.add("active");
        }
        
        function closeNotificationModal() {
            var modal = document.getElementById("notificationPopup");
            modal.classList.remove("active");
        }
        
        // Click event handler for the Clear Notifications button
        $('#clearNotificationsButton').click(function() {
            $('#notificationList').empty();
            closeNotificationModal();
        });
        document.addEventListener('DOMContentLoaded', function () {
    // JavaScript code here
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const searchResults = document.getElementById('searchResults');

    // Event listener for search button click
    searchButton.addEventListener('click', function () {
        const searchTerm = searchInput.value.trim().toLowerCase();
        if (searchTerm !== '') {
            // Perform search and display results (dummy implementation)
            const results = ['Result 1', 'Result 2', 'Result 3']; // Dummy search results
            displaySearchResults(results);
        } else {
            alert('Please enter a search term.');
        }
    });

    // Function to display search results
    function displaySearchResults(results) {
        // Clear previous search results
        searchResults.innerHTML = '';

        if (results.length > 0) {
            results.forEach(function (result) {
                const listItem = document.createElement('li');
                listItem.textContent = result;
                searchResults.appendChild(listItem);
            });
        } else {
            const noResultsMessage = document.createElement('p');
            noResultsMessage.textContent = 'No results found.';
            searchResults.appendChild(noResultsMessage);
        }
    }
});
// Function to fetch documents from training_department_documents.php
function fetchDocuments() {
        $.ajax({
            url: 'training_featured_fetch.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Populate the document list
                var documentList = $('#documentList');
                documentList.empty(); // Clear existing documents
                $.each(response, function(index, document) {
                    var listItem = $('<li class="document-item">').text(document.file_name);
                    listItem.click(function() {
                        // Redirect to facilities_document.php with document ID
                        window.location.href = 'facilities_document.php?id=' + document.id;
                    });
                    documentList.append(listItem);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching documents:', error);
            }
        });
    }
    // Call fetchDocuments function to fetch and populate the list on page load
    fetchDocuments();
    $(document).ready(function() {
    // Function to fetch announcements
    function fetchAnnouncements() {
        $.ajax({
            url: 'fetch_announcements.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Clear existing announcements
                $('#announcements').empty();
                
                // Append each announcement to the list
                response.forEach(function(announcement) {
                    $('#announcements').append('<li>' + announcement + '</li>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching announcements:', error);
            }
        });
    }

    // Call fetchAnnouncements function to fetch and populate the list on page load
    fetchAnnouncements();
});
    </script>
</body>
</html>
