<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_complaint_history.css">
    <title>Complaint History | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
            <main class="complaint-history-dashboard">
                <a href="<?php echo URLROOT; ?>/admin/complaints" class="btn-back">Back</a>
                <h1>Complaint History</h1>
            <section class="complaint-overview">
                <table class="complaint-table">
                    <thead>
                        <tr>
                            <th>Complaint Title</th>
                            <th>Date</th>
                            <th>Action Taken</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data, replace with actual data from your database -->
                        <tr>
                            <td>Noise Complaint</td>
                            <td>2023-05-15</td>
                            <td>Issued warning to resident</td>
                            <td>Resolved</td>
                        </tr>
                        <tr>
                            <td>Maintenance Issue</td>
                            <td>2023-05-14</td>
                            <td>Scheduled repair</td>
                            <td>In Progress</td>
                        </tr>
                        <tr>
                            <td>Parking Violation</td>
                            <td>2023-05-13</td>
                            <td>Issued fine</td>
                            <td>Closed</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
