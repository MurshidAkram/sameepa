
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/complaints.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Complaints | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main>
            <div class="header-container">
                <h1>Complaints Dashboard</h1>
                <a href="#" class="btn-history">View Complaints History</a>
            </div>
              <div class="stats-container">
                    <div class="total-complaints">
                      <h2>Total Complaints</h2> 
                      <p class="count">150</p>
                    </div>
                    <div class="pending-complaints-container">
                        <h2>Pending Complaints</h2>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Complaint Title</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Noise Complaint</td>
                                        <td>2023-05-15</td>
                                        <td><a href="#">View</a></td>
                                    </tr>
                                    <tr>
                                        <td>Maintenance Issue</td>
                                        <td>2023-05-14</td>
                                        <td><a href="#">View</a></td>
                                    </tr>
                                    <tr>
                                        <td>Parking Violation</td>
                                        <td>2023-05-13</td>
                                        <td><a href="#">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                    
                    </div>   
                    <div class="chart-container">
                      <h2>Complaint Status</h2>
                      <div class="pie-chart-container">
                          <canvas id="complaintsChart"></canvas>
                      </div>
                    </div>
                    
              </div>

              <div class="bar-chart-container">
                  <canvas id="monthlyComplaintsChart"></canvas>
              </div>

              
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Pie Chart
        const ctx = document.getElementById('complaintsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Solved', 'Pending', 'Unresolved'],
                datasets: [{
                    data: [65, 20, 15],
                    backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart
        const barCtx = document.getElementById('monthlyComplaintsChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Number of Complaints',
                    data: [12, 19, 3, 5, 2, 3, 8, 14, 7, 10, 6, 9],
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
