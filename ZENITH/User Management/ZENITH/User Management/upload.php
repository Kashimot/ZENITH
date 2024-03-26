<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Upload</title>
<link rel="stylesheet" href="upload.css">
</head>
<body>

<div class="container">
  <div class="sidebar">
    <h2>Sidebar</h2>
    <button class="create-folder-btn" onclick="window.location.href = 'create.php'">Folder</button>
    <button class="search-btn" onclick="window.location.href = 'search.php'">Search</button>
  </div>
  
  <div class="content">
    <div class="upload-form">
      <h2>Upload File</h2>
      <form action="upload_document.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" onchange="updateFileName(this)">
        <input type="text" name="fileName" id="fileName" placeholder="File Name (Optional)">
        <input type="text" name="author" id="author" placeholder="Author's Name">
        <input type="submit" value="Upload File" name="submit">
      </form>
    </div>

    <!-- Uploaded documents section -->
    <div class="uploaded-documents">
      <h2>Uploaded Documents</h2>
      <form action="delete.php" method="post">
        <div class="documents-container">
          <ul id="documentList">
            <!-- Uploaded documents will be listed here -->
            <?php
            // Include database connection
            include_once 'db_connection.php';

            // Fetch uploaded documents from the database
            $sql = "SELECT id, file_name, author FROM uploaded_files";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Output each uploaded document as a list item with checkbox
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li><input type="checkbox" name="selectedFiles[]" value="' . $row['id'] . '"> ' . $row['file_name'] . ' (Author: ' . $row['author'] . ')</li>';
                }
            } else {
                echo "<li>No documents uploaded yet.</li>";
            }

            // Close database connection
            mysqli_close($conn);
            ?>
          </ul>
        </div>
        <button type="submit" name="action" value="open">Open Selected</button>
        <button type="submit" name="action" value="delete">Delete Selected</button>
      </form>
    </div>
  </div>
</div>

<script>
  function updateFileName(input) {
    // Get the file name from the input
    var fileName = input.value.split('\\').pop();
    // Display the file name in the text input
    document.getElementById('fileName').value = fileName;
  }
</script>

</body>
</html>
