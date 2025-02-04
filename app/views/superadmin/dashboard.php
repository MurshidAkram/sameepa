<!-- app/views/admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/superadmin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>SuperAdmin Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
        
<?php 
$activeUsers = $data['activeUsers'] ?? 0; 
if (is_numeric($activeUsers)) : ?>
    <div class="user-count">
        <span>Active Users: <?php echo $activeUsers; ?></span>
    </div>
<?php endif; ?>


                <h1>Welcome to the Super Admin Dashboard</h1>

                <div class="dashboard-grid">
                    <!-- Bookings Card -->
                    <div class="card bookings-card">
    <h2>Today's Bookings</h2>
    <table class="bookings-table">
        <tr>
            <th>Time</th>
            <th>Gym</th>
            <th>Pool</th>
            <th>Tennis Court</th>
        </tr>
        <?php if (!empty($data['bookings'])): ?>
            <?php foreach ($data['bookings'] as $booking): ?>
                <tr>
                    <td><?php echo date('H:i', strtotime($booking->time)); ?></td>
                    <td><?php echo ($booking->gym > 0) ? $booking->gym : '-'; ?></td>
                    <td><?php echo ($booking->pool > 0) ? $booking->pool : '-'; ?></td>
                    <td><?php echo ($booking->tennis > 0) ? $booking->tennis : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No bookings for today</td></tr>
        <?php endif; ?>
    </table>
</div>

                    <!-- Payment Card -->
                    <div class="card payment-card">
                        <h2>Monthly Payments</h2>
                        <canvas id="paymentChart"></canvas>
                    </div>

                    <!-- Announcements Card -->
                   <!-- Announcements Card -->
<div class="card announcements-card">
    <h2>Active Announcements</h2>
    <ul>
        <?php if (!empty($data['announcement'])): ?>
            <?php foreach ($data['announcement'] as $announcement): ?>
                <li><?php echo htmlspecialchars($announcement->title); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No active announcements</li>
        <?php endif; ?>
    </ul>
</div>

                    <!-- Complaints Chart -->
                    <!-- <div class="bar-chart-container">
                        <h2>Complaints Status</h2>
                        <canvas id="monthlyComplaintsChart"></canvas>
                    </div> -->

                    <!-- Events Card -->
<div class="card events-card">
    <h2>Today's Events</h2>
    <ul>
        <?php if (!empty($data['todayEvents'])): ?>
            <?php foreach ($data['todayEvents'] as $event): ?>
                <li>
                    <span class="event-title">
                        <?php echo htmlspecialchars($event->event_title ?? 'No Title'); ?>
                    </span>
                    <span class="event-time">
                        <?php echo htmlspecialchars($event->event_time ?? 'TBD'); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No events scheduled for today.</li>
        <?php endif; ?>
    </ul>
</div>

                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <!-- <script>
        // Complaints Chart
        const complaintsData = <?php echo json_encode($data['complaintsStats'] ?? []); ?>;
        const barCtx = document.getElementById('monthlyComplaintsChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Number of Complaints',
                    data: complaintsData,
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
        }); -->

        // Payment Chart
        const paymentStats = <?php echo json_encode($data['payments'] ?? ['paid' => 0, 'unpaid' => 0]); ?>;
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        new Chart(paymentCtx, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Unpaid'],
                datasets: [{
                    data: [paymentStats.paid, paymentStats.unpaid],
                    backgroundColor: ['#800080', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>
