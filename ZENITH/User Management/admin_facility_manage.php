<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_facility_manage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
            </div>
        </header>
        <div class="container">
        <div class="facility-requests-container">
            <div class="add-facility">
                <h2>Add Available Facility</h2>
                <form id="addFacilityForm" class="add-facility-form">
                    <input type="text" id="facilityNameInput" placeholder="Facility Name" required>
                    <button type="submit">Add Facility</button>
                </form>
            </div>

            <div class="facility-management">
                <div class="facility-table">
                    <h3>Added Facilities</h3>
                    <table id="facilityTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Facility Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="facilityList">
                            <!-- Facility list will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>

                <div class="pending-requests">
                    <h2>Pending Facility Requests</h2>
                    <table id="pendingRequestsTable">
                        <thead>
                            <tr>
                                <th>Facility</th>
                                <th>Requester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="pendingRequestsList">
                            <!-- List of pending facility requests will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="facility-history">
    <h2>Facility History</h2>
    <table id="facilityHistoryTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Facility Name</th>
                <th>Authorized By</th>
                <th>Rejected By</th>
            </tr>
        </thead>
        <tbody>
            <!-- Populate this tbody with facility history data dynamically -->
        </tbody>
    </table>

   <!-- Pagination -->
<div class="pagination-container">
    <div class="pagination">
        <ul class="pagination-list"></ul>
    </div>
    <div class="pagination-buttons">
        <button id="prevPageBtn">Previous</button>
        <span id="currentPage">1</span>
        <button id="nextPageBtn">Next</button>
    </div>
</div>

            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });

// Function to fetch and display pending facility requests
function fetchPendingRequests() {
    $.ajax({
        url: 'fetch_pending_requests.php', // Endpoint to fetch pending requests
        type: 'GET',
        success: function(response) {
            console.log('AJAX Response:', response); // Log the response to the console
            // Parse JSON response and filter pending requests
            var pendingRequests = JSON.parse(response).filter(function(request) {
                return request.status === 'pending';
            });
            // Populate the list with pending requests
            pendingRequests.forEach(function(request) {
                $('#pendingRequestsList').append('<tr><td>' + request.facility + '</td><td>' + request.requester + '</td><td><button class="grant-btn" data-id="' + request.id + '">Grant</button><button class="reject-btn" data-id="' + request.id + '">Reject</button></td></tr>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching pending requests:', error);
        }
    });
}

// Call the function to fetch pending requests when the page loads
fetchPendingRequests();



    // AJAX request to add available facility
    $('#addFacilityForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var facilityName = $('#facilityNameInput').val();

        // AJAX request to add facility
        $.ajax({
            url: 'add_facility.php', // Endpoint to add facility
            type: 'POST',
            data: { facilityName: facilityName },
            success: function(response) {
                alert('Facility added successfully!');
                // Clear the input field after successful addition
                $('#facilityNameInput').val('');
                // Optionally, update the facility list
                fetchFacilities(); // Assuming you have a function to fetch and update the facility list
            },
            error: function(xhr, status, error) {
                console.error('Error adding facility:', error);
            }
        });
    });

    // Function to fetch and display added facilities
    function fetchFacilities() {
        $.ajax({
            url: 'fetch_facilities.php', // Endpoint to fetch added facilities
            type: 'GET',
            success: function(response) {
                var facilities = JSON.parse(response);
                facilities.forEach(function(facility) {
                    $('#facilityList').append('<tr><td>' + facility.id + '</td><td>' + facility.name + '</td><td><button class="delete-btn" data-id="' + facility.id + '">Delete</button></td></tr>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching facilities:', error);
            }
        });
    }
  // Grant button click handler
$(document).on('click', '.grant-btn', function() {
    var requestId = $(this).data('id');
    var button = $(this); // Store reference to the button clicked
    
    // AJAX request to grant the pending facility request
    $.ajax({
        url: 'grant_request.php', // Endpoint to grant request
        type: 'POST',
        data: { requestId: requestId },
        success: function(response) {
            alert('Facility request granted: ' + response);
            // Send notification to facilities management department
            sendNotification('facilities_management', 'The requested facility has been granted.');
            // Remove the granted request from the list
            button.closest('tr').remove();
        },
        error: function(xhr, status, error) {
            console.error('Error granting request:', error);
        }
    });
});

// Reject button click handler
$(document).on('click', '.reject-btn', function() {
    var requestId = $(this).data('id');
    var button = $(this); // Store reference to the button clicked
    
    // AJAX request to reject the pending facility request
    $.ajax({
        url: 'reject_request.php', // Endpoint to reject request
        type: 'POST',
        data: { requestId: requestId },
        success: function(response) {
            alert('Facility request rejected: ' + response);
            // Send notification to facilities management department
            sendNotification('facilities_management', 'The requested facility has been rejected.');
            // Remove the rejected request from the list
            button.closest('tr').remove();
        },
        error: function(xhr, status, error) {
            console.error('Error rejecting request:', error);
        }
    });
});


    // Click handler for delete button
    $(document).on('click', '.delete-btn', function() {
        var facilityId = $(this).data('id');
        var button = $(this); // Store reference to the button element
        // AJAX request to delete the facility
        $.ajax({
            url: 'delete_facility.php', // Endpoint to delete facility
            type: 'POST',
            data: { id: facilityId },
            success: function(response) {
                // Remove the deleted facility row from the table
                button.closest('tr').remove();
                alert('Facility deleted successfully!');
            },
            error: function(xhr, status, error) {
                console.error('Error deleting facility:', error);
            }
        });
    });

    // Function to send notification
    function sendNotification(recipient, message) {
        $.ajax({
            url: 'send_notification.php', // Endpoint to send notification
            type: 'POST',
            data: { recipient: recipient, message: message },
            success: function(response) {
                console.log('Notification sent:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error sending notification:', error);
            }
        });
    }
});
$(document).ready(function() {
    // Function to fetch facility history with pagination using AJAX
    function fetchFacilityHistory(page, perPage) {
        $.ajax({
            url: 'fetch_facility_history.php', // URL to fetch facility history
            method: 'GET',
            dataType: 'json',
            data: { page: page, perPage: perPage }, // Include pagination parameters
            success: function(response) {
                // Clear existing table rows
                $('#facilityHistoryTable tbody').empty();
                
                // Populate table with fetched data
                response.forEach(function(item) {
                    // Determine the value for the "Rejected By" column
                    var rejectedBy = item.rejected_by ? item.rejected_by : "N/A";
                    
                    // Determine the value for the "Authorized By" column
                    var authorizedBy = item.granted_by ? item.granted_by : "N/A";
                    
                    $('#facilityHistoryTable tbody').append('<tr><td>' + item.date + '</td><td>' + item.facilityName + '</td><td>' + authorizedBy + '</td><td>' + rejectedBy + '</td></tr>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching facility history:', error);
            }
        });
    }

    // Initial fetch of facility history with pagination
    fetchFacilityHistory(1, 10); // Fetch first page with 10 records per page

    // Pagination click event handler for "Next" button
    $('#nextPageBtn').click(function() {
        var currentPage = parseInt($('#currentPage').text());
        fetchFacilityHistory(currentPage + 1, 10); // Fetch next page with 10 records per page
        $('#currentPage').text(currentPage + 1); // Update current page number
    });

    // Pagination click event handler for "Previous" button
    $('#prevPageBtn').click(function() {
        var currentPage = parseInt($('#currentPage').text());
        if (currentPage > 1) {
            fetchFacilityHistory(currentPage - 1, 10); // Fetch previous page with 10 records per page
            $('#currentPage').text(currentPage - 1); // Update current page number
        }
    });
});



    </script>    
</body>
</html>
