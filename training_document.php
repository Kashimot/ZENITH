<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Documents</title>
    <link rel="stylesheet" href="operations_document.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
        <li><a href="training_department.php">Home</a></li>
            <li><a href="training_document.php">Document</a></li>
            <li><a href="training_send_to_admin.php">Send to Admin</a></li>
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
            <!-- Ensure the name attribute is set to "fileToUpload" -->
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

    <script>
       $(document).ready(function() {
    // Toggle sidebar on hamburger icon click
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });

    // Function to fetch and display documents using AJAX
    function fetchDocuments() {
        $.ajax({
            url: 'fetch_training_documents.php', // Adjust the URL to match your PHP script's filename
            type: 'GET',
            success: function(response) {
                var documents = JSON.parse(response);
                var documentContainer = $('#documentList');

                // Clear existing content
                documentContainer.empty();

                // Loop through fetched documents and populate the container
                documents.forEach(function(document) {
                    var listItem = $('<li>');
                    var checkbox = $('<input type="checkbox" class="documentCheckbox" value="' + document.id + '">');
                    var documentName = $('<span>').text(document.original_name);
                    var date = $('<span>').text(document.upload_date);
                    var downloadLink = $('<a>').attr('href', 'training_download.php?id=' + document.id).text('Download');
                    listItem.append(checkbox, documentName, date, downloadLink);
                    documentContainer.append(listItem);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching documents:', error); // Log error message
            }
        });
    }

    // Fetch documents when the page loads
    fetchDocuments();

    // AJAX request to upload file
    $('#uploadBtn').click(function(e) {
        e.preventDefault();

        var formData = new FormData($('#fileUploadForm')[0]);

        $.ajax({
            url: 'upload_training.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response); // Show success message
                // You can perform additional actions after successful upload
                fetchDocuments(); // Fetch documents after successful upload
            },
            error: function(xhr, status, error) {
                alert('Error uploading file: ' + error); // Show error message
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
            url: 'training_delete_documents.php',
            type: 'POST',
            data: { documentIds: selectedDocuments },
            success: function(response) {
                alert(response); // Show success message
                fetchDocuments(); // Refresh document list after deletion
            },
            error: function(xhr, status, error) {
                alert('Error deleting documents: ' + error); // Show error message
            }
        });
    });
});

    </script>
</body>
</html>
