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
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <h1>Maintenance Management</h1>
            <p>Manage maintenance operations including history, issue reporting, assistance requests, schedules, and status updates.</p>

            <section class="maintenance-actions">
                <!-- View Maintenance History -->
                <h2>View Maintenance History</h2>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Maintenance ID</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>MH001</td>
                                <td>2024-09-10</td>
                                <td>AC unit repair</td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>MH002</td>
                                <td>2024-09-12</td>
                                <td>Light fixture replacement</td>
                                <td>In Progress</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>

                <!-- Report Issues -->
                <h2>Report Issues</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/report" method="POST">
                    <div class="form-group">
                        <label for="issue-description">Issue Description:</label>
                        <textarea id="issue-description" name="description" required></textarea>
                    </div>
                    <button type="submit" class="btn-report">Report Issue</button>
                </form>

                <!-- Request Assistance -->
                <h2>Request Assistance</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/request" method="POST">
                    <div class="form-group">
                        <label for="request-details">Request Details:</label>
                        <textarea id="request-details" name="details" required></textarea>
                    </div>
                    <button type="submit" class="btn-request">Request Assistance</button>
                </form>

                <!-- View Schedule -->
                <h2>View Schedule</h2>
                <div class="card">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Task</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>2024-09-15</td>
                                <td>Check fire alarms</td>
                                <td>Scheduled</td>
                            </tr>
                            <tr>
                                <td>2024-09-16</td>
                                <td>Inspect elevators</td>
                                <td>Scheduled</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>

                <!-- Update Maintenance Status -->
                <h2>Update Maintenance Status</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/update" method="POST">
                    <div class="form-group">
                        <label for="maintenance-id">Maintenance ID:</label>
                        <input type="text" id="maintenance-id" name="maintenance_id" required>
                    </div>
                    <div class="form-group">
                        <label for="status">New Status:</label>
                        <select id="status" name="status" required>
                            <option value="Completed">Completed</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-update">Update Status</button>
                </form>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
