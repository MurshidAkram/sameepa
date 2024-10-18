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
            <!-- Dashboard Header -->
            <header class="dashboard-header">
                <div class="user-info">
                    <p>Welcome, <strong><?php echo $_SESSION['user_name']; ?></strong> (Maintenance Personnel)</p>
                    <p id="current-date-time"></p>
                </div>

                <div class="dashboard-controls">
                    <input type="text" placeholder="Search..." class="search-bar">
                    <div class="filter-options">
                        <label for="filter-status">Filter by Status:</label>
                        <select id="filter-status">
                            <option value="all">All</option>
                            <option value="completed">Completed</option>
                            <option value="in-progress">In Progress</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="quick-links">
                        <a href="#">Notifications <span class="badge">3</span></a>
                        <a href="#">Settings</a>
                    </div>
                </div>
            </header>

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
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example dynamic content; replace with actual data -->
                            <tr>
                                <td>MH001</td>
                                <td>2024-09-10</td>
                                <td>AC unit repair</td>
                                <td>Completed</td>
                                <td><div class="progress-bar"><div class="progress" style="width: 100%;"></div></div></td>
                            </tr>
                            <tr>
                                <td>MH002</td>
                                <td>2024-09-12</td>
                                <td>Light fixture replacement</td>
                                <td>In Progress</td>
                                <td><div class="progress-bar"><div class="progress" style="width: 60%;"></div></div></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>

                <!-- Report Issues -->
                <h2>Report Issues</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/report" method="POST" class="form-report">
                    <div class="form-group">
                        <label for="issue-description">Issue Description:</label>
                        <textarea id="issue-description" name="description" placeholder="Describe the issue..." required></textarea>
                    </div>
                    <button type="submit" class="btn-report">Report Issue</button>
                </form>

                <!-- Request Assistance -->
                <h2>Request Assistance</h2>
                <form action="<?php echo URLROOT; ?>/maintenance/request" method="POST" class="form-request">
                    <div class="form-group">
                        <label for="request-details">Request Details:</label>
                        <textarea id="request-details" name="details" placeholder="Provide details..." required></textarea>
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
                                <td><span class="status scheduled">Scheduled</span></td>
                            </tr>
                            <tr>
                                <td>2024-09-16</td>
                                <td>Inspect elevators</td>
                                <td><span class="status scheduled">Scheduled</span></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // JavaScript to display current date and time
        const dateTimeElement = document.getElementById('current-date-time');
        function updateDateTime() {
            const now = new Date();
            dateTimeElement.textContent = now.toLocaleString();
        }
        setInterval(updateDateTime, 1000);
    </script>
</body>

</html>
