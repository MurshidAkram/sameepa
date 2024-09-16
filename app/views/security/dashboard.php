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
                    <table>
                        <thead>
                            <tr>
                                <th>Pass ID</th>
                                <th>Visitor Name</th>
                                <th>Date Issued</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>VP001</td>
                                <td>John Doe</td>
                                <td>2024-09-10</td>
                                <td>Active</td>
                            </tr>
                            <tr>
                                <td>VP002</td>
                                <td>Jane Smith</td>
                                <td>2024-09-12</td>
                                <td>Expired</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
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
                    <table>
                        <thead>
                            <tr>
                                <th>Incident ID</th>
                                <th>Date</th>
                                <th>Report</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>IR001</td>
                                <td>2024-09-11</td>
                                <td>Unauthorized entry</td>
                                <td>Investigating</td>
                            </tr>
                            <tr>
                                <td>IR002</td>
                                <td>2024-09-13</td>
                                <td>Property damage</td>
                                <td>Resolved</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
