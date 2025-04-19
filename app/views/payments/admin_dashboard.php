
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/admin_dashboard.css">
    <title>Payment Management | <?php echo SITENAME; ?></title>
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
        <main class="admin-payments-main">
            <div class="admin-header">
                <h1>Payment Management Dashboard</h1>
                <div class="search-container">
                    <input type="search" id="searchPayment" placeholder="Search payments..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="admin-actions">
                <a href="<?php echo URLROOT; ?>/payments/reports" class="btn-view-reports">
                    <i class="fas fa-chart-bar"></i> Payment Reports
                </a>
                <a href="<?php echo URLROOT; ?>/payments/export" class="btn-export">
                    <i class="fas fa-file-export"></i> Export Data
                </a>
            </div>

            <div class="payments-stats">
                <div class="stat-card">                  
                    <div class="stat-info">
                        <h3><i class="fas fa-money-bill-wave"></i> Total Payments</h3>
                        <p><?php echo isset($data['total_payments']) ? $data['total_payments'] : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">                   
                    <div class="stat-info">
                        <h3><i class="fas fa-dollar-sign"></i> Total Amount</h3>
                        <p>$<?php echo isset($data['total_amount']) ? number_format($data['total_amount'], 2) : '0.00'; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-check-circle"></i> Completed Payments</h3>
                        <p><?php echo isset($data['completed_payments']) ? $data['completed_payments'] : 0; ?></p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3><i class="fas fa-home"></i> Unique Addresses</h3>
                        <p><?php echo isset($data['unique_addresses']) ? $data['unique_addresses'] : 0; ?></p>
                    </div>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-card">
                    <h2>Monthly Payment Trends</h2>
                    <canvas id="monthlyPaymentsChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Payment Status Distribution</h2>
                    <canvas id="paymentStatusChart"></canvas>
                </div>
            </div>

            <div class="payments-table-container">
                <div class="table-header">
                    <h2>Recent Payments</h2>
                    <div class="filter-container">
                        <span class="filter-label">Status:</span>
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
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
                            <th>Status</th>
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
                                <td>$<?php echo number_format($payment->amount, 2); ?></td>
                                <td><?php echo substr($payment->description, 0, 30) . (strlen($payment->description) > 30 ? '...' : ''); ?></td>
                                <td><?php echo date('M d, Y', strtotime($payment->created_at)); ?></td>
                                <td>
                                    <span class="status-badge <?php echo strtolower($payment->status); ?>">
                                        <?php echo ucfirst($payment->status); ?>
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <a href="<?php echo URLROOT; ?>/payments/view/<?php echo $payment->id; ?>" class="btn-view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if($payment->status !== 'completed'): ?>
                                    <a href="<?php echo URLROOT; ?>/payments/updateStatus/<?php echo $payment->id; ?>/completed" class="btn-complete" onclick="return confirm('Mark this payment as completed?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo $payment->id; ?>" class="btn-receipt">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
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

                <div class="pagination">
                    <?php if(isset($data['pagination'])): ?>
                        <?php if($data['pagination']['current_page'] > 1): ?>
                            <a href="<?php echo URLROOT; ?>/payments/admin_dashboard/<?php echo $data['pagination']['current_page'] - 1; ?>" class="page-link">« Previous</a>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $data['pagination']['total_pages']; $i++): ?>
                            <a href="<?php echo URLROOT; ?>/payments/admin_dashboard/<?php echo $i; ?>" class="page-link <?php echo $i == $data['pagination']['current_page'] ? 'active' : ''; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>
                        
                        <?php if($data['pagination']['current_page'] < $data['pagination']['total_pages']): ?>
                            <a href="<?php echo URLROOT; ?>/payments/admin_dashboard/<?php echo $data['pagination']['current_page'] + 1; ?>" class="page-link">Next »</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
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
                    label: 'Payment Amount ($)',
                    data: <?php echo isset($data['monthly_data']) ? json_encode($data['monthly_data']) : '[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]'; ?>,
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

        // Payment Status Chart
        const statusCtx = document.getElementById('paymentStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Failed'],
                datasets: [{
                    data: <?php echo isset($data['status_data']) ? json_encode($data['status_data']) : '[0, 0, 0]'; ?>,
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

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('.payments-table tbody tr');
            
            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(7) .status-badge');
                if (!statusCell) return;
                
                if (status === 'all' || statusCell.textContent.trim().toLowerCase() === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Search functionality
        document.getElementById('searchPayment').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.payments-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
