<!-- app/views/admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>SuperAdmin Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <section class="dashboard-overview">
                <div class="user-count">
                    <span>Active Users: 150</span>
                </div>

                <h1>Welcome to the Super Admin Dashboard</h1>

                <div class="dashboard-grid">
                    <div class="card bookings-card">
                        <h2>Today's Bookings</h2>
                        <table class="bookings-table">
                            <tr>
                                <th>Time</th>
                                <th>Gym</th>
                                <th>Pool</th>
                                <th>Tennis Court</th>
                            </tr>
                            <tr>
                                <td>9:00 AM</td>
                                <td class="booked">John Doe</td>
                                <td></td>
                                <td class="booked">Jane Smith</td>
                            </tr>
                            <tr>
                                <td>10:00 AM</td>
                                <td></td>
                                <td class="booked">Alice Johnson</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>11:00 AM</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12:00 PM</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>1:00 PM</td>
                                <td class="booked">Chad Simon</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2:00 PM</td>
                                <td></td>
                                <td class="booked">Ethan Philiphs</td>
                                <td class="booked">Josh England</td>
                            </tr>
                            <tr>
                                <td>3:00 PM</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4:00 PM</td>
                                <td class="booked">Tobi Payne</td>
                                <td class="booked">JoJo Siwa</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5:00 PM</td>
                                <td></td>
                                <td class="booked">Harry Kane</td>
                                <td></td>
                            </tr>

                        </table>
                    </div>

                    <div class="card payment-card">
                        <h2>Monthly Payments</h2>
                        <canvas id="paymentChart"></canvas>
                    </div>

                    <div class="card announcements-card">
                        <h2>Active Announcements</h2>
                        <ul>
                            <li>Community Meeting Next Week</li>
                            <li>New Recycling Guidelines</li>
                            <li>Pool Maintenance Schedule</li>
                        </ul>
                    </div>

                    <div class="bar-chart-container">
                        <h2>Complaints Status</h2>
                        <canvas id="monthlyComplaintsChart"></canvas>
                    </div>

                    <div class="card events-card">
                        <h2>Today's Events</h2>
                        <ul>
                            <li>
                                <span class="event-title">Yoga Class</span>
                                <span class="event-time">10:00 AM</span>
                            </li>
                            <li>
                                <span class="event-title">Book Club Meeting</span>
                                <span class="event-time">2:00 PM</span>
                            </li>
                            <li>
                                <span class="event-title">Community Dinner</span>
                                <span class="event-time">7:00 PM</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Bar Chart
        const barCtx = document.getElementById('monthlyComplaintsChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Number of Complaints',
                    data: [12, 19, 3, 5, 2, 3, 8, 14, 7, 10, 6, 9],
                    backgroundColor: '#6a006a'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Payment Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'pie', // Change from 'doughnut' to 'pie'
            data: {
                labels: ['Paid', 'Unpaid'],
                datasets: [{
                    data: [175, 25],
                    backgroundColor: ['#800080', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>