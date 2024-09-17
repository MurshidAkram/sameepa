<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Update Maintenance Status | <?php echo SITENAME; ?></title>
    <style>
        /* Custom styling for the update status form */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group select,
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .btn-update {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-update:hover {
            background-color: #0056b3;
        }

        /* Styling for the task status overview */
        .task-overview {
            margin-top: 2rem;
        }

        .task-card {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .task-card h2 {
            margin-top: 0;
        }

        .task-card .task-item {
            margin-bottom: 0.5rem;
        }

        .task-card .status {
            font-weight: bold;
        }

        .task-card .status.pending {
            color: #ffc107;
        }

        .task-card .status.in-progress {
            color: #17a2b8;
        }

        .task-card .status.completed {
            color: #28a745;
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <!-- Side Panel -->
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <!-- Main Content -->
        <main>
            <h1>Update Maintenance Status</h1>
            <div class="card">
                <!-- Status Update Form -->
                <form action="<?php echo URLROOT; ?>/maintenance/update" method="POST">
                    <div class="form-group">
                        <label for="maintenance-id">Select Tasks:</label>
                        <select id="maintenance-id" name="maintenance_ids[]" multiple required>
                            <!-- Example options; replace with dynamic data -->
                            <option value="task1">Task 1</option>
                            <option value="task2">Task 2</option>
                            <option value="task3">Task 3</option>
                            <!-- Add more options as needed -->
                        </select>
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
                        <textarea id="comments" name="comments"></textarea>
                    </div>
                    <button type="submit" class="btn-update">Update Status</button>
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
                <!-- Add more task cards as needed -->
            </div>
        </main>
    </div>

    <!-- Footer -->
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
