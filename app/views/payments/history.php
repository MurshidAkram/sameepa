<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/history.css">
    <title>Payment History | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>
        <main class="history-main">
            <div class="page-header">
                <h1>Payment History</h1>
                <a href="<?php echo URLROOT; ?>/payments/requests" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Requests
                </a>
            </div>

            <?php flash('payment_success'); ?>
            <?php flash('payment_error'); ?>

            <div class="filter-search-container">
                <div class="search-container">
                    <input type="search" id="searchPayment" placeholder="Search payment history..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="history-table-container">
                <?php if (!empty($data['payments'])) : ?>
                    <table class="history-table">
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
                            <?php foreach ($data['payments'] as $payment) : ?>
                                <tr>
                                    <td><?php echo $payment->id; ?></td>
                                    <td><?php echo $payment->address; ?></td>
                                    <td>Rs.<?php echo number_format($payment->amount, 2); ?></td>
                                    <td><?php echo $payment->description; ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($payment->paid_at)); ?></td>
                                    <td><?php echo $payment->created_by_name; ?></td>
                                    <td class="action-buttons">
                                        <a href="<?php echo URLROOT; ?>/payments/viewPayment/<?php echo $payment->id; ?>" class="btn-viewp" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo $payment->id; ?>" class="btn-receipt" title="Generate Receipt">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="no-records">
                        <p>No payment history found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        // Search functionality
        document.getElementById('searchPayment').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.history-table tbody tr');
            
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