<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_payment.css">
    <title>Create Payment | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>
        <main class="create-payment-dashboard">
            <a href="<?php echo URLROOT; ?>/superadmin/payments" class="btn-back">Back</a>
            <section class="payment-form">
                <h1>Create New Payment</h1>
                <form action="<?php echo URLROOT; ?>/superadmin/create_payment" method="post">
                    <div class="form-group">
                        <label for="resident_name">Resident Name:</label>
                        <input type="text" id="resident_name" name="resident_name" required>
                    </div>

                    <div class="form-group">
                        <label for="unit_number">Unit Number:</label>
                        <input type="text" id="unit_number" name="unit_number" required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (USD):</label>
                        <input type="number" id="amount" name="amount" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Payment Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Create Payment</button>
                </form>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>