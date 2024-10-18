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
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .visitor-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .visitor-card h3 {
            margin: 0 0 10px;
        }

        .visitor-card p {
            margin: 5px 0;
        }

        .visitor-card .status {
            font-weight: bold;
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

            <!-- Visitor Pass Section with Cards -->
            <section class="visitor-pass-section">
                <!-- Example Visitor Cards -->
                <div class="visitor-card">
                    <h3>Visitor Pass ID: VP001</h3>
                    <p><strong>Visitor Name:</strong> John Doe</p>
                    <p><strong>Pass Type:</strong> Guest</p>
                    <p><strong>Entry Time:</strong> 2024-09-17 10:00</p>
                    <p class="status"><strong>Status:</strong> Verified</p>
                </div>

                <div class="visitor-card">
                    <h3>Visitor Pass ID: VP002</h3>
                    <p><strong>Visitor Name:</strong> Jane Smith</p>
                    <p><strong>Pass Type:</strong> Delivery</p>
                    <p><strong>Entry Time:</strong> 2024-09-18 11:00</p>
                    <p class="status"><strong>Status:</strong> Pending</p>
                </div>

                <!-- Add more cards dynamically as needed -->
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
