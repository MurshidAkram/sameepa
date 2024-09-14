<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>External Service Provider Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <h1>External Service Provider Dashboard</h1>
            <section class="dashboard-content">
                <h2>Welcome, Service Provider</h2>
                <p>Here you can manage service requests and update your profile.</p>

                <div class="dashboard-links">
                    <a href="<?php echo URLROOT; ?>/external/requests" class="dashboard-link">View Service Requests</a>
                    <a href="<?php echo URLROOT; ?>/external/profile" class="dashboard-link">Update Profile</a>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>