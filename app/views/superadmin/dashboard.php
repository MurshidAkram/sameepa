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

                    <div class="card bar-chart-container">
                        <h2>Complaints Status</h2>
                        <canvas id="monthlyComplaintsChart"></canvas>
                    </div>

                    <div class="card events-card">
    <h2>Upcoming Events</h2>
    <ul>
        <?php if (isset($events) && !empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <li>
                    <span class="event-title"><?php echo htmlspecialchars($event['title']); ?></span>
                    <span class="event-time"><?php echo date("g:i A", strtotime($event['time'])); ?></span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No upcoming events</p>
        <?php endif; ?>
    </ul>
</div>

                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        // Bar Chart
        const barCtx = document.getElementById("monthlyComplaintsChart").getContext("2d");
        const complaintsChart = new Chart(barCtx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Number of Complaints",
                    data: [12, 19, 3, 5, 2, 3, 8, 14, 7, 10, 6, 9],
                    backgroundColor: "#3498db"
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Update Bar Chart Data
        function updateComplaintsChart(chart) {
            setInterval(() => {
                const randomData = Array.from({ length: 12 }, () => Math.floor(Math.random() * 20));
                chart.data.datasets[0].data = randomData;
                chart.update();
            }, 5000);
        }
        updateComplaintsChart(complaintsChart);

        // Pie Chart for Payments
        const paymentCtx = document.getElementById("paymentChart").getContext("2d");
        new Chart(paymentCtx, {
            type: "pie",
            data: {
                labels: ["Paid", "Unpaid"],
                datasets: [{
                    data: [175, 25],
                    backgroundColor: ["#3498db", "#e0e0e0 "]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });

        // Show Notifications
        function showNotification(message) {
            const notification = document.createElement("div");
            notification.classList.add("notification");
            notification.innerText = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
        showNotification("Welcome to the Dashboard!");

        // Expand/Collapse Announcements
        document.querySelectorAll(".announcements-card li").forEach(item => {
            item.addEventListener("click", function () {
                this.classList.toggle("expanded");
            });
        });
    </script>
</body>

</html>
