
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/view_event_history.css">
    <title>Event History | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
            <main class="event-history-dashboard">
                <a href="<?php echo URLROOT; ?>/admin/events" class="btn-back">Back</a>
                <h1>Event History</h1>
            <section class="event-overview">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Time</th>
                            <th>By Whom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample data, replace with actual data from your database -->
                        <tr>
                            <td>Community BBQ</td>
                            <td>2023-07-15</td>
                            <td>Community Park</td>
                            <td>6:00 PM</td>
                            <td>Resident Association</td>
                        </tr>
                        <tr>
                            <td>Yoga in the Park</td>
                            <td>2023-07-20</td>
                            <td>Central Green</td>
                            <td>8:00 AM</td>
                            <td>Fitness Club</td>
                        </tr>
                        <tr>
                            <td>Movie Night</td>
                            <td>2023-07-25</td>
                            <td>Community Center</td>
                            <td>8:30 PM</td>
                            <td>Entertainment Committee</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
