<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/all.css">
    <title>All Payments | <?php echo SITENAME; ?></title>
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
        <main class="all-payments-main">
            <div class="page-header">
                <h1>All Payment Records</h1>
                <div class="header-actions">
                    <a href="<?php echo URLROOT; ?>/payments/admin_dashboard" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="<?php echo URLROOT; ?>/payments/export" class="btn-export">
                        <i class="fas fa-file-export"></i> Export Data
                    </a>
                </div>
            </div>

            <div class="filter-search-container">
                <div class="search-container">
                    <input type="search" id="searchPayment" placeholder="Search payments..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="payments-table-container">
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
                                    <a href="<?php echo URLROOT; ?>/payments/viewPayment/<?php echo $payment->id; ?>" class="btn-view-p" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo $payment->id; ?>" class="btn-receipt" title="Generate Receipt">
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
    <script>
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
