<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Update Maintenance Status | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Update Maintenance Status</h1>
            <div class="card">
                <form action="<?php echo URLROOT; ?>/maintenance/updateStatus" method="POST">
                    <div class="form-group">
                        <label for="maintenance-task">Maintenance Task:</label>
                        <select id="maintenance-task" name="task_id" required>
                            <option value="">Select Task</option>
                            <!-- Dynamic task options would go here -->
                            <option value="1">Task 1: Fix leaking pipe</option>
                            <option value="2">Task 2: Replace broken light</option>
                            <!-- Add more tasks as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-update">Update Status</button>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
