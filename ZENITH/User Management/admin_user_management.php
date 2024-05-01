<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="admin_user_management.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" defer></script>
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
            <h1>Add User</h1>
            <!-- Form to add a new user -->
            <form id="addUserForm">
            <label for="newUserUsername">Username:</label>
<input type="text" id="newUserUsername" name="newUserUsername" required><br>
<span id="usernameError" style="color: red;"></span> 
                <label for="newUserPassword">Password:</label>
                <input type="password" id="newUserPassword" name="newUserPassword" required><br>
                <label for="newUserDepartment">Department:</label>
                <select id="newUserDepartment" name="newUserDepartment" required>
    <option value="">Select Department</option>
    <option value="Facilities Management">Facilities Management Department</option>
    <option value="Operations Department">Operations Department</option>
    <option value="Training Department">Training Department</option>
    <option value="Supply Department">Supply Department</option>
    <option value="Admin">Admin</option>
</select><br>
<button type="submit">Add User</button>

            </form>
        </div>

        <div id="userListContainer">
    <h2>User List</h2>
    <ul id="userList">
        <!-- User list items will be dynamically populated here -->
    </ul>  
    <div id="paginationControls">
        <button id="prevPageBtn">Previous Page</button>
        <button id="nextPageBtn">Next Page</button>
    </div>
</div>



<div id="adminListContainer">
    <h2>Admin List</h2>
    <ul id="adminList">
        <!-- Admin list items will be dynamically populated here -->
    </ul>  
    <div id="paginationControls">
        <button id="prevPageBtn">Previous Page</button>
        <button id="nextPageBtn">Next Page</button>
    </div>
</div>

    <script>
$(document).ready(function() {
    // Hamburger Menu
    $('.hamburger-icon').click(function() {
        $('.sidebar').toggleClass('active');
    });

    // Event listener for username input to prevent users from using numbers
    $('#newUserUsername').on('input', function() {
        var username = $(this).val();
        var regex = /^[a-zA-Z\s]*$/; // Regular expression to allow only letters and spaces

        // Check if the username contains numbers
        if (!regex.test(username)) {
            $('#usernameError').text('Username cannot contain numbers and $%!@');
            // Clear the input field
            $(this).val('');
        } else {
            $('#usernameError').text('');
        }
    });

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
                        listItem.text(user.username + ' (' + user.department + ')'); // Add department label
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

    // Function to populate admin list
    function populateAdminList() {
        $.ajax({
            url: 'get_admins.php', // PHP script to fetch admin list
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#adminList').empty(); // Clear existing list
                if (response.length > 0) {
                    response.forEach(function(admin) {
                        var listItem = $('<li>');
                        listItem.text(admin.username);
                        listItem.attr('data-admin-id', admin.id); // Store admin ID as data attribute
                        // Add buttons for update and delete
                        var updateButton = $('<button class="update-admin-btn">Update</button>');
                        var deleteButton = $('<button class="delete-admin-btn">Delete</button>');
                        listItem.append(updateButton);
                        listItem.append(deleteButton);
                        $('#adminList').append(listItem);
                    });
                } else {
                    $('#adminList').append('<li>No admins found</li>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching admin list:', error);
            }
        });
    }

    // Populate admin list on page load
    populateAdminList();

    // AJAX request to update admin details
    $(document).on('click', '.update-admin-btn', function() {
        var adminId = $(this).closest('li').attr('data-admin-id');
        var newUsername = prompt('Enter new username:');
        var newPassword = prompt('Enter new password:');
        if (newUsername !== null && newPassword !== null) {
            $.ajax({
                url: 'update_admin.php', // PHP script to update admin details
                type: 'POST',
                data: { adminId: adminId, newUsername: newUsername, newPassword: newPassword },
                success: function(response) {
                    alert(response); // Display success message
                    populateAdminList(); // Refresh admin list
                },
                error: function(xhr, status, error) {
                    console.error('Error updating admin details:', error);
                }
            });
        }
    });

    // AJAX request to delete admin
    $(document).on('click', '.delete-admin-btn', function() {
        var adminId = $(this).closest('li').attr('data-admin-id');
        if (confirm('Are you sure you want to delete this admin?')) {
            $.ajax({
                url: 'delete_admin.php', // PHP script to delete admin
                type: 'POST',
                data: { adminId: adminId },
                success: function(response) {
                    alert(response); // Display success message
                    populateAdminList(); // Refresh admin list
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting admin:', error);
                }
            });
        }
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

    // Add User Form
    $('#addUserForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        var formData = $(this).serialize();

        // AJAX request to add user
        $.ajax({
            url: 'add_user.php', // PHP script to handle adding user
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                alert(response); // Display success message or handle as needed
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error); // Log error to console
                alert('An error occurred. Please try again.'); // Display error message to user
            }
        });
    });

    // Function for pagination
    var currentPage = 1;
    var usersPerPage = 5; // Adjust as needed
    var totalUsers = 0;

    function displayUsers() {
        var startIndex = (currentPage - 1) * usersPerPage;
        var endIndex = startIndex + usersPerPage;
        var displayedUsers = users.slice(startIndex, endIndex);

        $('#userList').empty(); // Clear existing list
        if (displayedUsers.length > 0) {
            displayedUsers.forEach(function(user) {
                var listItem = $('<li>');
                listItem.text(user.username + ' (' + user.department + ')');
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
    }

    function fetchUsers() {
        $.ajax({
            url: 'get_users.php', // PHP script to fetch user list
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                users = response;
                totalUsers = users.length;
                displayUsers(); // Display users for the first page
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user list:', error);
            }
        });
    }

    fetchUsers(); // Initial fetch of users

    $('#prevPageBtn').click(function() {
        if (currentPage > 1) {
            currentPage--;
            displayUsers();
        }
    });

    $('#nextPageBtn').click(function() {
        var totalPages = Math.ceil(totalUsers / usersPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayUsers();
        }
    });
});

    </script>
</body>
</html>
