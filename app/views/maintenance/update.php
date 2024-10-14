<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/update.css">
    <title>Update Maintenance Status | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main>
            <h1>Update Maintenance Status</h1>
            <div class="card update-card">
                <!-- Status Update Form -->
                <form action="<?php echo URLROOT; ?>/maintenance/update" method="POST" class="update-form">
                    <div class="form-group">
                        <label for="maintenance-id">Select Tasks:</label>
                        <select id="maintenance-id" name="maintenance_ids[]" multiple required>
                            <!-- Example options; replace with dynamic data -->
                            <option value="task1">Task 1</option>
                            <option value="task2">Task 2</option>
                            <option value="task3">Task 3</option>
                        </select>
                        <span class="tooltip">Hold Ctrl (or Cmd) to select multiple tasks</span>
                    </div>
                    <div class="form-group">
                        <label for="status">New Status:</label>
                        <select id="status" name="status" required>
                            <option value="Started">Started</option>
                            <option value="Paused">Paused</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comments">Optional Comments:</label>
                        <textarea id="comments" name="comments" placeholder="Enter any comments here..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-update">Update Status</button>
                        <button type="reset" class="btn-reset">Clear Form</button>
                    </div>
                </form>
            </div>

            <!-- Task Status Overview -->
            <div class="task-overview">
                <h2>Task Status Overview</h2>
                <!-- Example task cards; replace with dynamic data -->
                <div class="task-card">
                    <h2>Task 1</h2>
                    <p class="task-item">Description of Task 1</p>
                    <p class="status pending">Pending</p>
                </div>
                <div class="task-card">
                    <h2>Task 2</h2>
                    <p class="task-item">Description of Task 2</p>
                    <p class="status in-progress">In Progress</p>
                </div>
                <div class="task-card">
                    <h2>Task 3</h2>
                    <p class="task-item">Description of Task 3</p>
                    <p class="status completed">Completed</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
