
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payment/payment.css">
    <title>Payments | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
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

        <main class="payment-main">
            <div class="page-header">
                <h1>Payments</h1>
                <a href="<?php echo URLROOT; ?>/payments/create" class="btn-create">
                    <i class="fas fa-plus"></i> Make a Payment
                </a>
            </div>

            <?php flash('payment_message'); ?>

            <div class="payment-info-card">
                <h2>Payment Information</h2>
                <p>Make payments for maintenance fees, utility bills, event fees, and other community-related expenses.</p>
                <p>All payments are processed securely through PayHere.</p>
                
                <div class="payment-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h3>Create Payment</h3>
                            <p>Fill out the payment form with your details and payment amount.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h3>Secure Checkout</h3>
                            <p>You'll be redirected to PayHere's secure payment gateway.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h3>Confirmation</h3>
                            <p>Receive confirmation once your payment is processed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-methods">
                <h2>Accepted Payment Methods</h2>
                <div class="method-icons">
                    <div class="method-icon">
                        <img src="<?php echo URLROOT; ?>/img/visa.png" alt="Visa">
                    </div>
                    <div class="method-icon">
                        <img src="<?php echo URLROOT; ?>/img/mastercard.png" alt="Mastercard">
                    </div>
                    <div class="method-icon">
                        <img src="<?php echo URLROOT; ?>/img/amex.png" alt="American Express">
                    </div>
                    <div class="method-icon">
                        <img src="<?php echo URLROOT; ?>/img/payhere.png" alt="PayHere">
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
