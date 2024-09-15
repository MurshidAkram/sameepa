<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Manage Visitor Passes | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Manage Visitor Passes</h1>
            
            <!-- Search and Filter Section -->
            <section class="search-filter">
                <form action="<?php echo URLROOT; ?>/security/manageVisitorPasses" method="GET">
                    <input type="text" name="search" placeholder="Search by Visitor Name or Pass ID" value="<?php echo htmlspecialchars($search ?? '', ENT_QUOTES); ?>">
                    <button type="submit">Search</button>
                </form>
            </section>

            <!-- Create New Pass Section -->
            <section class="create-pass">
                <h2>Create New Visitor Pass</h2>
                <form action="<?php echo URLROOT; ?>/security/createVisitorPass" method="POST">
                    <label for="visitorName">Visitor Name:</label>
                    <input type="text" id="visitorName" name="visitorName" required>
                    
                    <label for="passID">Pass ID:</label>
                    <input type="text" id="passID" name="passID" required>
                    
                    <label for="expiryDate">Expiry Date:</label>
                    <input type="date" id="expiryDate" name="expiryDate" required>
                    
                    <button type="submit">Create Pass</button>
                </form>
            </section>

            <!-- Visitor Passes Table -->
            <section class="visitor-passes">
                <h2>View and Approve Visitor Passes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Visitor Name</th>
                            <th>Pass ID</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example dynamic content; replace with actual data -->
                        <tr>
                            <td>John Doe</td>
                            <td>VP12345</td>
                            <td>2024-09-30</td>
                            <td>Pending</td>
                            <td><button class="approve-btn">Approve</button></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>

            <!-- Pagination Section (if needed) -->
            <section class="pagination">
                <a href="?page=1">First</a>
                <a href="?page=<?php echo $prevPage; ?>">Previous</a>
                <span>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>
                <a href="?page=<?php echo $nextPage; ?>">Next</a>
                <a href="?page=<?php echo $totalPages; ?>">Last</a>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
