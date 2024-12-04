<!-- app/views/resident/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <title>Resident Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Welcome Back! <?php echo $_SESSION['name'] ?></h1>

            <section class="dashboard-overview">
                <div class="overview-card announcements">
                    <h2>View the Latest Announcements</h2>
                    <a href="<?php echo URLROOT; ?>/announcements/index" class="btn-view">View All</a>
                </div>
                <div class="overview-card events">
                    <h2>Upcoming Events in the Community</h2>
                    <a href="<?php echo URLROOT; ?>/events/index" class="btn-view">View Events</a>
                </div>
                <div class="overview-card maintenance">
                    <h2>Maintenance Requests</h2>
                    <a href="<?php echo URLROOT; ?>/resident/maintenance" class="btn-view">Submit Request</a>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>