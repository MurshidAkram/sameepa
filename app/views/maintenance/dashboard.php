<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">

    <title>Maintenance Dashboard | <?php echo SITENAME; ?></title>
    <style>
       /* General Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to bottom, #f3f4f7, #e9e9ff);
    margin: 0;
    padding: 0;
    color: #555;
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
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.dashboard-header p {
    margin: 0;
    font-size: 1rem;
    color: #777;
}

.dashboard-controls {
    display: flex;
    gap: 20px;
    align-items: center;
}

.search-bar {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 200px;
    transition: border-color 0.3s;
}

.search-bar:focus {
    border-color: #3f51b5;
    outline: none;
}

.filter-options select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f8f9fa;
    color: #555;
}

.quick-links a {
    color: #ffffff;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 8px;
    background: linear-gradient(to right, #42a5f5, #2196f3);
    box-shadow: 0 3px 8px rgba(33, 150, 243, 0.3);
    transition: all 0.3s;
}

.quick-links a:hover {
    background: linear-gradient(to right, #1e88e5, #1976d2);
}

/* Overview Cards */
.overview-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.card {
    flex: 1 1 calc(25% - 20px);
    background: (#A93CC7);
    color: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    min-width: 200px;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.card h3 {
    margin: 0 0 10px;
    font-size: 1.5rem;
    color: #800080;
}

.card p {
    font-size: 1.3rem;
    font-weight: bold;
    margin: 0;
}

/* Charts Section */
.charts-section {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.chart-card {
    flex: 1;
    padding: 20px;
    border-radius: 15px;
    background:( #4C3E4F);
    color: #000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
}

.chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.chart-card h4 {
    margin: 0 0 15px;
    font-size: 1.3rem;
}

/* Reminders & Summary */
.reminders,
.summary {
    padding: 20px;
    border-radius: 15px;
    background: #e8f5e9;
    color: #388e3c;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.reminders h4,
.summary h4 {
    margin: 0 0 15px;
    font-size: 1.3rem;
    color: #1b5e20;
}

.reminders ul li,
.summary ul li {
    font-size: 1rem;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s;
}

.reminders ul li:hover,
.summary ul li:hover {
    background: #dcedc8;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

table thead {
    background: #0288d1;
    color: #fff;
}

table th,
table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table tbody tr:hover {
    background: #e3f2fd;
}

/* Footer */
footer {
    margin-top: 20px;
    text-align: center;
    font-size: 0.9rem;
    color: #666;
}
 /* Include the CSS from your previous message */
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
                    <p>Welcome, <strong><?php //echo $_SESSION['user_name']; ?></strong> (Maintenance Personnel)</p>
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
                    <h3>Scheme Maintenance</h3>
                    <p>Upcoming: 8 | Ongoing: 3 | Past: 15</p>
                </div>
                <!-- <div class="card">
                    <h3>Inventory Stock</h3>
                    <p>Low: 5 | Critical: 2</p>
                </div> -->
                <div class="card">
                    <h3>Team Productivity</h3>
                    <p>Avg Tasks/Day: 7 | Completion Rate: 95%</p>
                </div>
            </section>

            <!-- Detailed Charts -->
            <section class="charts-section">
                <div class="chart-card">
                    <h4>Repair Categories</h4>
                    <canvas id="repair-category-chart"></canvas>
                </div>
                <!-- <div class="chart-card">
                    <h4>Response Time Metrics</h4>
                    <canvas id="response-time-chart"></canvas>
                </div> -->
                <div class="chart-card">
                    <h4>Resident Satisfaction</h4>
                    <canvas id="satisfaction-chart"></canvas>
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

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Repair Categories Chart
        const repairCategoryCtx = document.getElementById('repair-category-chart').getContext('2d');
        new Chart(repairCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electrical', 'Plumbing', 'HVAC', 'Other'],
                datasets: [{
                    data: [25, 30, 20, 25],
                    backgroundColor: ['#8A2BE2', '#7B68EE', '#6A5ACD', '#9370DB'],

                }]
            }
        });

        // // Response Time Metrics Chart
        // const responseTimeCtx = document.getElementById('response-time-chart').getContext('2d');
        // new Chart(responseTimeCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['1-2 hrs', '2-4 hrs', '4-8 hrs', '8+ hrs'],
        //         datasets: [{
        //             label: 'Tasks',
        //             data: [10, 20, 15, 5],
        //             backgroundColor: '#A93CC7',
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });

        // Resident Satisfaction Chart
        const satisfactionCtx = document.getElementById('satisfaction-chart').getContext('2d');
        new Chart(satisfactionCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Satisfaction Rate (%)',
                    data: [85, 88, 90, 92, 91, 95],
                    borderColor: '#800080',
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 80,
                        max: 100
                    }
                }
            }
        });

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
