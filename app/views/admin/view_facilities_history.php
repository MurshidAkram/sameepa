
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_facilities_history.css">
    <title>Facilities History | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
            <main class="facilities-history-dashboard">
                <a href="<?php echo URLROOT; ?>/admin/facilities" class="btn-back">Back</a>
                <h1>Facilities History</h1>
            <section class="facilities-overview">
                <table class="facilities-table">
                    <thead>
                        <tr>
                            <th>Resident Name</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data, replace with actual data from your database -->
                        <tr>
                            <td>John Doe</td>
                            <td>Swimming Pool</td>
                            <td>2023-05-15</td>
                            <td>14:00</td>
                            <td>2 hours</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Gym</td>
                            <td>2023-05-14</td>
                            <td>10:00</td>
                            <td>1 hour</td>
                            <td>Scheduled</td>
                        </tr>
                        <tr>
                            <td>Mike Johnson</td>
                            <td>Tennis Court</td>
                            <td>2023-05-13</td>
                            <td>16:00</td>
                            <td>1.5 hours</td>
                            <td>Cancelled</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
