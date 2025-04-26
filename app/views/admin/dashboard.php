<!-- app/views/admin/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main>
            <div class="dashboard-header">
                <h1>Welcome to the Admin Dashboard</h1>
            </div>

            <div class="dashboard-grid">
                <!-- Announcements Card -->
                <div class="card announcements-card">
                    <h2>Active Announcements</h2>
                    <ul>
                        <?php if (!empty($data['announcements'])): ?>
                            <?php foreach ($data['announcements'] as $announcement): ?>
                                <li><?php echo htmlspecialchars($announcement->title); ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No active announcements</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Events Card -->
                <div class="card events-card">
                    <h2>Upcoming Events</h2>
                    <ul>
                        <?php if (!empty($data['events'])): ?>
                            <?php foreach ($data['events'] as $event): ?>
                                <li>
                                    <span class="event-title"><?php echo htmlspecialchars($event->title); ?></span>
                                    <span class="event-datetime">
                                        <?php 
                                        $date = date('M d, Y', strtotime($event->date));
                                        $time = date('h:i A', strtotime($event->time));
                                        echo $date . ' at ' . $time;
                                        ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No upcoming events</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Facilities Card -->
                <div class="card facilities-card">
                    <h2>Facility Bookings</h2>
                    <div class="stats-content">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $data['today_bookings'] ?? 0; ?></span>
                            <span class="stat-label">Today's Bookings</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $data['total_facilities'] ?? 0; ?></span>
                            <span class="stat-label">Total Facilities</span>
                        </div>
                    </div>
                </div>

                <!-- Complaints Card -->
                <div class="card complaints-card">
                    <h2>Complaints & Reports</h2>
                    <div class="stats-content">
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $data['open_complaints'] ?? 0; ?></span>
                            <span class="stat-label">Open Complaints</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?php echo $data['resolved_complaints'] ?? 0; ?></span>
                            <span class="stat-label">Resolved This Month</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>