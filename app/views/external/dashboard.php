<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>External Provider Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <section class="dashboard-overview">
                <h1>Welcome to External Service Provider Dashboard</h1>
                <p>Manage your service requests, track payments, and view insights on your performance.</p>

                <!-- Profile Information Card (Full-width Row) -->
                <div class="profile-card card">
                    <h2>My Profile</h2>
                    <div class="profile-content">
                        
                        <!-- Profile Details -->
                        <div class="profile-details">
                            <ul>
                                <li><strong>Name:</strong> John Doe</li>
                                <li><strong>Service Type:</strong> Plumbing</li>
                                <li><strong>Contact:</strong> johndoe@example.com</li>
                                <li><a href="<?php echo URLROOT; ?>/external/profile" class="dashboard-link">Update Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Other Dashboard Cards in Grid Layout -->
                <div class="dashboard-grid">
                    <!-- Service Requests Card -->
                    <div class="card requests-card">
                        <h2>Service Requests</h2>
                        <table class="requests-table">
                            <tr>
                                <th>Request ID</th>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                            <tr>
                                <td>SR001</td>
                                <td>Plumbing</td>
                                <td class="status-pending">Pending</td>
                            </tr>
                            <tr>
                                <td>SR002</td>
                                <td>Electrical</td>
                                <td class="status-completed">Completed</td>
                            </tr>
                            <tr>
                                <td>SR003</td>
                                <td>Carpentry</td>
                                <td class="status-in-progress">In Progress</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Payment Overview Card -->
                    <div class="card payment-card">
                        <h2>Monthly Payments</h2>
                        <canvas id="paymentChart"></canvas>
                    </div>

                    <!-- Service Analytics Card -->
                    <div class="card analytics-card">
                        <h2>Service Analytics</h2>
                        <canvas id="serviceAnalyticsChart"></canvas>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Payment Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Unpaid'],
                datasets: [{
                    data: [120, 30],
                    backgroundColor: ['#800080', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed;
                            }
                        }
                    }
                }
            }
        });

        // Service Analytics Chart
        const analyticsCtx = document.getElementById('serviceAnalyticsChart').getContext('2d');
        new Chart(analyticsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Completed Services',
                    data: [8, 6, 5, 9, 7, 10, 6],
                    backgroundColor: '#6a006a'
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



