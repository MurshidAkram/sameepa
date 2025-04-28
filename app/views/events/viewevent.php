<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/events.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title><?php echo $data['event']['title']; ?> | <?php echo SITENAME; ?></title>
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
            <?php if ($_SESSION['user_role_id'] == 1): ?>
                <aside class="events-sidebar">
                    <h2>Event Navigation</h2>
                    <nav class="events-nav">
                        <a href="<?php echo URLROOT; ?>/events/index" class="btn-created-event">Events</a>
                        <a href="<?php echo URLROOT; ?>/events/create" class="btn-created-event">Create Event</a>
                        <a href="<?php echo URLROOT; ?>/events/joined" class="btn-joined-events">Joined Events</a>
                        <a href="<?php echo URLROOT; ?>/events/my_events" class="btn-my-events">My Events</a>
                    </nav>
                </aside>
            <?php endif; ?>
            <div class="event-view-container">
                <div class="top-actions">
                    <?php if ($_SESSION['user_role_id'] == 2): ?>
                        <a href="<?php echo URLROOT; ?>/events/index" class="back-button">
                            <i class="fas fa-arrow-left"></i> Back to Events
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URLROOT; ?>/events" class="back-button">
                            <i class="fas fa-arrow-left"></i> Back to Events
                        </a>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role_id'] == 2): ?>
                        <form action="<?php echo URLROOT; ?>/events/admindelete/<?php echo $data['event']['id']; ?>" method="post">
                            <button type="submit" class="adminremoveeve" onclick="return confirm('Are you sure you want to delete this facility?')">
                                <i class="fas fa-trash"></i> Delete Event
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="event-view-content">
                    <div class="event-image-section">
                        <img src="<?php echo URLROOT; ?>/events/image/<?php echo $data['event']['id']; ?>"
                            alt="<?php echo $data['event']['title']; ?>"
                            class="event-main-image">

                        <div class="event-creator-info">
                            <i class="fas fa-user-circle"></i>
                            <span>Organized by <?php echo $data['event']['creator_name']; ?></span>
                        </div>
                    </div>

                    <div class="event-details-section">
                        <h1 class="event-title"><?php echo $data['event']['title']; ?></h1>

                        <div class="event-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span><?php echo date('F j, Y', strtotime($data['event']['date'])); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span><?php echo date('g:i A', strtotime($data['event']['time'])); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo $data['event']['location']; ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-users"></i>
                                <span><?php echo $data['participantCount']; ?> Participants</span>
                            </div>
                        </div>

                        <div class="event-description">
                            <h2>About This Event</h2>
                            <p><?php echo nl2br($data['event']['description']); ?></p>
                        </div>

                        <?php if ($data['event']['created_by'] != $_SESSION['user_id']): ?>
                            <?php if ($data['event']['is_active']): ?>
                                <button id="joinButton"
                                    class="join-button <?php echo $data['isJoined'] ? 'joined' : ''; ?>"
                                    data-event-id="<?php echo $data['event']['id']; ?>"
                                    data-is-joined="<?php echo $data['isJoined'] ? 'true' : 'false'; ?>">
                                    <?php echo $data['isJoined'] ? 'Leave Event' : 'Join Event'; ?>
                                </button>
                            <?php else: ?>
                                <button class="join-button disabled" disabled>Event Has Ended</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script>
        document.getElementById('joinButton')?.addEventListener('click', async function() {
            const button = this;
            const eventId = button.dataset.eventId;
            const isJoined = button.dataset.isJoined === 'true';


            try {
                const response = await fetch(`<?php echo URLROOT; ?>/events/${isJoined ? 'leave' : 'join'}/${eventId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });


                const data = await response.json();


                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to update event participation. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });

        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                fetch(`<?php echo URLROOT; ?>/events/admindelete/${eventId}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            <?php if ($_SESSION['user_role_id'] == 2): ?>
                                window.location.href = '<?php echo URLROOT; ?>/events/index';
                            <?php else: ?>
                                window.location.href = '<?php echo URLROOT; ?>/events';
                            <?php endif; ?>
                        } else {
                            alert('Failed to delete event');
                        }
                    });
            }
        }
    </script>
</body>

</html>