<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Search</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <button class="logout-btn" onclick="window.location.href = 'login.php'">Logout</button>
    <div class="container">
        <h1>Document Search</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search documents...">
            <button id="searchButton">Search</button>
        </div>
        <div id="searchResults">
            <!-- Search results will be displayed here -->
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle search button click
            $("#searchButton").click(function() {
                var searchTerm = $("#searchInput").val();
                searchDocuments(searchTerm);
            });

            // Function to search documents via AJAX
            function searchDocuments(searchTerm) {
                $.ajax({
                    url: "search.php", // Modify the URL to point to your PHP file
                    type: "POST",
                    data: { searchQuery: searchTerm }, // Pass the search query to the backend
                    dataType: "json", // Expect JSON response from the backend
                    success: function(response) {
                        // Process the search results
                        displaySearchResults(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            }

            // Function to display search results
            function displaySearchResults(results) {
                var resultsContainer = $("#searchResults");
                resultsContainer.empty(); // Clear previous search results
                
                if (results.length > 0) {
                    var resultList = $("<ul></ul>");
                    results.forEach(function(result) {
                        resultList.append("<li><a href='uploads/" + result + "' target='_blank'>" + result + "</a></li>");
                    });
                    resultsContainer.append(resultList);
                } else {
                    resultsContainer.html("<p>No matching documents found.</p>");
                }
            }
        });
    </script>
</body>
</html>
