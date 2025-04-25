<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/admin_dashboard.css">
    <title>Payment Management | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
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
        <main class="admin-payments-main">
            <div class="admin-header">
                <h1>Payment Management Dashboard</h1>
            </div>
            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/payments/all" class="btn-view-all">
                    <i class="fas fa-list"></i> View All Payments
                </a>
                <a href="<?php echo URLROOT; ?>/payments/requests" class="btn-view-requests">
                        <i class="fas fa-list"></i> View Payment Requests
                    </a>
            </div>
            <div class="payments-stats">
                <div class="stat-card">                  
                    <div class="stat-info">
                        <h3><i class="fas fa-calendar-day"></i> Most Active Day</h3>
                        <p><?php echo isset($data['most_active_day']) ? $data['most_active_day'] : 'N/A'; ?></p>
                    </div>
                </div>
                <div class="stat-card">                   
                    <div class="stat-info">
                        <h3><i class="fas fa-money-bill-wave"></i> Requests This Month</h3>
                        <p><?php echo isset($data['requests_this_month']) ? $data['requests_this_month'] : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-dollar-sign"></i> Total This Month</h3>
                        <p>Rs.<?php echo isset($data['total_amount_this_month']) ? number_format($data['total_amount_this_month'], 2) : '0.00'; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-bolt"></i> Recent Activity</h3>
                        <p><?php echo isset($data['recent_activity']) ? $data['recent_activity'] : 0; ?></p>
                    </div>
                </div>
            </div>
            <div class="single-chart-container">
                <div class="chart-card">
                    <h2>Monthly Payments</h2>
                    <div class="chart-container-inner">
                        <canvas id="monthlyPaymentsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="payments-table-container">
                <div class="table-header">
                    <h2>Recent Payments</h2>
                </div>

                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Paid At</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['requests']) && !empty($data['requests'])): ?>
                            <?php 
                            // Get only the first 5 records
                            $recentRequests = array_slice($data['requests'], 0, 5);
                            foreach($recentRequests as $request): ?>
                            <tr>
                                <td><?php echo $request->id; ?></td>
                                <td><?php echo $request->address; ?></td>
                                <td>Rs.<?php echo number_format($request->amount, 2); ?></td>
                                <td><?php echo substr($request->description, 0, 30) . (strlen($request->description) > 30 ? '...' : ''); ?></td>
                                <td><?php echo date('M d, Y H:i', strtotime($request->paid_at)); ?></td>
                                <td><?php echo $request->created_by_name; ?></td>
                                <td class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/payments/viewPayment/<?php echo $request->id; ?>" class="btn-view-p">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo $request->id; ?>" class="btn-receipt">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="no-data">No paid requests found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Payments Chart
        const monthlyCtx = document.getElementById('monthlyPaymentsChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Payment Amount (Rs.)',
                    data: <?php echo isset($data['monthly_data']) ? json_encode($data['monthly_data']) : '[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]'; ?>,
                    backgroundColor: '#3498db'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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