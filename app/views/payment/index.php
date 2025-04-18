<?php require APPROOT . '/views/inc/components/header.php'; ?>
<?php require APPROOT . '/views/inc/components/navbar.php'; ?>

<div class="dashboard-container">
    <?php
    switch ($_SESSION['user_role_id']) {
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

    <main class="payments-main">
        <h1>Payment History</h1>
        
        <?php flash('payment_success'); ?>
        <?php flash('payment_error'); ?>
        
        <div class="payment-actions">
            <a href="<?php echo URLROOT; ?>/payments/checkout" class="btn-create">
                <i class="fas fa-plus"></i> Make New Payment
            </a>
        </div>
        
        <div class="payments-table-container">
            <?php if (!empty($data['payments'])) : ?>
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Transaction ID</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    <tbody>
                        <?php foreach ($data['payments'] as $payment) : ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($payment->created_at)); ?></td>
                                <td><?php echo $payment->description; ?></td>
                                <td>$<?php echo number_format($payment->amount, 2); ?></td>
                                <td><?php echo $payment->transaction_id; ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower($payment->status); ?>">
                                        <?php echo ucfirst($payment->status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="no-records">
                    <p>No payment records found.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/inc/components/footer.php'; ?>
