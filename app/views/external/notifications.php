<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/notification.css">
    <title>Service Requests | <?php echo SITENAME; ?></title>

</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <section id="new-requests" class="notification-section">
                <h1>New Customer Requests</h1>
                <div class="notification-card">
                    <h3>New Request from John Doe</h3>
                    <p>Service: Plumbing</p>
                    <p>Date: 2024-11-24</p>
                    <button class="btn view-details">View Details</button>
                </div>
                <div class="notification-card">
                    <h3>New Request from Jane Smith</h3>
                    <p>Service: Gardening</p>
                    <p>Date: 2024-11-25</p>
                    <button class="btn view-details">View Details</button>
                </div>
            </section>

            <section id="booking-reminders" class="notification-section">
                <h1>Booking Reminders</h1>
                <div class="notification-card">
                    <h3>Upcoming Booking with Adam Brown</h3>
                    <p>Service: Electrical</p>
                    <p>Time: 10:30 AM</p>
                    <button class="btn view-details">View Details</button>
                </div>
            </section>

            <section id="maintenance-alerts" class="notification-section">
                <h1>Maintenance Alerts</h1>
                <div class="notification-card alert">
                    <h3>System Maintenance</h3>
                    <p>Scheduled for: 2024-11-30</p>
                    <p>Duration: 2 hours</p>
                </div>
                <div class="notification-card alert">
                    <h3>Service Provider Maintenance</h3>
                    <p>Scheduled for: 2024-12-01</p>
                    <p>Duration: 3 hours</p>
                </div>
            </section>
        </main>
    </div>
</body>

</html>