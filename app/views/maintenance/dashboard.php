<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Maintenance Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <!-- Include the navbar -->
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Include the maintenance sidebar -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Maintenance Management</h1>
            <p>Manage maintenance requests, tasks, and schedules.</p>

            <section class="maintenance-actions">
                <!-- View Maintenance Requests -->
                <h2>View Maintenance Requests</h2>
                <div class="form-group">
                    <label for="maintenance_requests">Requests:</label>
                    <textarea id="maintenance_requests" name="maintenance_requests" readonly>Requests will be displayed here...</textarea>
                </div>

                <!-- Log Maintenance Tasks -->
                <h2>Log Maintenance Tasks</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/logTask" method="POST">
                    <div class="form-group">
                        <label for="task_description">Task Description:</label>
                        <textarea id="task_description" name="task_description" required></textarea>
                    </div>
                    <button type="submit" class="btn-log">Log Task</button>
                </form>

                <!-- Update Maintenance Schedule -->
                <h2>Update Maintenance Schedule</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/updateSchedule" method="POST">
                    <div class="form-group">
                        <label for="maintenance_schedule">Schedule:</label>
                        <textarea id="maintenance_schedule" name="maintenance_schedule">Enter updated schedule...</textarea>
                    </div>
                    <button type="submit" class="btn-update">Update Schedule</button>
                </form>

                <!-- Manage Maintenance Reports -->
                <h2>Manage Maintenance Reports</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/manageReports" method="POST">
                    <div class="form-group">
                        <label for="maintenance_reports">Reports:</label>
                        <textarea id="maintenance_reports" name="maintenance_reports" readonly>Reports will be displayed here...</textarea>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <!-- Include the footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
