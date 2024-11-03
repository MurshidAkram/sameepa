<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <link rel="stylesheet" href="path/to/visitor_pass.css">
    <title>View Visitor Pass | <?php echo SITENAME; ?></title>
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
                <button class="btn-action btn-update" onclick="updatePass()">Update Pass</button>
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

        function updatePass() {
            // Implement update pass logic here
            alert('Update Pass function triggered');
        }
    </script>
</body>

</html>
