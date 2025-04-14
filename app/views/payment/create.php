<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payment/create.css">
    <title>Make Payment | <?php echo SITENAME; ?></title>
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
                <h1>Make a Payment</h1>
                <a href="<?php echo URLROOT; ?>/payments/index" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Payments
                </a>
            </div>

            <div class="create-payment-container">
                <form action="<?php echo URLROOT; ?>/payments/create" method="POST" class="payment-form">
                    <?php if (!empty($data['errors'])) : ?>
                        <div class="alert alert-danger">
                            <?php foreach ($data['errors'] as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="address">Residence Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo $data['address']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_type">Payment Type:</label>
                        <select id="payment_type" name="payment_type" required>
                            <option value="" disabled selected>Select payment type</option>
                            <?php foreach ($data['payment_types'] as $value => $label) : ?>
                                <option value="<?php echo $value; ?>" <?php echo ($data['payment_type'] == $value) ? 'selected' : ''; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (LKR):</label>
                        <input type="number" id="amount" name="amount" step="0.01" min="1" value="<?php echo $data['amount']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required><?php echo $data['description']; ?></textarea>
                        <small>Please provide details about this payment.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
