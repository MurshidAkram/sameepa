<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/pay_request.css">
    <title>Payment Request Details | <?php echo SITENAME; ?></title>
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
        <main class="pay-request-main">
            <div class="page-header">
                <h1>Payment Request Details</h1>
                <a href="<?php echo URLROOT; ?>/payments/requests" class="btn-back">
                    <i class="fas fa-arrow-left"></i> &nbsp; Back to Requests
                </a>
            </div>

            <div class="payment-details">
                <h2>Request Information</h2>
                <div class="payment-info">
                    <div class="info-row">
                        <span class="label">Request ID:</span>
                        <span class="value"><?php echo $data['request']->id; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Amount:</span>
                        <span class="value">LKR <?php echo number_format(is_array($data['request']) ? $data['request']['amount'] : $data['request']->amount, 2); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Description:</span>
                        <span class="value"><?php echo is_array($data['request']) ? $data['request']['description'] : $data['request']->description; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Due Date:</span>
                        <span class="value"><?php echo date('Y-m-d', strtotime(is_array($data['request']) ? $data['request']['due_date'] : $data['request']->due_date)); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Status:</span>
                        <span class="value badge <?php echo (is_array($data['request']) ? $data['request']['status'] : $data['request']->status) === 'paid' ? 'badge-success' : 'badge-warning'; ?>">
                            <?php echo ucfirst(is_array($data['request']) ? $data['request']['status'] : $data['request']->status); ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Created By:</span>
                        <span class="value"><?php echo $data['request']->created_by_name; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Created At:</span>
                        <span class="value"><?php echo date('M d, Y H:i', strtotime($data['request']->created_at)); ?></span>
                    </div>
                </div>

                <div class="payment-actions">
                    <a href="<?php echo URLROOT; ?>/payments/checkout/<?php echo $data['request']->id; ?>" class="btn-proceed">
                        Proceed to Payment
                    </a>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html> 