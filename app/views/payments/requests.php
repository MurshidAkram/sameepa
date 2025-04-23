<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/requests.css">
    <title>Payment Requests | <?php echo SITENAME; ?></title>
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
        <main class="requests-main">
            <div class="page-header">
                <h1>Payment Requests</h1>
                <div class="header-actions">
                    <?php if ($_SESSION['user_role_id'] == 2): ?>
                        <a href="<?php echo URLROOT; ?>/payments/create_request" class="btn-create">
                            <i class="fas fa-plus"></i> Create New Request
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (empty($data['requests'])): ?>
                <p class="no-data">No payment requests found.</p>
            <?php else: ?>
                <div class="requests-table-container">
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <?php if ($_SESSION['user_role_id'] == 2): ?>
                                    <th>Address</th>
                                <?php endif; ?>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['requests'] as $request): ?>
                                <tr>
                                    <td><?php echo $request->id; ?></td>
                                    <?php if ($_SESSION['user_role_id'] == 2): ?>
                                        <td><?php echo $request->address; ?></td>
                                    <?php endif; ?>
                                    <td>Rs.<?php echo number_format($request->amount, 2); ?></td>
                                    <td><?php echo $request->description; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($request->due_date)); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $request->status == 'paid' ? 'success' : 'warning'; ?>">
                                            <?php echo ucfirst($request->status); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $request->created_by_name; ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($request->created_at)); ?></td>
                                    <td class="action-buttons">
                                        <?php if ($_SESSION['user_role_id'] == 1 && $request->status == 'pending'): ?>
                                            <a href="<?php echo URLROOT; ?>/payments/pay_request/<?php echo $request->id; ?>" class="btn-pay">
                                                <i class="fas fa-credit-card"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['user_role_id'] == 2 && $request->status == 'pending'): ?>
                                            <form action="<?php echo URLROOT; ?>/payments/delete_request/<?php echo $request->id; ?>" method="post" class="delete-form">
                                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this payment request?');">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="flash-messages">
                <?php flash('payment_request_message'); ?>
                <?php flash('payment_success'); ?>
                <?php flash('payment_error'); ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html> 