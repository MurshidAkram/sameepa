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

<style> /* dashboard.css */

/* Dashboard Layout */
.dashboard-container {
    display: flex;
    background-color: #f0f4f8;
    padding: 20px;
}

.side-panel {
    flex-basis: 20%;
}

.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Header Styling */
.dashboard-header {
    animation: fadeIn 1s ease-out;
}

.dashboard-header h1 {
    color: #333;
}

.dashboard-header p {
    color: #555;
    animation: fadeIn 2s ease-out;
}

/* Card and Chart Layout */
.overview-cards {
    display: flex;
    flex-direction: row;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.card-container {
    display: flex;
    gap: 10px;
    flex: 1;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    color: #333;
    transition: transform 0.3s ease;
    width: 100%;
    animation: fadeIn 1s ease-out;
}

.card:hover {
    transform: scale(1.05);
}

.card h3 {
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    background-color: #3498db;
}

.chart-container {
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.chart {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    color: #333;
    flex: 1;
    animation: fadeIn 1s ease-out;
}

.chart h3 {
    font-size: 1.1em;
}

#visitorFlowCanvas,
#incidentTrendsCanvas,
#shiftCoverageCanvas {
    width: 100%;
    height: 250px;
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

</style>

<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

<div class="dashboard-container">
    <?php require APPROOT . '/views/inc/components/side_panel_security.php'; ?>
    
    <div class="main-content">
        <!-- Dashboard Header -->
        <section class="dashboard-header">
            <h1>Security Management</h1>
            <p>Manage security operations including visitor passes, incident reports, duty schedules, and visitor log times.</p>
        </section>

        <hr>

        <!-- Overview Cards Section -->
        <section class="overview-cards">
            <div class="card-container">
                <div class="card" style="background-color: #1abc9c;">
                    <h3>Active Visitor Passes</h3>
                    <p>Current On-Site: <span id="active-visitors">5</span></p>
                </div>
                <div class="card" style="background-color: #f39c12;">
                    <h3>Upcoming Duty Shifts</h3>
                    <p>Next Shift: <span id="upcoming-shift">14:00</span><br>Officer: <span id="upcoming-officer">Officer Smith</span></p>
                </div>
                <div class="card" style="background-color: #e74c3c;">
                    <h3>Open Incident Reports</h3>
                    <p>Unresolved: <span id="open-incidents">8</span></p>
                </div>
                <div class="card" style="background-color: #9b59b6;">
                    <h3>Quick Emergency Contacts</h3>
                    <p>Main: <span id="emergency-contact">911</span></p>
                </div>
            </div>
        </section>

        <hr>

        <!-- Charts and Graphs Section -->
        <section class="charts-graphs">
            <h2>Analytics</h2>
            <div class="chart-container">
                <div class="chart">
                    <h3>Visitor Flow</h3>
                    <p>Entries Over Time</p>
                    <canvas id="visitorFlowCanvas"></canvas>
                </div>
                
                <div class="chart">
                    <h3>Incident Trends</h3>
                    <p>Types Breakdown (e.g., theft, fire)</p>
                    <canvas id="incidentTrendsCanvas"></canvas>
                </div>
                
                <div class="chart">
                    <h3>Shift Coverage</h3>
                    <p>Attendance Rate</p>
                    <canvas id="shiftCoverageCanvas"></canvas>
                </div>
            </div>
        </section>

    </div>
</div>

<?php require APPROOT . '/views/inc/components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const visitorFlowCtx = document.getElementById('visitorFlowCanvas').getContext('2d');
    const incidentTrendsCtx = document.getElementById('incidentTrendsCanvas').getContext('2d');
    const shiftCoverageCtx = document.getElementById('shiftCoverageCanvas').getContext('2d');

    new Chart(visitorFlowCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitor Entries',
                data: [10, 20, 15, 30, 25, 35, 40],
                borderColor: '#4CAF50',
                fill: false
            }]
        }
    });

    new Chart(incidentTrendsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Theft', 'Fire', 'Accident', 'Other'],
            datasets: [{
                label: 'Incidents',
                data: [5, 2, 3, 7],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FF9F40']
            }]
        }
    });

    new Chart(shiftCoverageCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Coverage Rate',
                data: [85, 90, 75, 80],
                backgroundColor: '#4CAF50'
            }]
        }
    });
</script>

</body>
</html>
