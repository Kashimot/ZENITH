<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Document to Admin</title>
    <link rel="stylesheet" href="send_document.css">
</head>
<body>

<div class="container">
  <div class="sidebar">
    <h2>Sidebar</h2>
    <button class="create-folder-btn" onclick="window.location.href = 'create.php'">Folder</button>
    <button class="search-btn" onclick="window.location.href = 'search.html'">Search</button>
  </div>
  
  <div class="content">
    <div class="upload-form">
      <h2>Send Document to Admin</h2>
      <form id="uploadForm" enctype="multipart/form-data" action="send_backend.php" method="post">
        <input type="file" name="fileToUpload[]" id="fileToUpload" accept=".pdf,.doc,.docx" multiple>
        <textarea name="message" id="message" placeholder="Message to Admin"></textarea>
        <input type="submit" value="Send Documents">
      </form>
    </div>
  </div>
</div>

</body>
</html>
