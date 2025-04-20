<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/reports.css">
    <title>Payment Reports | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="reports-main">
            <div class="admin-header">
                <h1>Payment Reports</h1>
                <div class="actions">
                    <a href="<?php echo URLROOT; ?>/payments/admin_dashboard" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="reports-summary">
                <div class="summary-card">
                    <div class="summary-info">
                        <h3>Total Amount</h3>
                        <p>$<?php echo number_format($data['total_amount'], 2); ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-info">
                        <h3>Completed Payments</h3>
                        <p><?php echo $data['completed_payments']; ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-info">
                        <h3>Pending Payments</h3>
                        <p><?php echo $data['pending_payments']; ?></p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-info">
                        <h3>Failed Payments</h3>
                        <p><?php echo $data['failed_payments']; ?></p>
                    </div>
                </div>
            </div>

            <div class="reports-charts">
                <div class="chart-container">
                    <div class="chart-card">
                        <h2>Monthly Payment Trends</h2>
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-card">
                        <h2>Payments by Address</h2>
                        <canvas id="addressChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="date-range-selector">
                <h2>Custom Date Range Report</h2>
                <form action="<?php echo URLROOT; ?>/payments/custom_report" method="POST" class="date-form">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                    <button type="submit" class="btn-generate">Generate Report</button>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Trends Chart
        const monthlyCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Payment Amount ($)',
                    data: <?php echo json_encode($data['monthly_data']); ?>,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });

        // Address Chart
        const addressData = <?php echo json_encode($data['address_data']); ?>;
        const addressLabels = addressData.map(item => item.home_address);
        const addressValues = addressData.map(item => item.total);

        const addressCtx = document.getElementById('addressChart').getContext('2d');
        new Chart(addressCtx, {
            type: 'bar',
            data: {
                labels: addressLabels,
                datasets: [{
                    label: 'Total Amount ($)',
                    data: addressValues,
                    backgroundColor: [
                        '#3498db', '#2ecc71', '#9b59b6', '#e74c3c', '#f39c12',
                        '#1abc9c', '#d35400', '#34495e', '#16a085', '#c0392b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
