<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/Resident_Contacts.css">
    <title>Manage Residents Contacts | <?php echo SITENAME; ?></title>
    
    <style>
        /* Add styles for the colorful table */
        .resident-contacts-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .resident-contacts-table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .resident-contacts-table td {
            padding: 12px;
            text-align: left;
        }

        .resident-contacts-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .resident-contacts-table tr:nth-child(odd) {
            background-color: #e6f7ff;
        }

        .resident-contacts-table tr:hover {
            background-color: #ddd;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Style for the Search Bar */
        .search-residents-form input[type="text"] {
            width: 100%;
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid #ddd;
            font-size: 16px;
            margin-top: 10px;
            transition: border-color 0.3s ease;
        }

        .search-residents-form input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .search-residents-form button {
            padding: 12px 20px;
            border-radius: 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .search-residents-form button:hover {
            background-color: #45a049;
        }

        #add-contact .topic {
    font-size: 26px;
    text-align: center;
    color: violet;

    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h2>Manage Residents Contacts</h2>

            <!-- Search Bar for Finding Resident Contacts -->
            <section id="search-section">
                <h2>Find Resident Contact</h2>
                <form method="GET" class="search-residents-form" onsubmit="searchResidentContact(event)">
                    <div class="form-group">
                        <label for="search_query">Search by Name or Address:</label>
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

            <!-- Form to Add Resident Contacts -->
            <section id="add-contact">
                <div class="topic"> Add New Resident Contact</div>
                <form method="POST" class="residents-contacts-form">
                    <div class="form-group">
                        <label for="resident_name">Resident Name:</label>
                        <input type="text" id="resident_name" name="resident_name" required>
                    </div>
                    <div class="form-group">
                        <label for="resident_address">Resident Address:</label>
                        <input type="text" id="resident_address" name="resident_address" required>
                    </div>
                    <div class="form-group">
                        <label for="resident_phone">Phone Number:</label>
                        <input type="text" id="resident_phone" name="resident_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="fixed_line">Fixed Line:</label>
                        <input type="text" id="fixed_line" name="fixed_line" required>
                    </div>
                    <div class="form-group">
                        <label for="resident_email">Email Address:</label>
                        <input type="email" id="resident_email" name="resident_email" required>
                    </div>
                    <button type="submit" class="btn">Save Contact</button>
                </form>

                <p id="success-message" style="display: none; color: green;">Contact saved successfully!</p>
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
                                <td>${resident.phone_number}</td>
                                <td>${resident.fixed_line}</td>
                                <td>${resident.email}</td>
                            `;
                            resultsBody.appendChild(row);
                        });
                        resultsTable.style.display = 'table';
                    } else {
                        resultsTable.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    </script>
</body>

</html>
