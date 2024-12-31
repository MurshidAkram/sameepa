<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/payments.css"> <!-- Include the new styles here -->
    <title>Payments | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main class="payments-dashboard">
            <div class="payments-content">
                <div class="header-container">
                    <h1>Payment Dashboard</h1>
                    <div class="button-container">
                        <a href="<?php echo URLROOT; ?>/admin/create_payment" class="btn-create">New Payment</a>
                    </div>
                </div>
                <div class="payments-container">
                    <div class="month-selector">
                        <button id="prevMonth">
                            << /button>
                                <span id="currentMonth">June 2024</span>
                                <button id="nextMonth">></button>
                    </div>

                    <div class="payment-cards-container">
                        <div class="payment-card" data-filter="all">
                            <h3>Total Residents</h3>
                            <p>100</p>
                        </div>
                        <div class="payment-card" data-filter="paid">
                            <h3>Payments Received</h3>
                            <p>85</p>
                        </div>
                        <div class="payment-card" data-filter="pending">
                            <h3>Pending Payments</h3>
                            <p>15</p>
                        </div>
                        <div class="payment-card" data-filter="all">
                            <h3>Total Amount</h3>
                            <p>$25,500</p>
                        </div>
                    </div>

                    <div class="payment-table-container">
                        <table class="payment-table">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Unit Number</th>
                                    <th>Payment Status</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>A101</td>
                                    <td><span class="status paid">Paid</span></td>
                                    <td>$300</td>
                                    <td>June 5, 2023</td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>B205</td>
                                    <td><span class="status paid">Paid</span></td>
                                    <td>$300</td>
                                    <td>June 3, 2023</td>
                                </tr>
                                <tr>
                                    <td>Mike Johnson</td>
                                    <td>C310</td>
                                    <td><span class="status pending">Pending</span></td>
                                    <td>$300</td>
                                    <td>-</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Simple JavaScript to simulate month toggling
        const prevMonth = document.getElementById('prevMonth');
        const nextMonth = document.getElementById('nextMonth');
        const currentMonth = document.getElementById('currentMonth');

        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        let currentMonthIndex = 5; // June

        prevMonth.addEventListener('click', () => {
            currentMonthIndex = (currentMonthIndex - 1 + 12) % 12;
            currentMonth.textContent = `${months[currentMonthIndex]} 2023`;
        });

        nextMonth.addEventListener('click', () => {
            currentMonthIndex = (currentMonthIndex + 1) % 12;
            currentMonth.textContent = `${months[currentMonthIndex]} 2023`;
        });

        document.querySelectorAll('.payment-card').forEach(card => {
            card.addEventListener('click', () => {
                const filter = card.dataset.filter;
                const rows = document.querySelectorAll('.payment-table tbody tr');

                rows.forEach(row => {
                    const status = row.querySelector('.status').textContent.toLowerCase();
                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>