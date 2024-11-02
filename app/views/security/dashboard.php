<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <title>Security Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <main>
            <h1>Security Management</h1>
            <p>Manage security operations including visitor passes, incident reports, duty schedules, and visitor log times.</p>

            <!-- Dashboard Widgets -->
            <section class="dashboard-widgets">
                <div class="widget">
                    <h2>Visitor Pass Count</h2>
                    <div class="widget-content">
                        <p>Today: <span id="visitor-pass-today">10</span></p>
                        <p>This Week: <span id="visitor-pass-week">50</span></p>
                        <p>This Month: <span id="visitor-pass-month">200</span></p>
                    </div>
                </div>

                <div class="widget">
                    <h2>Duty Schedule Overview</h2>
                    <div class="widget-content">
                        <p>Next Shift: <span id="next-shift">2024-09-18 14:00</span></p>
                        <p>Current Duty Officer: <span id="current-officer">Officer Smith</span></p>
                    </div>
                </div>

                <div class="widget">
                    <h2>Incident Reports Status</h2>
                    <div class="widget-content">
                        <p>Open: <span id="incident-open">5</span></p>
                        <p>In-Progress: <span id="incident-in-progress">3</span></p>
                        <p>Resolved: <span id="incident-resolved">12</span></p>
                    </div>
                </div>
            </section>

            <section class="security-actions">
                <h2>View Visitor Passes</h2>
                <a href="<?php echo URLROOT; ?>/security/view_visitor_pass" class="btn">View Visitor Passes</a>

                <h2>Log Visitor Times</h2>
                <a href="<?php echo URLROOT; ?>/security/log_in_visitor_times" class="btn">Log Visitor Times</a>

                <h2>Manage User Incident Reports</h2>
                <a href="<?php echo URLROOT; ?>/security/manage_user_incident_report" class="btn">Manage User Incident Reports</a>

                <h2>Update Duty Schedule</h2>
                <a href="<?php echo URLROOT; ?>/security/update_duty_schedule" class="btn">Update Duty Schedule</a>

                <h2>Verify Visitor Details</h2>
                <a href="<?php echo URLROOT; ?>/security/verify_visitor_details" class="btn">Verify Visitor Details</a>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>