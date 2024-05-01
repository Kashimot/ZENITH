<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations Department</title>
    <link rel="stylesheet" href="operations_department.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="operations_document.php">Documents</a></li>
            <li><a href="operations_send_to_admin.php" class="nav-btn">Send to Admin</a></li>
            <li><a href="ongoing_operations.php" class="nav-btn">Ongoing Operartions</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
                <span class="menu-label">Menu</span>
            </div>
            <h1>Operations Department</h1>
            <div id="datetime"></div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.hamburger-icon').click(function() {
            $('.sidebar').toggleClass('active');
        });

        // Function to update date and time for operations
        function updateDateTimeOperations() {
            var now = new Date();
            var datetime = now.toLocaleString();
            $('#datetimeOperations').text('Date and Time: ' + datetime);
        }
        updateDateTimeOperations();
        setInterval(updateDateTimeOperations, 1000); // Update every second

        // Populate the approved files select dropdown
        fetchApprovedFiles();

        // Add operation to the table based on the selected file from the dropdown
        $('#addOperationButton').click(function() {
            var operationTitle = $('#approvedFilesSelect').val();
            if (operationTitle) {
                var now = new Date();
                var startTime = now.toLocaleString();
                var newRow = '<tr><td>' + operationTitle + '</td><td>' + startTime + '</td><td>N/A</td><td><button class="end-operation-button">End</button> <button class="delete-operation-button">Delete</button></td></tr>';
                $('#operationTableBody').append(newRow);

                // Save operations data to localStorage
                saveOperationsToStorage();
            } else {
                alert('Please select an approved file.');
            }
        });

        // End operation function
        $(document).on('click', '.end-operation-button', function() {
            var operationRow = $(this).closest('tr');
            if (confirm('Are you sure you want to end this operation?')) {
                var now = new Date();
                var endTime = now.toLocaleString();
                operationRow.find('td:nth-child(3)').text(endTime);
                $(this).remove(); // Remove end button after ending operation

                // Save operations data to localStorage
                saveOperationsToStorage();
            }
        });

        // Delete operation function
        $(document).on('click', '.delete-operation-button', function() {
            var operationRow = $(this).closest('tr');
            if (confirm('Are you sure you want to delete this operation?')) {
                operationRow.remove();

                // Save operations data to localStorage
                saveOperationsToStorage();
            }
        });

        // Function to load operations data from localStorage
        function loadOperationsFromStorage() {
            var operationsData = localStorage.getItem('operationsData');
            if (operationsData) {
                $('#operationTableBody').html(operationsData);
            }
        }

        // Function to save operations data to localStorage
        function saveOperationsToStorage() {
            var operationsData = $('#operationTableBody').html();
            localStorage.setItem('operationsData', operationsData);
        }

        // Fetch approved files from the backend and populate the select dropdown
        function fetchApprovedFiles() {
            // Make an AJAX request to fetch the approved files from the backend
            $.ajax({
                url: 'fetch_approved_files.php',
                method: 'GET',
                success: function(response) {
                    // Parse the response as JSON
                    var approvedFiles = JSON.parse(response);

                    // Clear the existing options
                    $('#approvedFilesSelect').empty();

                    // Add the options to the select dropdown
                    approvedFiles.forEach(function(file) {
                        $('#approvedFilesSelect').append('<option value="' + file + '">' + file + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching approved files:', error);
                }
            });
        }

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

    // Form submission handler for facility selection
    $('#facilitySelectionForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var selectedFacilityId = $('#facilitySelect').val();

        // AJAX request to mark the selected facility as unavailable
        $.ajax({
            url: 'mark_facility_unavailable.php', // Endpoint to mark facility as unavailable
            type: 'POST',
            data: { facilityId: selectedFacilityId },
            success: function(response) {
                alert('Facility requested successfully!');
                // Optionally, update the UI to reflect the selection
                $('#facilitySelect').find(':selected').remove(); // Remove the selected facility from the list
            },
            error: function(xhr, status, error) {
                console.error('Error marking facility as unavailable:', error);
                // Optionally, display an error message to the user
                alert('Failed to request facility. Please try again later.');
            }
        });
    });
     // Function to fetch documents from operations_department_documents.php
     function fetchDocuments() {
        $.ajax({
            url: 'operations_featured_fetch.php',
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
