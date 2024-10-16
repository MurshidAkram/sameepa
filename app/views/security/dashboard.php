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
            <!-- Dashboard Header -->
            <section class="dashboard-header">
                <h1>Security Management</h1>
                <p>Manage security operations including visitor passes, incident reports, duty schedules, and visitor log times.</p>
            </section>

            <hr> <!-- Horizontal rule to separate sections -->

            <!-- Security Operations Overview (Using Table for Clear Display) -->
            <section class="dashboard-overview">
                <h2>Overview of Operations</h2>
                <table>
                    <tr>
                        <th>Operation</th>
                        <th>Details</th>
                    </tr>
                    <tr>
                        <td>Visitor Pass Count</td>
                        <td>Today: <span id="visitor-pass-today">10</span><br>This Week: <span id="visitor-pass-week">50</span><br>This Month: <span id="visitor-pass-month">200</span></td>
                    </tr>
                    <tr>
                        <td>Duty Schedule</td>
                        <td>Next Shift: <span id="next-shift">2024-09-18 14:00</span><br>Current Duty Officer: <span id="current-officer">Officer Smith</span></td>
                    </tr>
                    <tr>
                        <td>Incident Reports</td>
                        <td>Open: <span id="incident-open">5</span><br>In-Progress: <span id="incident-in-progress">3</span><br>Resolved: <span id="incident-resolved">12</span></td>
                    </tr>
                </table>
            </section>

            <hr> <!-- Another Horizontal Rule -->

            <!-- Security Actions Section (Table with Action Buttons) -->
            <section class="security-actions">
                <h2>Security Actions</h2>

                <!-- Security Actions Table -->
                <table class="action-table">
                    <tr>
                        <th>Action</th>
                        <th>Link</th>
                    </tr>

                    <!-- View Visitor Passes -->
                    <tr>
                        <td>View Visitor Passes</td>
                        <td><a href="<?php echo URLROOT; ?>/security/view_visitor_pass" class="btn">View Visitor Passes</a></td>
                    </tr>

                    <!-- Log Visitor Times -->
                    <tr>
                        <td>Log Visitor Times</td>
                        <td><a href="<?php echo URLROOT; ?>/security/log_in_visitor_times" class="btn">Log Visitor Times</a></td>
                    </tr>

                    <!-- Manage User Incident Reports -->
                    <tr>
                        <td>Manage User Incident Reports</td>
                        <td><a href="<?php echo URLROOT; ?>/security/manage_user_incident_report" class="btn">Manage User Incident Reports</a></td>
                    </tr>

                    <!-- Update Duty Schedule -->
                    <tr>
                        <td>Update Duty Schedule</td>
                        <td><a href="<?php echo URLROOT; ?>/security/update_duty_schedule" class="btn">Update Duty Schedule</a></td>
                    </tr>

                    <!-- Verify Visitor Details -->
                    <tr>
                        <td>Verify Visitor Details</td>
                        <td><a href="<?php echo URLROOT; ?>/security/verify_visitor_details" class="btn">Verify Visitor Details</a></td>
                    </tr>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
