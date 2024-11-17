<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
   
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/form-styles.css">
    <title>Enhanced Security Dashboard | <?php echo SITENAME; ?></title>

</head>

<body>
    <style>
        /* General Dashboard Styling */
        .dashboard-container {
            display: flex;
            background-color: #f8f9fa;
            padding: 20px;
            gap: 20px;
        }

        .side-panel {
            flex-basis: 15%;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            margin-bottom: 15px;
            font-size: 1.5em;
            color: #333;
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }



        .card {
            flex: 1 1 calc(33.333% - 20px);
            min-width: 250px;
            background: #f7f7f7;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 1.2em;
            color: #333;
        }

        .card p {
            font-size: 1em;
            color: #555;
        }

        .chart {
            flex: 1 1 calc(50% - 20px);
            min-width: 300px;
        }

        canvas {
            width: 100%;
            height: 250px;
        }

        .action {
            background-color: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 10px;
        }

        .action:hover {
            background-color: #2980b9;
        }
        /* Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            display: none; /* Hidden by default */
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .data-table th {
            background-color: #3498db;
            color: white;
        }

        .data-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data-table tr:hover {
            background-color: #e9ecef;
        }

        .data-table td {
            font-size: 1.1em;
        }

        .action.active {
            background-color: #2980b9;
        }
        .too{
            text-align: left;
            color :#800080;
            padding-right: 95px;
            font-size: 24px;
        }

    </style>

    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <div class="main-content">
            <!-- Key Metrics Section -->
            <section class="section">
                <h3 class="too">Key Metrics</h3>
                <div class="grid">
                    <div class="card" style="background-color: #1abc9c;">
                        <h3>Total Alerts</h3>
                        <p>Today: <span id="total-alerts">15</span></p>
                    </div>
                    <div class="card" style="background-color: #3498db;">
                        <h3>Active Visitor Passes</h3>
                        <p>Currently: <span id="active-passes">5</span></p>
                    </div>
                    <div class="card" style="background-color: #f39c12;">
                        <h3>Security Personnel On Duty</h3>
                        <p>Active: <span id="on-duty">10</span></p>
                    </div>
                    <div class="card" style="background-color: #9b59b6;">
                        <h3>Recent Emergency Calls</h3>
                        <p>Last: <span id="recent-emergency">911 at 10:35 AM</span></p>
                    </div>
                </div>
            </section>

            <!-- Real-Time Monitoring Section with Charts -->
            <section class="section">
                <h3 class="too">Real-Time Monitoring</h3>
                <div class="grid">
                    <div class="chart">
                        <h3>Live Camera Feeds</h3>
                        <p>View ongoing surveillance</p>
                        <button class="action" onclick="toggleTable('camera')">View Feeds</button>
                        <canvas id="cameraFeedsCanvas"></canvas>

                        <!-- Camera Feeds Table -->
                    <table class="data-table" id="cameraTable">
                        <thead>
                            <tr>
                                <th>Camera ID</th>
                                <th>Status</th>
                                <th>Viewers</th>
                                <th>Location</th>
                                <th>Resolution</th>
                                <th>Last Maintenance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Camera 1</td>
                                <td>Active</td>
                                <td>15</td>
                                <td>Main Entrance</td>
                                <td>1080p</td>
                                <td>2024-01-15</td>
                            </tr>
                            <tr>
                                <td>Camera 2</td>
                                <td>Inactive</td>
                                <td>0</td>
                                <td>Garage</td>
                                <td>720p</td>
                                <td>2023-12-10</td>
                            </tr>
                            <tr>
                                <td>Camera 3</td>
                                <td>Active</td>
                                <td>10</td>
                                <td>Lobby</td>
                                <td>1080p</td>
                                <td>2024-02-01</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                    
                    <div class="chart">
                        <h3>Recent Access Logs</h3>
                        <p>Visitors: 12 | Residents: 45</p>
                        <button class="action" onclick="toggleTable('access')">View Logs</button>

                        <canvas id="accessLogsCanvas"></canvas>

                         <!-- Access Logs Table -->
                    <table class="data-table" id="accessTable">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Visitor</th>
                                <th>Access Point</th>
                                <th>Access Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>08:00 AM</td>
                                <td>John Doe</td>
                                <td>Main Gate</td>
                                <td>Visitor</td>
                                <td>Granted</td>
                            </tr>
                            <tr>
                                <td>09:00 AM</td>
                                <td>Jane Smith</td>
                                <td>Visitor Entrance</td>
                                <td>Visitor</td>
                                <td>Granted</td>
                            </tr>
                            <tr>
                                <td>10:30 AM</td>
                                <td>Mark Lee</td>
                                <td>Garage</td>
                                <td>Resident</td>
                                <td>Denied</td>
                            </tr>
                        </tbody>
                    </table>

                    </div>
                    <div class="chart">
                        <h3>Alarm Status</h3>
                        <p>Status: <span style="color: red;">Triggered</span></p>
                        <button class="action" onclick="toggleTable('alarm')">View Alarms</button>
                        <canvas id="alarmStatusCanvas"></canvas>

                         <!-- Alarm Status Table -->
                    <table class="data-table" id="alarmTable">
                        <thead>
                            <tr>
                                <th>Alarm ID</th>
                                <th>Status</th>
                                <th>Triggered Time</th>
                                <th>Location</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ALARM-001</td>
                                <td>Triggered</td>
                                <td>10:30 AM</td>
                                <td>Main Gate</td>
                                <td>Intruder</td>
                            </tr>
                            <tr>
                                <td>ALARM-002</td>
                                <td>Resolved</td>
                                <td>9:00 AM</td>
                                <td>Back Door</td>
                                <td>Fire</td>
                            </tr>
                        </tbody>
                    </table>


                    </div>
                    <div class="chart">
                        <h3>Incident Trends</h3>
                        <canvas id="incidentTrendsCanvas"></canvas>
                    </div>
                    <div class="chart">
                        <h3>Visitor Flow</h3>
                        <canvas id="visitorFlowCanvas"></canvas>
                    </div>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="section">
                <h3 class="too">Analytics and Reports</h3>
                <div class="grid">
                    <div class="chart">
                        <h3>Maintenance Requests</h3>
                        <canvas id="maintenanceRequestsCanvas"></canvas>
                    </div>
                    <div class="chart">
                        <h3>Incident Response Time</h3>
                        <canvas id="responseTimeCanvas"></canvas>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

function toggleTable(tableId) {
            const table = document.getElementById(tableId + 'Table');
            const button = document.querySelector('button[action="' + tableId + '"]');

            if (table.style.display === 'none') {
                table.style.display = 'table';
                button.classList.add('active');
            } else {
                table.style.display = 'none';
                button.classList.remove('active');
            }
        }



        // Live Camera Feeds Chart (Line Chart example)
        new Chart(document.getElementById('cameraFeedsCanvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['1 AM', '2 AM', '3 AM', '4 AM', '5 AM'],
                datasets: [{
                    label: 'Live Feeds Viewers',
                    data: [5, 8, 3, 6, 9],
                    borderColor: '#ff6347',  // Tomato color for the line
                    fill: false,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2
                }]
            }
        });

        // Recent Access Logs Chart (Bar Chart example)
        new Chart(document.getElementById('accessLogsCanvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Access Logs (Visitors)',
                    data: [10, 20, 30, 40, 25, 35, 50],
                    backgroundColor: '#2ecc71',  // Green for visitors
                    borderColor: '#27ae60',
                    borderWidth: 1
                }]
            }
        });

        // Alarm Status Chart (Pie Chart example)
        new Chart(document.getElementById('alarmStatusCanvas').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Triggered', 'Resolved', 'Pending'],
                datasets: [{
                    data: [3, 5, 2],  // Example data for different alarm statuses
                    backgroundColor: ['#e74c3c', '#3498db', '#f39c12']
                }]
            }
        });

        // Incident Trends Chart (Doughnut Chart example)
        new Chart(document.getElementById('incidentTrendsCanvas').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Theft', 'Fire', 'Access Violation'],
                datasets: [{
                    data: [10, 15, 5],
                    backgroundColor: ['#e74c3c', '#f39c12', '#3498db']
                }]
            }
        });

        // Visitor Flow Chart (Line Chart example)
        new Chart(document.getElementById('visitorFlowCanvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Visitors',
                    data: [12, 20, 30, 25, 35, 50, 40],
                    borderColor: '#2ecc71',
                    fill: true,
                    backgroundColor: 'rgba(46, 204, 113, 0.2)'
                }]
            }
        });

        // Maintenance Requests Chart
        new Chart(document.getElementById('maintenanceRequestsCanvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Requests',
                    data: [10, 12, 8, 15, 20],
                    backgroundColor: '#e67e22'
                }]
            }
        });

        // Incident Response Time Chart
        new Chart(document.getElementById('responseTimeCanvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Incident 1', 'Incident 2', 'Incident 3', 'Incident 4', 'Incident 5'],
                datasets: [{
                    label: 'Response Time (minutes)',
                    data: [10, 15, 12, 18, 20],
                    backgroundColor: '#3498db'
                }]
            }
        });
    </script>
</body>

</html>
