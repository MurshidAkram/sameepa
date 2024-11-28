<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/payments.css">
    <title>Make Payment | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="payments-dashboard">
            <div class="payments-content">
                <div class="header-container">
                    <h1>Monthly Payments</h1>
                </div>

                <div class="payment-summary">
                    <div class="payment-details">
                        <h2>June 2024 Payment</h2>
                        <p>Monthly Maintenance: $300</p>
                        <p>Due Date: June 30, 2024</p>
                        <p>Status:
                            <span class="status <?php echo $data['payment_status'] ?? 'pending'; ?>">
                                <?php echo ucfirst($data['payment_status'] ?? 'Pending'); ?>
                            </span>
                        </p>
                    </div>
                </div>

                <form action="<?php echo URLROOT; ?>/resident/upload_payment_proof" method="POST" enctype="multipart/form-data" class="payment-upload-form">
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online_banking">Online Banking</option>
                            <option value="cash">Cash Payment</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_proof">Upload Payment Proof</label>
                        <input type="file" name="payment_proof" id="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required>
                        <small>Accepted formats: JPG, PNG, PDF (Max 5MB)</small>
                    </div>

                    <div class="form-group">
                        <label for="payment_amount">Payment Amount</label>
                        <input type="number" name="payment_amount" id="payment_amount" value="300" readonly>
                    </div>

                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_reference">Transaction/Reference Number</label>
                        <input type="text" name="payment_reference" id="payment_reference" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-submit">Submit Payment Proof</button>
                    </div>
                </form>

                <div class="payment-history">
                    <h2>Payment History</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Submitted On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamically populate payment history -->
                            <?php if (!empty($data['payment_history'])): ?>
                                <?php foreach ($data['payment_history'] as $payment): ?>
                                    <tr>
                                        <td><?php echo $payment['month']; ?></td>
                                        <td>$<?php echo $payment['amount']; ?></td>
                                        <td><span class="status <?php echo strtolower($payment['status']); ?>">
                                                <?php echo $payment['status']; ?>
                                            </span></td>
                                        <td><?php echo $payment['submitted_date']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">No payment history available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Set today's date as default for payment date
        document.getElementById('payment_date').valueAsDate = new Date();

        // Optional: Add file validation
        document.getElementById('payment_proof').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (file.size > maxSize) {
                alert('File is too large. Maximum file size is 5MB.');
                event.target.value = ''; // Clear the file input
            }
        });
    </script>
</body>

</html>