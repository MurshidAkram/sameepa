<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/maintenance/dashboard.css">
    <title>Maintenance Dashboard | <?php echo SITENAME; ?></title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 20px;
        }

        main {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-header p {
            margin: 0;
        }

        .dashboard-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .overview-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .card {
            flex: 1 1 calc(25% - 20px);
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 200px;
        }

        .card h3 {
            color: #ff5a5f;
            margin: 0 0 10px;
            font-size: 1.2rem;
        }

        .card p {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        .charts-section {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .chart-card {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-card h4 {
            color: #ff5a5f;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .reminders, .summary {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .reminders h4, .summary h4 {
            color: #ff5a5f;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .reminders ul, .summary ul {
            list-style: none;
            padding: 0;
        }

        .reminders ul li, .summary ul li {
            font-size: 1rem;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
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
            <p>Manage maintenance operations, including history, reporting, assistance requests, schedules, and updates.</p>

            <!-- Overview Cards -->
            <section class="overview-cards">
                <div class="card">
                    <h3>Resident Requests</h3>
                    <p>Active: 10 | Resolved: 20 | Overdue: 5</p>
                </div>
                <div class="card">
                    <h3>Scheme Maintenance</h3>
                    <p>Upcoming: 8 | Ongoing: 3 | Past: 15</p>
                </div>
                <div class="card">
                    <h3>Inventory Stock</h3>
                    <p>Low: 5 | Critical: 2</p>
                </div>
                <div class="card">
                    <h3>Team Productivity</h3>
                    <p>Avg Tasks/Day: 7 | Completion Rate: 95%</p>
                </div>
            </section>

            <!-- Detailed Charts -->
            <section class="charts-section">
                <div class="chart-card">
                    <h4>Repair Categories</h4>
                    <div id="repair-category-chart">[Chart Placeholder]</div>
                </div>
                <div class="chart-card">
                    <h4>Response Time Metrics</h4>
                    <div id="response-time-chart">[Chart Placeholder]</div>
                </div>
                <div class="chart-card">
                    <h4>Resident Satisfaction</h4>
                    <div id="satisfaction-chart">[Chart Placeholder]</div>
                </div>
            </section>

            <!-- Task Reminders -->
            <section class="reminders">
                <h4>Upcoming Task Reminders</h4>
                <ul>
                    <li>High-priority Task 1 - Due Today</li>
                    <li>High-priority Task 2 - Due in 3 Days</li>
                    <li>High-priority Task 3 - Due This Week</li>
                </ul>
            </section>

            <!-- Daily/Weekly Summary -->
            <section class="summary">
                <h4>Daily/Weekly Summary</h4>
                <ul>
                    <li>Total Requests Submitted: 15</li>
                    <li>Total Tasks Completed: 12</li>
                    <li>Major Issues Logged: 2</li>
                </ul>
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
