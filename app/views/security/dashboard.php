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
            <p>Manage security operations including visitor passes, schedules, and incident reports.</p>

            <section class="security-actions">
                <!-- View Visitor Passes -->
                <h2>View Visitor Passes</h2>
                <div class="card">
                    <textarea id="visitor_passes" name="visitor_passes" readonly>Passes will be displayed here...</textarea>
                </div>

                <!-- Verify Visitor Details -->
                <h2>Verify Visitor Details</h2>
                <form action="<?php echo URLROOT; ?>/security/verifyVisitor" method="POST">
                    <div class="form-group">
                        <label for="visitor_id">Visitor ID:</label>
                        <input type="text" id="visitor_id" name="visitor_id" required>
                    </div>
                    <button type="submit" class="btn-verify">Verify Visitor</button>
                </form>

                <!-- Log Visitor Times -->
                <h2>Log Visitor Times</h2>
                <form action="<?php echo URLROOT; ?>/security/logVisitorTime" method="POST">
                    <div class="form-group">
                        <label for="visitor_id_time">Visitor ID:</label>
                        <input type="text" id="visitor_id_time" name="visitor_id_time" required>
                    </div>
                    <button type="submit" class="btn-log">Log Time</button>
                </form>

                <!-- Update Duty Schedule -->
                <h2>Update Duty Schedule</h2>
                <form action="<?php echo URLROOT; ?>/security/updateDutySchedule" method="POST">
                    <div class="form-group">
                        <label for="duty_schedule">Duty Schedule:</label>
                        <textarea id="duty_schedule" name="duty_schedule">Enter updated schedule...</textarea>
                    </div>
                    <button type="submit" class="btn-update">Update Schedule</button>
                </form>

                <!-- Manage User Incident Reports -->
                <h2>Manage User Incident Reports</h2>
                <div class="card">
                    <textarea id="incident_reports" name="incident_reports" readonly>Incident reports will be displayed here...</textarea>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
