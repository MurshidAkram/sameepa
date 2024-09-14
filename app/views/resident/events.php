<!-- app/views/resident/events.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/events.css"> <!-- Include the new styles here -->
    <title>Manage Your Events | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Your Events</h1>
            <p>Welcome to the Events page. Here, you can view and manage all the events you've created or joined within your community.</p>

            <section class="events-overview">
                <h2>Upcoming Events</h2>
                <p>Below is a list of your upcoming events. You can edit or delete the events you’ve created or view details for the ones you’ve joined.</p>

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
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Book Club</td>
                            <td>Oct 5, 2024</td>
                            <td>Community Center</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Yoga Class</td>
                            <td>Oct 12, 2024</td>
                            <td>Fitness Hall</td>
                            <td>
                                <a href="#">View</a> |
                                <a href="#">Edit</a> |
                                <a href="#">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="create-event">
                <h2>Create a New Event</h2>
                <p>Want to organize an event for your fellow residents? Fill in the details and create an event to bring the community together!</p>
                <a href="<?php echo URLROOT; ?>/resident/create_event" class="btn-create">Create Event</a>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>