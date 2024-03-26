<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Folder</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="input-container">
                <form id="createFolderForm">
                    <label for="folder_name">Folder Name:</label>
                    <input type="text" id="folder_name" name="folder_name" required><br><br>
                    <input type="submit" value="Create Folder">
                </form>
                <button class="back-button" onclick="window.location.href = 'user_dashboard.php'">Go back to Homepage</button>
            </div>
        </div>

        <!-- Folders Container -->
        <div class="folders-container" id="foldersContainer">
            <h2>Folders</h2>
            <!-- Folders will be dynamically added here -->
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
    // Function to toggle sidebar
    $(".hamburger-menu").click(function() {
        $("#sidebar").toggleClass("show-sidebar");
    });

    // Function to handle form submission
    $("#createFolderForm").submit(function(event) {
        event.preventDefault();
        var folderName = $("#folder_name").val();
        $.post("create_folder.php", { folder_name: folderName }, function(response) {
            alert(response);
            fetchAndDisplayFolders();
        });
    });

    // Function to fetch and display existing folders
    function fetchAndDisplayFolders() {
        $.get("fetch_folders.php", function(data) {
            $("#foldersContainer").empty(); // Clear existing folders
            // Loop through the fetched folders and append them to the folders container
            data.forEach(function(folder) {
                // Create a clickable folder element
                var folderElement = $("<div class='folder'>" + folder.folder_name + "</div>");
                // Add click event to the folder element
                folderElement.click(function() {
                    // Handle folder click event (e.g., edit or delete)
                    var action = prompt("What do you want to do with this folder? (edit/delete)");
                    if (action === "edit") {
                        // Implement edit functionality
                        var newFolderName = prompt("Enter the new folder name:");
                        if (newFolderName) {
                            // Perform AJAX request to update folder name
                            $.post("edit_folder.php", { folder_id: folder.folder_id, new_name: newFolderName }, function(response) {
                                alert(response);
                                fetchAndDisplayFolders(); // Refresh folder list
                            });
                        }
                    } else if (action === "delete") {
                        // Implement delete functionality
                        var confirmDelete = confirm("Are you sure you want to delete this folder?");
                        if (confirmDelete) {
                            // Perform AJAX request to delete folder
                            $.post("delete_folder.php", { folder_id: folder.folder_id }, function(response) {
                                alert(response);
                                fetchAndDisplayFolders(); // Refresh folder list
                            });
                        }
                    } else {
                        alert("Invalid action.");
                    }
                });
                // Append folder element to the folders container
                $("#foldersContainer").append(folderElement);
            });
        });
    }

    // Call the function to fetch and display folders when the page loads
    fetchAndDisplayFolders();
});

    </script>
</body>
</html>
