<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/payments/receipt.css">
    <title>Payment Receipt | <?php echo SITENAME; ?></title>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="logo">
                <h1><?php echo SITENAME; ?></h1>
            </div>
            <div class="receipt-title">
                <h2>Payment Receipt</h2>
                <p class="receipt-date">Date: <?php echo date('F d, Y'); ?></p>
            </div>
        </div>

        <div class="receipt-info">
            <div class="receipt-section">
                <h3>Transaction Details</h3>
                <table class="receipt-table">
                    <tr>
                        <td>Transaction ID:</td>
                        <td><?php echo is_array($data['payment']) ? $data['payment']['transaction_id'] : $data['payment']->transaction_id; ?></td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><?php echo date('F d, Y h:i A', strtotime(is_array($data['payment']) ? $data['payment']['created_at'] : $data['payment']->created_at)); ?></td>
                    </tr>
                </table>
            </div>

            <div class="receipt-section">
                <h3>Customer Information</h3>
                <table class="receipt-table">
                    <tr>
                        <td>Name:</td>
                        <td><?php echo is_array($data['user']) ? $data['user']['name'] : ($data['user']->name ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo is_array($data['user']) ? $data['user']['email'] : ($data['user']->email ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><?php echo is_array($data['payment']) ? $data['payment']['address'] : $data['payment']->address; ?></td>
                    </tr>
                </table>
            </div>

            <div class="receipt-section">
                <h3>Payment Details</h3>
                <table class="receipt-table payment-details">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>Rs.<?php echo number_format(is_array($data['payment']) ? $data['payment']['amount'] : $data['payment']->amount, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="receipt-footer">
        <p>Thank you for your payment!</p>
            <p class="small">This is an automatically generated receipt. For questions or concerns, please contact our support team.</p>
            <div class="receipt-actions">
                <button onclick="window.print()" class="btn-print">Print Receipt</button>
                <button onclick="window.location.href='<?php echo URLROOT; ?>/payments/<?php echo ($_SESSION['user_role_id'] == 1) ? 'requests' : 'admin_dashboard'; ?>'" class="btn-back">Back to Dashboard</button>
            </div>
        </div>
    </div>
</body>
</html>
