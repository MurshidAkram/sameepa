<!-- app/views/events/create.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/events.css">

    <title>Create Event | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="events-main">
            <aside class="events-sidebar">
                <h2>Event Navigation</h2>
                <nav class="events-nav">
                    <a href="<?php echo URLROOT; ?>/events/create" class="btn-create-event">Create Event</a>
                    <a href="<?php echo URLROOT; ?>/resident/joined_events" class="btn-joined-events">Joined Events</a>
                    <a href="<?php echo URLROOT; ?>/resident/my_events" class="btn-my-events">My Events</a>
                </nav>
            </aside>
            <h1>Create Event</h1>
            <br />
            <form action="<?php echo URLROOT; ?>/events/create" method="post" class="event-form">
                <div class="form-group">
                    <label for="title">Event Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $data['title']; ?>" class="form-control">
                    <?php if (in_array('Title is required', $data['errors'])) : ?>
                        <div class="error"><?php echo 'Title is required'; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control"><?php echo $data['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo $data['date']; ?>" class="form-control">
                    <?php if (in_array('Date is required', $data['errors'])) : ?>
                        <div class="error"><?php echo 'Date is required'; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" value="<?php echo $data['time']; ?>" class="form-control">
                    <?php if (in_array('Time is required', $data['errors'])) : ?>
                        <div class="error"><?php echo 'Time is required'; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo $data['location']; ?>" class="form-control">
                    <?php if (in_array('Location is required', $data['errors'])) : ?>
                        <div class="error"><?php echo 'Location is required'; ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>