<!-- app/views/maintenance/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Maintenance Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Maintenance Team Dashboard</h1>
            <section class="dashboard-content">
                <h2>Welcome, Maintenance Team</h2>
                <p>Manage maintenance requests and duty schedules here.</p>

                <div class="dashboard-links">
                    <a href="<?php echo URLROOT; ?>/maintenance/requests" class="dashboard-link">Manage Maintenance Requests</a>
                    <a href="<?php echo URLROOT; ?>/maintenance/schedules" class="dashboard-link">Manage Duty Schedules</a>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>