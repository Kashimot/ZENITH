<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Management Department</title>
    <link rel="stylesheet" href="facilities_management.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="facilities_send_to_admin.php" class="nav-btn">Send to Admin</a></li>
            <li><a href="facilities_document.php">Documents</a></li>
            <li><a href="facilities_request.php" class="nav-btn">Request Facility</a></li>
            <li><a href="facilities_management.php" class="nav-btn">Home</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
                <span class="menu-label">Menu</span>
            </div>
            <h1>Facilities Management Department</h1>
        </header>

        <div class="container">
            <!-- Announcements Section -->
            <section class="announcements">
                <h2>Announcements</h2>
                <ul id="announcements">
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
            // Toggle sidebar on hamburger icon click
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });
        
            // Function to fetch approved documents
            $.ajax({
                url: 'fetch_approved_documents.php',
                type: 'GET',
                success: function(response) {
                    var approvedDocuments = JSON.parse(response);
                    approvedDocuments.forEach(function(document) {
                        $('#approvedDocumentList').append('<li><a href="' + document.url + '">' + document.name + '</a></li>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching approved documents:', error);
                }
            });
        
            // Function to fetch rejected documents
            $.ajax({
                url: 'fetch_rejected_documents.php',
                type: 'GET',
                success: function(response) {
                    var rejectedDocuments = JSON.parse(response);
                    rejectedDocuments.forEach(function(document) {
                        $('#rejectedDocumentList').append('<li><a href="' + document.url + '">' + document.name + '</a></li>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching rejected documents:', error);
                }
            });
        
            // Function to fetch notifications
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
        });
        
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
        
        // AJAX request to fetch and populate the list of available facilities
        $.ajax({
            url: 'fetch_available_facilities.php',
            type: 'GET',
            success: function(response) {
                var facilities = JSON.parse(response);
                facilities.forEach(function(facility) {
                    $('#facilitySelect').append('<option value="' + facility.id + '">' + facility.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching available facilities:', error);
            }
        });
        
        // Form submission handler for facility selection
        $('#facilitySelectionForm').submit(function(event) {
            event.preventDefault();
            var selectedFacilityId = $('#facilitySelect').val();
        
            $.ajax({
                url: 'mark_facility_unavailable.php',
                type: 'POST',
                data: { facilityId: selectedFacilityId },
                success: function(response) {
                    alert('Facility requested successfully!');
                    $('#facilitySelect').find(':selected').remove();
                },
                error: function(xhr, status, error) {
                    console.error('Error marking facility as unavailable:', error);
                    alert('Failed to request facility. Please try again later.');
                }
            });
        });
         // Function to fetch documents from facilities_department_documents.php
         function fetchDocuments() {
        $.ajax({
            url: 'facilities_featured_fetch.php',
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

 // Function to fetch rules based on selected departments
function fetchRules() {
    // Get the selected departments
    var departments = $('#departments').val();

    // Fetch rules based on selected departments
    $.ajax({
        url: 'fetch_rules.php',
        type: 'GET', // Assuming fetch_rules.php expects a GET request
        data: { departments: departments },
        success: function(rulesResponse) {
            // Handle the fetched rules
            // For example, you can update the UI with the fetched rules
            $('#rulesContainer').html(rulesResponse); // Assuming rulesResponse is HTML content
        },
        error: function(xhr, status, error) {
            console.error('Error fetching rules:', error);
            alert('Failed to fetch rules. Please try again later.');
        }
    });
}

// Fetch rules when the page loads
$(document).ready(function() {
    fetchRules();
});

// Fetch rules when departments are changed
$('#departments').change(function() {
    fetchRules();
});

        </script>           
</body>
</html>