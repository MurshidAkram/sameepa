<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/payments.css"> <!-- Include the new styles here -->
    <title>Payments | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
      <div class="container main-content">
          <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
          <main class="payments-dashboard">
              <h1>Payment Dashboard</h1>

              <div class="month-selector">
                  <button id="prevMonth"><</button>
                  <span id="currentMonth">June 2024</span>
                  <button id="nextMonth">></button>
              </div>
            <section class="cards">
                <div class="payment-summary">
                    <div class="summary-card">
                        <h3>Total Residents</h3>
                        <p>100</p>
                    </div>
                    <div class="summary-card">
                        <h3>Payments Received</h3>
                        <p>85</p>
                    </div>
                    <div class="summary-card">
                        <h3>Pending Payments</h3>
                        <p>15</p>
                    </div>
                    <div class="summary-card">
                        <h3>Total Amount</h3>
                        <p>$25,500</p>
                    </div>
                </div>
            </section>
            <section class="payment-overview">
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
            </section>
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
    </script>
</body>

</html>