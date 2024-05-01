<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply and Inventory</title>
    <link rel="stylesheet" href="supply_inventory.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
        <li><a href="supply_department.php">Home</a></li>
            <li><a href="supply_send_to_admin.php">Send to Admin</a></li>
            <li><a href="supply_inventory.php">Inventory</a></li>
            <li><a href="supply_documents.php">Documents</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="content">
        <header>
            <div class="hamburger-menu">
                <div class="hamburger-icon"></div>
                <span class="menu-label">Menu</span>
            </div>

            <!-- Inventory Management Section -->
            <section class="inventory-management">
                <h2>Inventory Management</h2>
                <div class="inventory-actions">
                    <button id="exportInventoryBtn">Export Inventory</button>   
                </div>
                <div class="inventory-items">
                    <!-- Display current inventory items here -->
                </div>
            </section>


    <!-- Export Inventory Modal -->
    <div id="exportInventoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeExportModal()">&times;</span>
            <h2>Export Inventory</h2>
            <button id="exportToCSVBtn">Export to CSV</button>
            <button id="exportToPDFBtn">Export to PDF</button>
            <!-- Add more export options as needed -->
        </div>
    </div>

    <!-- User Input Form -->
    <section class="user-input">
        <h2>Borrow Item</h2>
        <form id="borrowForm" action="submit_borrow_request.php" method="post">
            <label for="borrowerName">Borrower's Name:</label>
            <input type="text" id="borrowerName" name="borrowerName" required>
            
            <label for="borrowDateTime">Borrow Date and Time:</label>
            <input type="datetime-local" id="borrowDateTime" name="borrowDateTime" required>
            
            <label for="itemType">Item Type:</label>
            <select id="itemType" name="itemType" required>
                <option value="">Select Item Type</option>
                <option value="ammo">Ammo (Kilos)</option>
                <option value="m16">M16 Rifle</option>
                <option value="m4">M4 Carbine</option>
                <option value="m9">M9 Pistol</option>
                <option value="m240">M240 Machine Gun</option>
                <!-- Add more gun options as needed -->
                <option value="gasoline">Gasoline</option>
                <option value="other">Other</option>
            </select>
            
            <label for="itemBorrowed">Item Borrowed:</label>
            <input type="text" id="itemBorrowed" name="itemBorrowed" required>
            
            <button type="submit">Send Request to Admin</button>
        </form>
    </section>
    


    <!-- History Section -->
<section class="borrow-history">
    <h2>Borrow History</h2>
    <table id="historyTable">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Borrower Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
            </tr>
        </thead>
        <tbody>
            <!-- Borrow history will be displayed here -->
        </tbody>
    </table>
</section>



    <!-- Add more modals, forms, and features as needed -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.hamburger-icon').click(function() {
                $('.sidebar').toggleClass('active');
            });

            // Refresh inventory button click handler
            $('#refreshInventoryBtn').click(function() {
                refreshInventory();
            });

            // Add new item button click handler
            $('#addNewItemBtn').click(function() {
                $('#addItemModal').css('display', 'block');
            });

            // Export inventory button click handler
            $('#exportInventoryBtn').click(function() {
                $('#exportInventoryModal').css('display', 'block');
            });

            // Close modal when the user clicks outside of it
            window.onclick = function(event) {
                var modal = document.getElementById('addItemModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }

                var exportModal = document.getElementById('exportInventoryModal');
                if (event.target == exportModal) {
                    exportModal.style.display = "none";
                }
            }

            // Form submission handler for adding new item
            $('#addItemForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = $(this).serialize(); // Serialize form data

                // AJAX request to add new inventory item
                $.ajax({
                    url: 'add_inventory_item.php',
                    type: 'POST',
                    data:
                    formData,
                    success: function(response) {
                        // Handle success response
                        // For example, refresh inventory or show a success message
                        console.log("Item added successfully:", response);
                        refreshInventory(); // Refresh inventory list
                        closeAddItemModal(); // Close add item modal
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error adding item:', error);
                        // For example, display an error message to the user
                    }
                });
            });

            // Function to refresh inventory list
            function refreshInventory() {
                // AJAX request to fetch updated inventory list
                $.ajax({
                    url: 'fetch_inventory.php',
                    type: 'GET',
                    success: function(response) {
                        // Handle success response
                        // Update the inventory list with the fetched data
                        $('.inventory-items').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error('Error fetching inventory:', error);
                        // For example, display an error message to the user
                    }
                });
            }

            // Function to close the add item modal
            function closeAddItemModal() {
                $('#addItemModal').css('display', 'none');
            }

            // Function to close the export inventory modal
            function closeExportModal() {
                $('#exportInventoryModal').css('display', 'none');
            }

            // Function to show notifications
            function showNotification() {
                var modal = document.getElementById("notificationPopup");
                modal.classList.add("active");
            }

            // Function to close notification modal
            function closeNotificationModal() {
                var modal = document.getElementById("notificationPopup");
                modal.classList.remove("active");
            }
        });
    </script>
</body>
</html>
