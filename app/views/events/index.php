<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/events/events.css">
    <title>Community Events | <?php echo SITENAME; ?></title>
</head>


<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
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
                    <a href="<?php echo URLROOT; ?>/events/joined" class="btn-joined-events">Joined Events</a>
                    <a href="<?php echo URLROOT; ?>/events/my_events" class="btn-my-events">My Events</a>
                </nav>
            </aside>

            <div class="events-content">
                <h1>Community Events</h1>
                <!-- In index.php view, add this after the <h1> tag -->
                <form class="events-search" method="GET" action="<?php echo URLROOT; ?>/events">

                    <input
                        type="text"
                        name="search"
                        placeholder="Search events..."
                        value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
                <p>Discover and join exciting events happening in your community!</p>

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
                                    <?php if (in_array($_SESSION['user_role_id'], [2, 3])): ?>
                                        <button class="btn-delete-event" onclick="deleteEvent(<?php echo $event->id; ?>)"> Delete Event
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($data['events'])): ?>
                    <div class="no-events">
                        <p>No events found. Be the first to create one!</p>
                        <a href="<?php echo URLROOT; ?>/events/create" class="btn-create-event">Create Event</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                fetch(`<?php echo URLROOT; ?>/events/admindelete/${eventId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to delete event');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the event');
                    });
            }
        }
    </script>
</body>


</html>