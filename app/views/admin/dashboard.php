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
                    <h2>Today's Bookings</h2>                
                    <?php if (!empty($data['today_bookings_list'])): ?>
                        <div class="today-bookings-list">                            
                            <ul>
                                <?php foreach ($data['today_bookings_list'] as $booking): ?>
                                    <li>
                                        <span class="booking-facility"><?php echo htmlspecialchars($booking->facility_name); ?></span>
                                        <span class="booking-time">
                                            <?php 
                                            $time = date('h:i A', strtotime($booking->booking_time));
                                            echo $time . ' (' . $booking->duration . 'hr)';
                                            ?>
                                        </span>
                                        <span class="booking-user"><?php echo htmlspecialchars($booking->booked_by); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="no-bookings-message">
                            <p>No facility bookings for today</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Complaints Card -->
                <div class="card complaints-card">
                    <h2>Complaints & Reports</h2>                   
                    <div class="complaints-lists">
                        <!-- Open Complaints -->
                        <div class="complaints-section">
                            <h3>Open Complaints</h3>
                            <?php if (!empty($data['open_complaints_list'])): ?>
                                <ul class="complaints-list">
                                    <?php foreach ($data['open_complaints_list'] as $complaint): ?>
                                        <li>
                                            <span class="complaint-title"><?php echo htmlspecialchars($complaint->title); ?></span>
                                            <span class="complaint-date">
                                                <?php echo date('M d, Y', strtotime($complaint->created_at)); ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="no-complaints">No open complaints</p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- In Progress Complaints -->
                        <div class="complaints-section">
                            <h3>In Progress</h3>
                            <?php if (!empty($data['in_progress_complaints_list'])): ?>
                                <ul class="complaints-list">
                                    <?php foreach ($data['in_progress_complaints_list'] as $complaint): ?>
                                        <li>
                                            <span class="complaint-title"><?php echo htmlspecialchars($complaint->title); ?></span>
                                            <span class="complaint-date">
                                                <?php echo date('M d, Y', strtotime($complaint->created_at)); ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="no-complaints">No complaints in progress</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>