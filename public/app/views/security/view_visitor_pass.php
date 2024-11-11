<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>View Visitor Pass | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styles for the view visitor pass page */
        .visitor-pass-section {
            margin-top: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 8px 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .btn-action {
            margin-top: 20px;
            margin-right: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .btn-issue {
            background-color: #28a745;
        }
        .btn-issue:hover {
            background-color: #218838;
        }
        .btn-verify {
            background-color: #007bff;
        }
        .btn-verify:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>View Visitor Pass</h1>

            <!-- Search/Filter Bar -->
            <section class="search-bar">
                <input type="text" id="search-input" placeholder="Search by name, pass type, or date...">
                <button onclick="searchPasses()">Search</button>
            </section>

            <!-- Action Buttons -->
            <section class="action-buttons">
                <button class="btn-action btn-issue" onclick="issueNewPass()">Issue New Pass</button>
                <button class="btn-action btn-verify" onclick="verifyPass()">Verify Pass</button>
                <button class="btn-action btn-delete" onclick="deletePass()">Delete Pass</button>
            </section>

            <!-- Visitor Pass Table -->
            <section class="visitor-pass-section">
                <table>
                    <thead>
                        <tr>
                            <th>Visitor Pass ID</th>
                            <th>Visitor Name</th>
                            <th>Pass Type</th>
                            <th>Entry Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example dynamic content; replace with actual data -->
                        <tr>
                            <td>VP001</td>
                            <td>John Doe</td>
                            <td>Guest</td>
                            <td>2024-09-17 10:00</td>
                            <td>Verified</td>
                        </tr>
                        <tr>
                            <td>VP002</td>
                            <td>Jane Smith</td>
                            <td>Delivery</td>
                            <td>2024-09-18 11:00</td>
                            <td>Pending</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- JavaScript for search and button actions -->
    <script>
        function searchPasses() {
            // Implement search logic here
            alert('Search function triggered');
        }

        function issueNewPass() {
            // Implement issue new pass logic here
            alert('Issue New Pass function triggered');
        }

        function verifyPass() {
            // Implement verify pass logic here
            alert('Verify Pass function triggered');
        }

        function deletePass() {
            // Implement delete pass logic here
            alert('Delete Pass function triggered');
        }
    </script>
</body>

</html>
