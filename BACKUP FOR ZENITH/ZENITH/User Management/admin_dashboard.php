<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <section class="logout-btn">
    <button class="nav-btn" onclick="window.location.href = 'login.php'">Logout</button>
    </section>
    <main>
        <!-- Document Approval Section -->
        <section class="document-approval">
            <h2>Document Approval</h2>
            <table id="documentTable">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="documentList">
                    <!-- Document rows will be dynamically populated here -->
                </tbody>
            </table>
        </section>

        <!-- Add Comments Section -->
        <section class="add-comments">
            <h2>Add Comments</h2>
            <form id="addCommentsForm">
                <input type="hidden" id="selectedDocumentId" name="documentId">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments" rows="4" cols="50"></textarea><br>
                <button type="submit">Add Comments</button>
            </form>
        </section>

        <!-- User Management Section -->
        <section class="user-management">
            <h2>User Management</h2>
            <!-- Add New User Form -->
            <div class="form-container">
                <h3>Add New User</h3>
                <form id="addUserForm">
                    <label for="newUserUsername">Username:</label>
                    <input type="text" id="newUserUsername" name="newUserUsername" required><br>
                    <label for="newUserPassword">Password:</label>
                    <input type="password" id="newUserPassword" name="newUserPassword" required><br>

                    <button type="submit">Add User</button>
                </form>
            </div>
    <!-- Add Admin Section -->
    <section class="add-admin">
            <h2>Add Admin</h2>
            <form id="addAdminForm">
                <input type="text" name="newAdminUsername" placeholder="Username">
                <input type="password" name="newAdminPassword" placeholder="Password">
                <button type="submit">Submit</button>
            </form>
        </section>

</section>

            
            <!-- User List Section -->
            <section id="userListSection">
                <h3>User List</h3>
                <ul id="userList">
                    <!-- User list items will be dynamically populated here -->
                </ul>
            </section>
        </section>
    </main>

    <!-- JavaScript for AJAX functionality -->
    <script>
        $(document).ready(function() {
            // Function to populate document list
            function populateDocumentList() {
                $.ajax({
                    url: 'fetch_documents.php', // PHP script to fetch document list
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#documentList').empty(); // Clear existing list
                        if (response.length > 0) {
                            response.forEach(function(document) {
                                var row = '<tr>' +
                                    '<td>' + document.name + '</td>' +
                                    '<td><button class="view-doc" data-id="' + document.id + '">View</button></td>' +
                                    '</tr>';
                                $('#documentList').append(row);
                            });
                        } else {
                            $('#documentList').append('<tr><td colspan="2">No documents found</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching document list:', error);
                    }
                });
            }

            // Populate document list on page load
            populateDocumentList();

            // Event listener for viewing document and adding comments
            $(document).on('click', '.view-doc', function() {
                var documentId = $(this).data('id');
                $('#selectedDocumentId').val(documentId); // Set selected document ID in hidden input field
            });

            // AJAX request to add comments to document
            $('#addCommentsForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize();
                $.ajax({
                    url: 'add_comments.php', // PHP script to add comments
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response); // Display success message
                        // Optionally, you can clear the comments textarea or perform other actions
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding comments:', error);
                    }
                });
            });
        });

        $(document).ready(function() {
            // Function to populate user list
            function populateUserList() {
                $.ajax({
                    url: 'get_users.php', // PHP script to fetch user list
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#userList').empty(); // Clear existing list
                        if (response.length > 0) {
                            response.forEach(function(user) {
                                var listItem = $('<li>');
                                listItem.text(user.username);
                                listItem.attr('data-user-id', user.id); // Store user ID as data attribute
                                // Add buttons for update and delete
                                var updateButton = $('<button class="update-btn">Update</button>');
                                var deleteButton = $('<button class="delete-btn">Delete</button>');
                                listItem.append(updateButton);
                                listItem.append(deleteButton);
                                $('#userList').append(listItem);
                            });
                        } else {
                            $('#userList').append('<li>No users found</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching user list:', error);
                    }
                });
            }

            // Populate user list on page load
            populateUserList();

            // AJAX request to add a new user
            $('#addUserForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize();
                $.ajax({
                    url: 'add_user.php', // PHP script to add a new user
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert(response); // Display success message
                        populateUserList(); // Refresh user list
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding new user:', error);
                    }
                });
            });

            // AJAX request to update user details
            $(document).on('click', '.update-btn', function() {
                var userId = $(this).closest('li').attr('data-user-id');
                var newUsername = prompt('Enter new username:');
                var newPassword = prompt('Enter new password:');
                if (newUsername !== null && newPassword !== null) {
                    $.ajax({
                        url: 'update_user.php', // PHP script to update user details
                        type: 'POST',
                        data: { userId: userId, newUsername: newUsername, newPassword: newPassword },
                        success: function(response) {
                            alert(response); // Display success message
                            populateUserList(); // Refresh user list
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating user details:', error);
                        }
                    });
                }
            });
            // AJAX request to delete user
            $(document).on('click', '.delete-btn', function() {
                var userId = $(this).closest('li').attr('data-user-id');
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: 'delete_user.php', // PHP script to delete user
                        type: 'POST',
                        data: { userId: userId },
                        success: function(response) {
                            alert(response); // Display success message
                            populateUserList(); // Refresh user list
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting user:', error);
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            // Prevent form submission and handle it with AJAX
            $('#addAdminForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: 'add_admin.php', // PHP script to handle form submission
                    type: 'POST', // Form method
                    data: formData, // Form data
                    success: function(response) {
                        alert(response); // Display success message
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });

    </script>
</body>
</html>