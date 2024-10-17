
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_announcement_history.css">
    <title>Announcement History | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
            <main class="announcement-history-dashboard">
                <a href="<?php echo URLROOT; ?>/admin/announcements" class="btn-back">Back</a>
                <h1>Announcement History</h1>
            <section class="announcement-overview">
                <table class="announcement-table">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Target Audience</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data, replace with actual data from your database -->
                        <tr>
                            <td>Community Meeting</td>
                            <td>2023-05-20</td>
                            <td>Annual community meeting to discuss upcoming projects</td>
                            <td>Meeting</td>
                            <td>All Residents</td>
                            <td>High</td>
                        </tr>
                        <tr>
                            <td>Pool Maintenance</td>
                            <td>2023-05-18</td>
                            <td>Pool will be closed for maintenance from May 25-27</td>
                            <td>Maintenance</td>
                            <td>Pool Users</td>
                            <td>Medium</td>
                        </tr>
                        <tr>
                            <td>New Recycling Program</td>
                            <td>2023-05-15</td>
                            <td>Introduction of new recycling guidelines for the community</td>
                            <td>Environmental</td>
                            <td>All Residents</td>
                            <td>Low</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
