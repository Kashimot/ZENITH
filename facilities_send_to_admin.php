<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Department</title>
    <link rel="stylesheet" href="facilities_send_to_admin.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="facilities_document.php">Documents</a></li>
            <li><a href="facilities_request.php" class="nav-btn">Request Facility</a></li>
            <li><a href="facilities_management.php">Home</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
                <span class="menu-label">Menu</span>
            </div>
        </header>
    </div>
    <div class="container">
        <!-- Add your department-specific content here -->
        <h2>Upload Files and Send to Admin for Approval</h2>
        <form id="uploadAndSendToAdminForm" enctype="multipart/form-data" action="upload_files.php" method="post">
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf,.doc,.docx,.txt" required>
            <input type="text" name="newFilename" id="newFilename" placeholder="New Filename">
            <select name="urgency" id="urgency">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <select name="fileType" id="fileType">
                <option value="report">Report</option>
                <option value="memorandum">Memorandum</option>
                <option value="letter">Letter</option>
                <option value="finance">Finance</option>
                <option value="document">Document</option>
                <option value="presentation">Presentation</option>
                <option value="pdf">PDF</option>
                <option value="spreadsheet">Spreadsheet</option>
                <option value="proposal">Proposal</option>
            </select>
            <?php
            // Dynamically set the department based on the page
            $department = "facilities_management"; // Example department name
            ?>
            <input type="hidden" name="department" id="department" value="<?php echo $department; ?>">
            <button type="submit">Send to Admin</button>
        </form>
    </div>

   <!-- Add a table to display uploaded files -->
   <div> 
<table class="uploaded-files">
    <thead>
        <tr>
            <th>File Name</th>
            <th>Status</th>
            <th>Reason for Rejection</th>
        </tr>
    </thead>
    <tbody id="fileList">
        <!-- Uploaded files will be displayed here -->
    </tbody>
</table>
   </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });
            
    $('#uploadAndSendToAdminForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Create FormData object to store form data
        var formData = new FormData(this);

        // AJAX request to handle form submission
        $.ajax({
            url: 'request_for_approval_admin.php', // PHP script to handle form submission
            type: 'POST',
            data: formData,
            contentType: false, // Prevent jQuery from setting content type
            processData: false, // Prevent jQuery from processing data
            success: function(response) {
                // Handle success response from server
                console.log(response); // Log response to console
                alert('File uploaded successfully.'); // Show success message
            },
            error: function(xhr, status, error) {
                // Handle error response from server
                console.error('Error uploading file:', error); // Log error to console
                alert('Failed to upload file. Please try again later.'); // Show error message
            }
        });
    });
});
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
        $(document).ready(function() {
    // Function to fetch and populate uploaded files table
    function fetchUploadedFiles() {
        $.ajax({
            url: 'fetch_faclities_uploaded_files.php', // PHP script to fetch uploaded files
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var fileList = $('#fileList');
                fileList.empty(); // Clear existing data
                
                // Check if there are any files
                if (response.length > 0) {
                    response.forEach(function(file) {
                        // Append file data to the table
                        var row = $('<tr>');
                        row.append($('<td>').text(file.file_name));
                        row.append($('<td>').text(file.status));
                        row.append($('<td>').text(file.reason_for_rejection));
                        fileList.append(row);
                    });
                } else {
                    // If no files found, display a message
                    fileList.append('<tr><td colspan="3">No files uploaded</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching uploaded files:', error);
            }
        });
    }

    // Call the fetchUploadedFiles function to populate the table on page load
    fetchUploadedFiles();
});
    </script>
</body>
</html>
