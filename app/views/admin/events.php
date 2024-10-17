<!-- app/views/resident/events.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/events.css"> <!-- Include the new styles here -->
    <title>Manage Events | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>

        <main>
            <div class="header-container">
                <h1>Manage Events</h1>
                <a href="#" class="btn btn-history">View Events History</a>
            </div>
            <p>Welcome to the Events Management page. Here, you can add, view, or remove community events.</p>

            <section class="events-overview">
                <!-- <h2>Upcoming Events</h2> -->
                <div class="header-container">
                    <h2>Upcoming Events</h2>
                    <a href="<?php echo URLROOT; ?>/admin/create_event" class="btn-create">Create New Event</a>
                </div>
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Community BBQ</td>
                            <td>Sept 25, 2024</td>
                            <td>Main Park</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Book Club</td>
                            <td>Oct 5, 2024</td>
                            <td>Community Center</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Yoga Class</td>
                            <td>Oct 12, 2024</td>
                            <td>Fitness Hall</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>