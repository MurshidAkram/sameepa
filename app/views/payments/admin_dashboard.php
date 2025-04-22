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
                        <h3><i class="fas fa-money-bill-wave"></i> Payments This Month</h3>
                        <p><?php echo isset($data['payments_this_month']) ? $data['payments_this_month'] : 0; ?></p>
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
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Address</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data['payments']) && !empty($data['payments'])): ?>
                            <?php foreach($data['payments'] as $payment): ?>
                            <tr>
                                <td><?php echo substr($payment->transaction_id, 0, 10) . '...'; ?></td>
                                <td><?php echo $payment->user_name ?? 'Unknown'; ?></td>
                                <td><?php echo $payment->home_address; ?></td>
                                <td>Rs.<?php echo number_format($payment->amount, 2); ?></td>
                                <td><?php echo substr($payment->description, 0, 30) . (strlen($payment->description) > 30 ? '...' : ''); ?></td>
                                <td><?php echo date('M d, Y', strtotime($payment->created_at)); ?></td>
                                <td class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/payments/viewPayment/<?php echo $payment->id; ?>" class="btn-view-p">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo $payment->id; ?>" class="btn-receipt">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                    <form action="<?php echo URLROOT; ?>/payments/delete/<?php echo $payment->id; ?>" method="POST" style="display: inline;">
                                        <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this payment record? This action cannot be undone.')" title="Delete Payment">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="no-data">No payment records found</td>
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
                maintainAspectRatio: false, // This allows the chart to use the container's height
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