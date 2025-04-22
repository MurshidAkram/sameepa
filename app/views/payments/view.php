<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/view.css">
    <title>View Payment | <?php echo SITENAME; ?></title>
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
        <main class="payment-view-main">
            <div class="view-header">
                <h1>Payment Details</h1>
                <div class="actions">
                    <a href="<?php echo URLROOT; ?>/payments/<?php echo ($_SESSION['user_role_id'] == 1) ? 'index' : 'admin_dashboard'; ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                    <a href="<?php echo URLROOT; ?>/payments/receipt/<?php echo is_array($data['payment']) ? $data['payment']['id'] : $data['payment']->id; ?>" class="btn-receipt">
                        <i class="fas fa-file-invoice"></i> Generate Receipt
                    </a>
                </div>
            </div>

            <div class="payment-details-card">
                <div class="payment-header">
                    <div class="payment-id">
                        <h2>Transaction ID</h2>
                        <p><?php echo is_array($data['payment']) ? $data['payment']['transaction_id'] : $data['payment']->transaction_id; ?></p>
                    </div>
                </div>

                <div class="payment-info-grid">
                    <div class="info-group">
                        <h3>Amount</h3>
                        <p>Rs.<?php echo number_format(is_array($data['payment']) ? $data['payment']['amount'] : $data['payment']->amount, 2); ?></p>
                    </div>
                    <div class="info-group">
                        <h3>Date</h3>
                        <p><?php echo date('F d, Y h:i A', strtotime(is_array($data['payment']) ? $data['payment']['created_at'] : $data['payment']->created_at)); ?></p>
                    </div>
                    <div class="info-group">
                        <h3>Description</h3>
                        <p><?php echo is_array($data['payment']) ? $data['payment']['description'] : $data['payment']->description; ?></p>
                    </div>
                    <div class="info-group">
                        <h3>Home Address</h3>
                        <p><?php echo is_array($data['payment']) ? $data['payment']['home_address'] : $data['payment']->home_address; ?></p>
                    </div>
                </div>

                <div class="user-details">
                    <h2>User Information</h2>
                    <?php if(isset($data['user']) && $data['user']): ?>
                        <div class="user-info-grid">
                            <div class="info-group">
                                <h3>Name</h3>
                                <p><?php echo is_array($data['user']) ? $data['user']['name'] : $data['user']->name; ?></p>
                            </div>
                            <div class="info-group">
                                <h3>Email</h3>
                                <p><?php echo is_array($data['user']) ? $data['user']['email'] : $data['user']->email; ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="no-data">User information not available</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
