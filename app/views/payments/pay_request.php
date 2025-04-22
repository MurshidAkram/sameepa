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
    <title>Pay Request #<?php echo $data['request']->id; ?> | <?php echo SITENAME; ?></title>
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
                <h1>Pay Request #<?php echo $data['request']->id; ?></h1>
                <div class="header-actions">
                    <a href="<?php echo URLROOT; ?>/payments/requests" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Requests
                    </a>
                </div>
            </div>
            
            <?php flash('payment_error'); ?>
            
            <div class="payment-details">
                <h4>Payment Details</h4>
                <table>
                    <tr>
                        <th>Amount:</th>
                        <td>$<?php echo number_format($data['request']->amount, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td><?php echo $data['request']->description; ?></td>
                    </tr>
                    <tr>
                        <th>Due Date:</th>
                        <td><?php echo date('M d, Y', strtotime($data['request']->due_date)); ?></td>
                    </tr>
                </table>
            </div>

            <form id="payment-form">
                <div id="payment-element">
                    <!-- Stripe Elements will be inserted here -->
                </div>
                <div id="payment-message" class="alert d-none"></div>
                <button id="submit" class="btn-submit">
                    <i class="fas fa-credit-card"></i> Pay $<?php echo number_format($data['request']->amount, 2); ?>
                </button>
            </form>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('<?php echo STRIPE_PUBLIC_KEY; ?>');
        const elements = stripe.elements();
        
        const style = {
            base: {
                color: "#32325d",
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "#aab7c4"
                }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        };

        const paymentElement = elements.create("payment", {style: style});
        paymentElement.mount("#payment-element");

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit');
        const paymentMessage = document.getElementById('payment-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            submitButton.disabled = true;
            paymentMessage.classList.add('d-none');
            
            try {
                const {error} = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: '<?php echo URLROOT; ?>/payments/request_success/<?php echo $data['request']->id; ?>',
                    },
                });

                if (error) {
                    paymentMessage.textContent = error.message;
                    paymentMessage.classList.remove('d-none', 'alert-success');
                    paymentMessage.classList.add('alert-danger');
                    submitButton.disabled = false;
                }
            } catch (error) {
                paymentMessage.textContent = 'An unexpected error occurred.';
                paymentMessage.classList.remove('d-none', 'alert-success');
                paymentMessage.classList.add('alert-danger');
                submitButton.disabled = false;
            }
        });
    </script>
</body>
</html> 