<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/events.css">
    <title>Joined Events | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
        }
        ?>

        <main class="events-main">
            <aside class="events-sidebar">
                <h2>Event Navigation</h2>
                <nav class="events-nav">
                    <a href="<?php echo URLROOT; ?>/events/index" class="btn-created-event">Events</a>
                    <a href="<?php echo URLROOT; ?>/events/create" class="btn-created-event">Create Event</a>
                    <a href="<?php echo URLROOT; ?>/events/joined" class="btn-joined-events active">Joined Events</a>
                    <a href="<?php echo URLROOT; ?>/events/my_events" class="btn-my-events">My Events</a>
                </nav>
            </aside>

            <div class="events-content">
                <h1>My Joined Events</h1>
                <p>Here are all the events you've joined!</p>

                <div class="events-grid">
                    <?php foreach ($data['events'] as $event): ?>
                        <div class="event-card">
                            <div class="event-image">
                                <img src="<?php echo URLROOT; ?>/events/image/<?php echo $event->id; ?>"
                                    alt="<?php echo $event->title; ?>">
                            </div>
                            <div class="event-details">
                                <h3 class="event-title"><?php echo $event->title; ?></h3>
                                <div class="event-info">
                                    <p class="event-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('F j, Y', strtotime($event->date)); ?>
                                    </p>
                                    <p class="event-time">
                                        <i class="fas fa-clock"></i>
                                        <?php echo date('g:i A', strtotime($event->time)); ?>
                                    </p>
                                    <p class="event-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo $event->location; ?>
                                    </p>
                                    <p class="event-organizer">
                                        <i class="fas fa-user"></i>
                                        By <?php echo $event->creator_name; ?>
                                    </p>
                                </div>
                                <div class="event-actions">
                                    <span class="participant-count">
                                        <i class="fas fa-users"></i>
                                        <?php echo $event->participant_count; ?> Participants
                                    </span>
                                    <a href="<?php echo URLROOT; ?>/events/viewevent/<?php echo $event->id; ?>"
                                        class="btn-view-event">View Event</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($data['events'])): ?>
                    <div class="no-events">
                        <p>You haven't joined any events yet.</p>
                        <a href="<?php echo URLROOT; ?>/events/index" class="btn-browse-events">Browse Events</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>