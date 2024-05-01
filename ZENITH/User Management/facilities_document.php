<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities Documents</title>
    <link rel="stylesheet" href="facilities_document.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="facilities_document.php">Documents</a></li>
            <li><a href="facilities_send_to_admin.php">Send to Admin</a></li>
            <li><a href="facilities_request.php">Request Facilities</a></li>
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
        </header>
    </div>
   <!-- File Upload Form Container -->
   <div class="feature-container">
    <h2>Upload Documents</h2>
    <form id="fileUploadForm" enctype="multipart/form-data">
        <!-- Input field for the new filename (optional) -->
        <input type="text" name="newFilename" id="newFilename" placeholder="New Filename">
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf,.doc,.docx,.txt" required>
        <button type="button" id="uploadBtn">Upload</button>
    </form>
    <div id="errorMsg"></div>
</div>


<!-- Container for Uploaded Documents -->
<div class="documents-container">
    <h2>Uploaded Documents</h2>
    <ul id="documentList"></ul>
    <button id="deleteSelectedBtn">Delete Selected</button>
</div>
<div id="pagination-container">
    <span id="pagination"></span>
</div>



     <script>
   $(document).ready(function() {
    // Toggle sidebar on hamburger icon click
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });

    // Global variable to store the current page
    var currentPage = 1;

    // Function to fetch and display documents using AJAX
    function fetchDocuments(page = 1) {
        currentPage = page; // Update current page
        $.ajax({
            url: 'fetch_facilities_documents.php',
            type: 'GET',
            data: { page: page },
            success: function(response) {
                var documents = JSON.parse(response);
                var documentContainer = $('#documentList');
                documentContainer.empty();
                documents.forEach(function(document) {
                    var listItem = $('<li>');
                    var checkbox = $('<input type="checkbox" class="documentCheckbox" value="' + document.id + '">');
                    var documentName = $('<span>').text(document.original_name);
                    var date = $('<span>').text(document.upload_date);
                    var downloadLink = $('<a>').attr('href', 'facilities_download.php?id=' + document.id).text('Download');
                    listItem.append(checkbox, documentName, date, downloadLink);
                    documentContainer.append(listItem);
                });
                updatePagination(currentPage);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching documents:', error);
            }
        });
    }

    // Function to update pagination controls
    function updatePagination(currentPage) {
        // Assume total number of pages is known (totalPages)
        var totalPages = 10; // For example

        // Clear existing pagination controls
        $('#pagination').empty();

        // Previous button
        var prevButton = $('<span>').addClass('pagination-link').text('Previous');
        if (currentPage > 1) {
            prevButton.data('page', currentPage - 1);
            $('#pagination').append(prevButton);
        }

        // Next button
        var nextButton = $('<span>').addClass('pagination-link').text('Next');
        if (currentPage < totalPages) {
            nextButton.data('page', currentPage + 1);
            $('#pagination').append(nextButton);
        }
    }

    // Fetch documents when the page loads
    fetchDocuments();

    // Pagination controls event listener
    $(document).on('click', '.pagination-link', function() {
        var page = $(this).data('page');
        fetchDocuments(page);
    });

    // AJAX request to upload file
    $('#uploadBtn').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#fileUploadForm')[0]);
        $.ajax({
            url: 'upload_facilities.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
                fetchDocuments();
            },
            error: function(xhr, status, error) {
                alert('Error uploading file: ' + error);
            }
        });
    });

    // Function to delete selected documents
    $('#deleteSelectedBtn').click(function() {
        var selectedDocuments = [];
        $('.documentCheckbox:checked').each(function() {
            selectedDocuments.push($(this).val());
        });

        if (selectedDocuments.length === 0) {
            alert('Please select at least one document to delete.');
            return;
        }

        $.ajax({
            url: 'delete_documents.php',
            type: 'POST',
            data: { documentIds: selectedDocuments },
            success: function(response) {
                alert(response);
                fetchDocuments();
            },
            error: function(xhr, status, error) {
                alert('Error deleting documents: ' + error);
            }
        });
    });
});


    </script>
</body>
</html>