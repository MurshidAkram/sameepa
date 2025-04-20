<?php
// Your PHP logic here (e.g., initializing variables, handling requests, etc.)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Resident_Contacts.css">
    <title >Residents Contacts | <?php echo SITENAME; ?></title>
    
    <style>
        /* Ensure that the dashboard layout accounts for the side panel */
        .dashboard-container {
            display: flex;
            padding: 20px;
        }

        main {
            flex: 1;
            padding-left: 20px;
            padding-right: 20px;
        }

        .to{
            color :#800080;
            font-size: 34px;
        }

        .too{
            text-align: center;
            color :#800080;
            padding-right: 95px;
            font-size: 24px;
        }
        /* Center the heading "Find Resident Contact" */
        #search-section h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        /* Flexbox to align the search bar and button */
        .search-residents-form {
            display: flex;
            justify-content: center; /* Center the form contents */
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .search-residents-form input[type="text"] {
            width: 300px; /* Limit width of the input field */
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-residents-form input[type="text"]:focus {
            outline-color: #007bff;
            border-color: #800080;
        }

        .search-residents-form button {
            padding: 12px 20px;
            border-radius: 25px;
            background-color: blueviolet;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-residents-form button:hover {
            background-color: #45a049;
        }

        /* Style for the search results table */
        .resident-contacts-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow-x: auto;
            max-height: 400px;
            display: block;
        }

        .resident-contacts-table th, .resident-contacts-table td {
            padding: 12px;
            text-align: left;
        }

        

        .resident-contacts-table tr:nth-child(odd) {
            background-color:rgb(248, 197, 248);
        }

        .resident-contacts-table tr:hover {
            background-color: #E0AAFF;
        }

        .form-submit {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
    width: 100%;
  }

        #add-contact .topic {
            font-size: 32px;
            text-align: center;
            color: blueviolet;
            padding-top : 52px;
        }
        .tooh{
            text-align: center;
            padding-right: 95px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
           

            <!-- Search Bar for Finding Resident Contacts -->
            <section id="search-section">
                
                <h3 class="too">Find Resident Contact</h3>

                <h4 class="tooh">Find residents details using their name , number or address </h4>
                <form method="GET" class="search-residents-form" onsubmit="searchResidentContact(event)">
                    <div class="form-group">
                        <label for="search_query" style="display: none;">Search by Name or Address:</label>
                        <input type="text" id="search_query" name="search_query" required>
                    </div>
                    <button type="submit" class="btn">Search</button>
                </form>

                <!-- Search Results Table -->
                <table class="resident-contacts-table" id="search-results" style="display: none;">
                    <thead>
                        <tr>
                            <th>Resident Name</th>
                            <th>Resident Address</th>
                            <th>Phone Number</th>
                            <th>Fixed Line</th>
                            <th>Email Address</th>
                        </tr>
                    </thead>
                    <tbody id="results-body">
                        <!-- JavaScript will populate this area with search results -->
                    </tbody>
                </table>
            </section>

           </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Function to handle resident search
        function searchResidentContact(event) {
            event.preventDefault();
            const query = document.getElementById('search_query').value.toLowerCase();

            // Perform the AJAX request
            fetch('<?php echo URLROOT; ?>/security/Resident_Contacts?search_query=' + query)
                .then(response => response.json())
                .then(data => {
                    // Populate the table with search results
                    const resultsTable = document.getElementById('search-results');
                    const resultsBody = document.getElementById('results-body');
                    resultsBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(resident => {
                            const row = document.createElement('tr');
                            row.innerHTML = ` 
                                <td>${resident.resident_name}</td>
                                <td>${resident.address}</td>
                                <td>${resident.phonenumber}</td>
                                <td>${resident.fixed_line}</td>
                                <td>${resident.email}</td>
                            `;
                            resultsBody.appendChild(row);
                        });
                        resultsTable.style.display = 'table';
                    } else {
                        resultsTable.style.display = 'none';
                        alert("cannot find the resident details");
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    
                });
        }
    </script>
</body>

</html>
