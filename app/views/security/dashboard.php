<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/security/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-container {
            display: flex;
            background-color: #f8f9fa;
            padding: 20px;
            gap: 20px;
            min-height: calc(100vh - 120px);
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
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .section h2 {
            font-size: 1.5em;
            color: #333;
            margin: 0;
        }

        .welcome-message {
            font-size: 1.2em;
            color: #555;
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
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 1.2em;
            color: #333;
            margin-top: 0;
        }

        .card p {
            font-size: 1em;
            color: #555;
            margin-bottom: 0;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .chart {
            flex: 1 1 calc(50% - 20px);
            min-width: 300px;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .chart h3 {
            margin-top: 0;
            color: #333;
            text-align: center;
        }

        .chart canvas {
            width: 100%;
            height: 250px;
        }

        .metric-value {
            font-size: 1.8em;
            font-weight: bold;
            color: #6A5ACD;
            margin: 10px 0;
        }

        .card.passes { background-color: #D2B4DE; }
        .card.personnel { background-color: #A569BD; }
        .card.emergency { background-color: #8E44AD; color: white; }
        .card.emergency h3, .card.emergency p { color: white; }
    </style>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>

        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h2>Security Dashboard</h2>
                    <div class="welcome-message">
                        Welcome, <?php echo htmlspecialchars($data['name'] ?? $data['email']); ?> (Security)
                    </div>
                </div>
                
                <!-- Key Metrics Section -->
                <div class="grid">
                    <div class="card passes">
                        <h3>Active Visitor Passes</h3>
                        <div class="metric-value" id="active-passes"><?php echo $data['activePassesCount']; ?></div>
                        <p>Passes issued today</p>
                    </div>
                    
                    <div class="card personnel">
                        <h3>Security On Duty</h3>
                        <div class="metric-value" id="on-duty"><?php echo $data['onDutyCount']; ?></div>
                        <p>Currently active</p>
                    </div>
                    
                    <div class="card emergency">
                        <h3>Recent Emergency</h3>
                        <div class="metric-value" id="recent-emergency"><?php echo $data['recentEmergency']; ?></div>
                        <p>Last reported incident</p>
                    </div>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="section">
                <h2>Security Analytics</h2>
                <div class="chart-container">
                    <div class="chart">
                        <h3>Recent Access Logs</h3>
                        <canvas id="accessLogsCanvas"></canvas>
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
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Function to initialize charts with real data
        function initializeCharts(chartData) {
            // Recent Access Logs Chart
            new Chart(document.getElementById('accessLogsCanvas').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.accessLogs.labels,
                    datasets: [{
                        label: 'Daily Visitors',
                        data: chartData.accessLogs.data,
                        backgroundColor: '#9b59b6',
                        borderColor: '#8E44AD',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Visitors'
                            }
                        }
                    }
                }
            });

            // Incident Trends Chart
            new Chart(document.getElementById('incidentTrendsCanvas').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: chartData.incidentTrends.labels,
                    datasets: [{
                        data: chartData.incidentTrends.data,
                        backgroundColor: [
                            '#8E44AD', '#9B59B6', '#A569BD', '#BB8FCE', '#D2B4DE'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });

            // Visitor Flow Chart
            new Chart(document.getElementById('visitorFlowCanvas').getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartData.visitorFlow.labels,
                    datasets: [{
                        label: 'Total Visitors',
                        data: chartData.visitorFlow.data,
                        borderColor: '#6A5ACD',
                        backgroundColor: 'rgba(138, 43, 226, 0.1)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Visitors'
                            }
                        }
                    }
                }
            });
        }

        // Load chart data via AJAX
        document.addEventListener('DOMContentLoaded', function() {
            fetch('<?php echo URLROOT; ?>/security/getChartData')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        initializeCharts(data.data);
                        
                        // Update metrics (in case data changed since page load)
                        document.getElementById('active-passes').textContent = data.activePasses;
                        document.getElementById('on-duty').textContent = data.onDuty;
                        document.getElementById('recent-emergency').textContent = data.recentEmergency;
                    } else {
                        console.error('Error loading chart data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching chart data:', error);
                });

            // Auto-refresh data every 5 minutes
            setInterval(() => {
                fetch('<?php echo URLROOT; ?>/security/getChartData')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update metrics
                            document.getElementById('active-passes').textContent = data.activePasses;
                            document.getElementById('on-duty').textContent = data.onDuty;
                            document.getElementById('recent-emergency').textContent = data.recentEmergency;
                        }
                    });
            }, 300000); // 5 minutes
        });
    </script>
</body>
</html>