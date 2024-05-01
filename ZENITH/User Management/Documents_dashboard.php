<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="Documents_dashboard.css">
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
            <li><a href="admin_document_approval.html" class="nav-btn">Document Approval</a></li>
            <li><a href="admin_document_send_document.html" class="nav-btn">Send Document</a></li>
            <li><a href="admin_user_management.html" class="nav-btn">User Management</a></li>
            <li><a href="admin_send_notifications.html" class="nav-btn">Notification</a></li>
            <li><a href="admin_borrow_request.html" class="nav-btn">Borrow Request</a></li>
            <li><a href="admin_facility_manage.html" class="nav-btn">Facility</a></li>
            <li><a href="admin_dashboard.html" class="nav-btn">Home</a></li>
        </ul>
        <script>
            // Hamburger Menu
            $(document).ready(function() {
                $('.hamburger-icon').click(function() {
                    $('.sidebar').toggleClass('active');
                });
            });

            // Function to fetch and display documents
            function fetchAndDisplayDocuments() {
                $.ajax({
                    url: 'fetch_documents.php', // PHP script to fetch documents
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Handle the response and display documents in UI
                        // Example: Display the documents in a list
                        response.forEach(function(document) {
                            $('#documentList').append(`<li>${document.name} <button class="delete-doc" data-id="${document.id}">Delete</button></li>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching documents:', error);
                    }
                });
            }

            // Function to delete document
            function deleteDocument(documentId) {
                $.ajax({
                    url: 'delete_document.php', // PHP script to delete document
                    type: 'POST',
                    data: { documentId: documentId },
                    success: function(response) {
                        // Handle success response
                        alert(response); // Show success message
                        // Refresh document list after deletion
                        $('#documentList').empty();
                        fetchAndDisplayDocuments();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting document:', error);
                        alert('Failed to delete document. Please try again later.');
                    }
                });
            }

            // Event listener for document deletion
            $(document).on('click', '.delete-doc', function() {
                var documentId = $(this).data('id');
                deleteDocument(documentId);
            });

            // Fetch and display documents on page load
            $(document).ready(function() {
                fetchAndDisplayDocuments();
            });
        </script>
    </aside>

        <!-- Main content area -->
        <div class="main-content">
            <!-- Document list -->
            <ul id="documentList">
                <!-- Document items will be dynamically populated here -->
                <li>Document 1</li>
                <li>Document 2</li>
                <li>Document 3</li>
            </ul>
        </div>
</body>
</html>
