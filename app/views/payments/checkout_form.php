<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/checkout.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Make a Payment | <?php echo SITENAME; ?></title>
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
                <a href="<?php echo URLROOT; ?>/payments" class="back-button">
                    <i class="fas fa-arrow-left"></i> &nbsp; Back to Payments
                </a>
            </div>

            <h1>Make a Payment</h1>

            <?php if(isset($data['error'])) : ?>
                <div class="alert alert-danger">
                    <?php echo $data['error']; ?>
                </div>
            <?php endif; ?>

            <section class="checkout-form-container">
                <form action="<?php echo URLROOT; ?>/payments/checkout" method="POST" class="checkout-form">
                    <div class="form-group">
                        <label for="amount">Amount ($):</label>
                        <input type="number" step="0.01" min="0.01" id="amount" name="amount" value="<?php echo $data['amount']; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['amount_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Payment Description:</label>
                        <textarea id="description" name="description" rows="4" required><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                    </div>

                    <button type="submit" class="btn-submit">Proceed to Payment</button>
                </form>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>