<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_document_approval.css">
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

    <div class="container">
        <!-- Main content area -->
        <div class="main-content">
            <!-- File approval table -->
            <table id="fileApprovalTable" class="file-approval-table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Uploaded By</th>
                        <th>Department</th>
                        <th>Upload Date</th>
                        <th>Approval Status</th>
                        <th>Reason for Rejection</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="fileList">
                    <!-- Files sent for approval will be displayed here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for hamburger menu and file approval functionality -->
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });

            // Function to populate the file approval table
            function populateFileApprovalTable(documents) {
                var tableBody = $('#fileList');
                tableBody.empty(); // Clear existing table content

                // Iterate over each document and append a row to the table
                documents.forEach(function(document) {
                    var row = $('<tr>');
                    row.append($('<td>').text(document.file_name));
                    row.append($('<td>').text(document.uploaded_by));
                    row.append($('<td>').text(document.department));
                    row.append($('<td>').text(document.upload_date));
                    row.append($('<td>').text(document.approval_status));
                    row.append($('<td>').text(document.reason_for_rejection));

                    // Create action buttons for approve, reject, and view
                    var actions = $('<td>');
                    var approveButton = $('<button class="approve-btn">Approve</button>');
                    var rejectButton = $('<button class="reject-btn">Reject</button>');
                    var viewButton = $('<button class="view-btn">View</button>');

                    // Add click event handlers for the buttons
                    approveButton.click(function() {
                        // Implement logic to approve document
                        $.ajax({
                            url: 'approve_document.php',
                            type: 'POST',
                            data: { documentId: document.id },
                            success: function(response) {
                                alert('Document approved successfully.');
                                // Send notification to the respective department
                                sendNotification(document.department, 'The requested document has been approved.');
                                // Remove the approved document from the list
                                row.remove();
                            },
                            error: function(xhr, status, error) {
                                console.error('Error approving document:', error);
                            }
                        });
                    });

                    rejectButton.click(function() {
                        // Implement logic to reject document
                        var reason = prompt('Enter reason for rejection:');
                        if (reason !== null && reason.trim() !== '') {
                            $.ajax({
                                url: 'reject_document.php',
                                type: 'POST',
                                data: { documentId: document.id, reason: reason },
                                success: function(response) {
                                    alert('Document rejected successfully.');
                                    // Send notification to the respective department
                                    sendNotification(document.department, 'The requested document has been rejected. Reason: ' + reason);
                                    // Remove the rejected document from the list
                                    row.remove();
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error rejecting document:', error);
                                }
                            });
                        } else {
                            alert('Please provide a reason for rejection.');
                        }
                    });

                    // Inside the viewButton.click event handler function
                    viewButton.click(function() {
                        // Construct the URL to the view_document.php script with the document ID as a parameter
                        var viewDocumentUrl = 'view_document.php?documentId=' + document.id;

                        // Open the document in a new window or tab
                        window.open(viewDocumentUrl, '_blank');
                    });

                    // Append action buttons to the actions column
                    actions.append(approveButton);
                    actions.append(rejectButton);
                    actions.append(viewButton);
                    row.append(actions);

                    // Append the row to the table body
                    tableBody.append(row);
                });
            }

            // Function to fetch facilities uploaded files from the server
            function fetchFacilitiesUploadedFiles() {
                $.ajax({
                    url: 'fetch_four_departments_documents.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Populate the file approval table with fetched documents
                        populateFileApprovalTable(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching facilities uploaded files:', error);
                    }
                });
            }

            // Call the fetchFacilitiesUploadedFiles function to fetch data on page load
            fetchFacilitiesUploadedFiles();
        });
    </script>

</body>
</html>
