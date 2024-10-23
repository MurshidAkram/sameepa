<!-- app/views/superadmin/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Super Admin Dashboard | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
    <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>
        <main>
       
            <h1>Super Admin Dashboard</h1>
            <section class="dashboard-overview">
                <div class="dashboard-item">
                    <h2>User Management</h2>
                    <p>View and manage all system users.</p>
                    <a href="<?php echo URLROOT; ?>/superadmin/users">Go to User Management</a>
                </div>

                <div class="dashboard-item">
                    <h2>Settings</h2>
                    <p>Configure system settings and preferences.</p>
                    <a href="<?php echo URLROOT; ?>/superadmin/settings">Go to Settings</a>
                </div>

                <div class="dashboard-item">
                    <h2>Reports</h2>
                    <p>Generate and view system reports.</p>
                    <a href="<?php echo URLROOT; ?>/superadmin/reports">View Reports</a>
                </div>

                <div class="dashboard-item">
                    <h2>Announcements</h2>
                    <p>Create and manage community announcements.</p>
                    <a href="<?php echo URLROOT; ?>/superadmin/announcements">Manage Announcements</a>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>