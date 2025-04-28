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
    background: #ffffff;
    color: #333;
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
    font-size: 1.8rem;
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
    background: #ffffff;
    color: #000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
    min-height: 300px;
}

.chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.chart-card h4 {
    margin: 0 0 15px;
    font-size: 1.3rem;
    color: #800080;
    text-align: center;
}

/* Status Card Colors */
.card.status-1 { border-top: 4px solid #FFC107; } /* Pending */
.card.status-2 { border-top: 4px solid #2196F3; } /* In Progress */
.card.status-3 { border-top: 4px solid #F44336; } /* On Hold */
.card.status-4 { border-top: 4px solid #4CAF50; } /* Completed */
.card.status-5 { border-top: 4px solid #9C27B0; } /* Cancelled */

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
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_maintenance.php'; ?>

        <main>
            <!-- Dashboard Header -->
            <header class="dashboard-header">
               

                <div class="dashboard-controls">
                  
                </div>
            </header>

            <h1>Maintenance Dashboard</h1>
           
            <!-- Status Summary Cards -->
            <h2>Request Status Overview</h2>
            <section class="overview-cards">
                <?php foreach ($data['statusCounts'] as $status): ?>
                <div class="card status-<?php echo $status->status_id; ?>">
                    <h3><?php echo $status->status_name; ?></h3>
                    <p><?php echo $status->count; ?></p>
                </div>
                <?php endforeach; ?>
            </section>

            <!-- Request Type Charts -->
            <section class="charts-section">
                <div class="chart-card">
                    <h4>All Requests by Type</h4>
                    <canvas id="request-type-chart"></canvas>
                </div>
                
                <div class="chart-card">
                    <h4>Completed Requests by Type</h4>
                    <canvas id="completed-requests-chart"></canvas>
                </div>
            </section>

        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      
        const requestTypeCtx = document.getElementById('request-type-chart').getContext('2d');
        new Chart(requestTypeCtx, {
            type: 'pie',
            data: {
                labels: [
                    <?php 
                    foreach ($data['requestTypeData'] as $type) {
                        echo "'" . $type->type_name . "', ";
                    }
                    ?>
                ],
                datasets: [{
                    data: [
                        <?php 
                        foreach ($data['requestTypeData'] as $type) {
                            echo $type->count . ", ";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        '#8A2BE2', '#7B68EE', '#6A5ACD', '#9370DB', '#800080', 
                        '#4B0082', '#663399', '#483D8B', '#9400D3', '#6B3FA0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Distribution of All Maintenance Requests'
                    }
                }
            }
        });

      
        const completedRequestCtx = document.getElementById('completed-requests-chart').getContext('2d');
        new Chart(completedRequestCtx, {
            type: 'pie',
            data: {
                labels: [
                    <?php 
                    foreach ($data['completedRequestData'] as $type) {
                        echo "'" . $type->type_name . "', ";
                    }
                    ?>
                ],
                datasets: [{
                    data: [
                        <?php 
                        foreach ($data['completedRequestData'] as $type) {
                            echo $type->count . ", ";
                        }
                        ?>
                    ],
                    backgroundColor: [
                        '#8A2BE2', '#7B68EE', '#6A5ACD', '#9370DB', '#800080', 
                        '#4B0082', '#663399', '#483D8B', '#9400D3', '#6B3FA0'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Distribution of Completed Maintenance Requests'
                    }
                }
            }
        });
    </script>
</body>

</html>