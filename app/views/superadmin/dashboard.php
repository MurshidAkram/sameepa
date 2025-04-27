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
                            <th>Facility</th>
                            <th>Duration (hrs)</th>
                            <th>Booked By</th>
                        </tr>
                        <?php if (!empty($data['bookings'])): ?>
                            <?php foreach ($data['bookings'] as $booking): ?>
                                <tr>
                                    <td><?php echo date('H:i', strtotime($booking->time)); ?></td>
                                    <td><?php echo htmlspecialchars($booking->facility_name); ?></td>
                                    <td><?php echo htmlspecialchars($booking->duration); ?></td>
                                    <td><?php echo htmlspecialchars($booking->booked_by); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4"> for today</td>
                            </tr>
                        <?php endif; ?>
                    </table>
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


                <div class="card complaint-card">
                    <h2>Complaints</h2>
                    <ul>
                        <?php if (!empty($data['complaints'])): ?>
                            <?php foreach ($data['complaints'] as $complaint): ?>
                                <li>
                                    <span class="complaint-title">
                                        <?php echo htmlspecialchars($complaint->title ?? 'No Title'); ?>
                                    </span>
                                    <span class="complaint-time">
                                        <?php echo htmlspecialchars($complaint->status ?? 'TBD'); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No complaints </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>

</html>