<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/payments.css">
    <title>Service Requests | <?php echo SITENAME; ?></title>

</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <section id="invoices">
                <h1>Invoices</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INV001</td>
                            <td>Web Hosting</td>
                            <td>$120</td>
                            <td>2024-11-01</td>
                            <td>Paid</td>
                        </tr>
                        <tr>
                            <td>INV002</td>
                            <td>Domain Registration</td>
                            <td>$15</td>
                            <td>2024-10-25</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>INV003</td>
                            <td>SSL Certificate</td>
                            <td>$30</td>
                            <td>2024-09-15</td>
                            <td>Paid</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section id="payment-methods">
                <h1>Payment Methods</h1>
                <ul>
                    <li><strong>Credit Card:</strong> Visa ending in 1234</li>
                    <li><strong>PayPal:</strong> user@example.com</li>
                    <li><strong>Bank Transfer:</strong> Account ending in 5678</li>
                </ul>
            </section>

            <section id="transactions">
                <h1>Transactions</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Invoice ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <tr>
                            <td>TXN001</td>
                            <td>INV001</td>
                            <td>$120</td>
                            <td>2024-11-02</td>
                            <td>Completed</td>
                        </tr>
                        <tr>
                            <td>TXN002</td>
                            <td>INV002</td>
                            <td>$15</td>
                            <td>2024-11-04</td>
                            <td>Pending</td>
                        </tr>
                        <tr>
                            <td>TXN003</td>
                            <td>INV003</td>
                            <td>$30</td>
                            <td>2024-09-16</td>
                            <td>Completed</td>
                        </tr>
                    </tbody>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>