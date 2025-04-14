<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payment/checkout.css">
    <title>Checkout | <?php echo SITENAME; ?></title>
    <script src="https://js.braintreegateway.com/web/dropin/1.33.7/js/dropin.min.js"></script>
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
                <h1>Complete Your Payment</h1>
                <a href="<?php echo URLROOT; ?>/payments" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>

            <div class="checkout-container">
                <div class="payment-summary">
                    <h2>Payment Summary</h2>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span class="label">Payment Type:</span>
                            <span class="value"><?php echo ucfirst($data['payment']->payment_type); ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Description:</span>
                            <span class="value"><?php echo $data['payment']->description; ?></span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Amount:</span>
                            <span class="value amount">Rs. <?php echo number_format($data['amount'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <div class="payment-form-container">
                    <h2>Payment Method</h2>
                    <div id="dropin-container"></div>
                    <form id="payment-form" action="<?php echo URLROOT; ?>/payments/process" method="POST">
                        <input type="hidden" id="nonce" name="payment_method_nonce">
                        <input type="hidden" name="amount" value="<?php echo $data['amount']; ?>">
                        <input type="hidden" name="transaction_id" value="<?php echo $data['transaction_id']; ?>">
                        <button id="submit-button" class="btn btn-primary" type="submit" disabled>Pay Now</button>
                    </form>
                    <div class="payment-security">
                        <p><i class="fas fa-lock"></i> Your payment information is secure. We use industry-standard encryption to protect your data.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('payment-form');
            var client_token = "<?php echo $data['client_token']; ?>";
            
            braintree.dropin.create({
                authorization: client_token,
                container: '#dropin-container',
                paypal: {
                    flow: 'vault'
                }
            }, function (createErr, instance) {
                if (createErr) {
                    console.error(createErr);
                    return;
                }
                
                // Enable the submit button
                document.getElementById('submit-button').disabled = false;
                
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    
                    // Show loading state
                    document.getElementById('submit-button').textContent = 'Processing...';
                    document.getElementById('submit-button').disabled = true;
                    
                    instance.requestPaymentMethod(function (err, payload) {
                        if (err) {
                            console.error(err);
                            document.getElementById('submit-button').textContent = 'Pay Now';
                            document.getElementById('submit-button').disabled = false;
                            return;
                        }
                        
                        // Set the payment method nonce
                        document.getElementById('nonce').value = payload.nonce;
                        
                        // Submit the form
                        form.submit();
                    });
                });
            });
        });
    </script>
</body>
</html>
