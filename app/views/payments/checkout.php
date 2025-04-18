<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/checkout.css">
    <title>Complete Payment | <?php echo SITENAME; ?></title>
</head>

<body>
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

        <main class="checkout-main">
            <div class="top-page">
                <a href="<?php echo URLROOT; ?>/payments/checkout" class="back-button">
                    <i class="fas fa-arrow-left"></i> &nbsp; Back to Payment Form
                </a>
            </div>

            <h1>Complete Your Payment</h1>

            <section class="checkout-container">
                <div class="payment-summary">
                    <h2>Payment Summary</h2>
                    <div class="summary-item">
                        <span>Description:</span>
                        <span><?php echo $data['description']; ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Amount:</span>
                        <span>$<?php echo number_format($data['amount'], 2); ?></span>
                    </div>
                </div>

                <div class="payment-form">
                    <form id="payment-form">
                        <div id="payment-element">
                            <!-- Stripe Elements will be inserted here -->
                        </div>
                        <button id="submit-button">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay Now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
        const clientSecret = '<?php echo $data['client_secret']; ?>';
        
        const appearance = {
            theme: 'stripe',
            variables: {
                colorPrimary: '#0a2540',
            },
        };
        
        const elements = stripe.elements({
            clientSecret,
            appearance,
        });
        
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        const paymentMessage = document.getElementById('payment-message');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Disable the submit button to prevent repeated clicks
            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            buttonText.classList.add('hidden');
            
            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '<?php echo URLROOT; ?>/payments/success',
                },
            });
            
            if (error) {
                // Show error to your customer
                showMessage(error.message);
                
                // Re-enable the submit button
                submitButton.disabled = false;
                spinner.classList.add('hidden');
                buttonText.classList.remove('hidden');
            }
        });
        
        function showMessage(messageText) {
            paymentMessage.classList.remove('hidden');
            paymentMessage.textContent = messageText;
            
            setTimeout(function () {
                paymentMessage.classList.add('hidden');
                paymentMessage.textContent = "";
            }, 4000);
        }
    </script>
</body>

</html>