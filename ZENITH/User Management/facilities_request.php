<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Management Department</title>
    <link rel="stylesheet" href="facilities_request.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="facilities_send_to_admin.php" class="nav-btn">Send to Admin</a></li>
            <li><a href="facilities_uploaded_files.php" class="nav-btn">Uploaded Files</a></li>
            <li><a href="facilities_document.php">Documents</a></li>
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

              <!-- Facilities Selection Form -->
              <form id="facilitySelectionForm" class="facility-form">
    <h2>Select Facility</h2>
    <div class="select-wrapper">
        <select id="facilitySelect" class="facility-select" required>
            <option value="" disabled selected>Select a facility</option>
        </select>
        <span class="select-icon">&#9660;</span> <!-- Dropdown arrow icon -->
    </div>
    <button type="submit" class="submit-btn">Request Facility</button>
</form>


<!-- Facility Usage History Section -->
<div class="facility-history">
    <h2>Facility History</h2>
    <table id="facilityHistoryTable" class="facility-table">
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Toggle sidebar on hamburger icon click
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
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

    // Function to fetch facilities and populate the select dropdown
    function fetchFacilities() {
        $.ajax({
            url: 'fetch_facilities.php', // URL to fetch facilities
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Clear existing options
                $('#facilitySelect').empty();
                // Add options for each facility
                response.forEach(function(facility) {
                    $('#facilitySelect').append(`<option value="${facility.id}">${facility.name}</option>`);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching facilities:', error);
            }
        });
    }

    // Call fetchFacilities function to populate the select dropdown
    fetchFacilities();

    // Function to send a pending facility request via AJAX
    function sendFacilityRequest() {
        // Get the selected facility and other form data
        var facilityId = $('#facilitySelect').val();
        var requester = ''; // You can set the requester value here as needed

        // Perform AJAX request to send the facility request
        $.ajax({
            url: 'send_facility_request.php',
            type: 'POST',
            data: { facilityId: facilityId, requester: requester },
            success: function(response) {
                // Handle success response
                alert(response); // Display success message or handle as needed
                // Optionally, update the facility usage history
                fetchUsageHistory(); // Assuming you have a function to fetch and update the history
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error sending facility request:', error);
                alert('An error occurred. Please try again.'); // Display error message to user
            }
        });
    }

    // Event listener for the form submission
    $('#facilitySelectionForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        sendFacilityRequest(); // Call the function to send the facility request
    });
});

</script>
        
</body>
</html>