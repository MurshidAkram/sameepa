<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['event']->title; ?> | <?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/events.css">
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="event-details-main">
            <div class="event-details-container">
                <div class="event-image-container">
                    <img src="<?php echo URLROOT; ?>/img/events/<?php echo !empty($data['event']['image']) ? $data['event']->image : 'default.jpg'; ?>"
                        alt="<?php echo $data['event']->title; ?>"
                        class="event-detail-image">
                </div>

                <div class="event-info-container">
                    <h1 class="event-detail-title"><?php echo $data['event']['title']; ?></h1>

                    <div class="event-meta">
                        <p class="event-date">
                            <strong>Date:</strong>
                            <?php echo date('F j, Y', strtotime($data['event']['date'])); ?>
                        </p>
                        <p class="event-time">
                            <strong>Time:</strong>
                            <?php echo date('g:i A', strtotime($data['event']['time'])); ?>
                        </p>
                        <p class="event-location">
                            <strong>Location:</strong>
                            <?php echo $data['event']['location']; ?>
                        </p>
                        <p class="event-organizer">
                            <strong>Organized by:</strong>
                            <?php echo $data['event']['created_by_name']; ?>
                        </p>
                        <p class="event-participants">
                            <strong>Participants:</strong>
                            <?php echo $data['participant_count']; ?>
                        </p>
                    </div>

                    <div class="event-description">
                        <h2>Description</h2>
                        <p><?php echo nl2br($data['event']['description']); ?></p>
                    </div>

                    <div class="event-actions">
                        <?php if (!$data['is_joined']) : ?>
                            <button type="button"
                                class="btn-join-event"
                                onclick="joinEvent(<?php echo $data['event']['id']; ?>)">
                                Join Event
                            </button>
                        <?php else : ?>
                            <button class="btn-joined-event" disabled>Joined</button>
                        <?php endif; ?>

                        <?php if ($data['is_admin'] || $data['is_creator']) : ?>
                            <form action="<?php echo URLROOT; ?>/events/delete/<?php echo $data['event']['id']; ?>"
                                method="POST"
                                class="delete-form"
                                onsubmit="return confirm('Are you sure you want to delete this event?');">
                                <button type="submit" class="btn-delete-event">Delete Event</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

    <script>
        function joinEvent(eventId) {
            fetch(`${URLROOT}/events/join/${eventId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update UI to show joined status
                        const joinButton = document.querySelector('.btn-join-event');
                        joinButton.textContent = 'Joined';
                        joinButton.classList.remove('btn-join-event');
                        joinButton.classList.add('btn-joined-event');
                        joinButton.disabled = true;

                        // Update participant count
                        const participantElement = document.querySelector('.event-participants strong');
                        const currentCount = parseInt(participantElement.textContent.split(': ')[1]);
                        participantElement.textContent = `Participants: ${currentCount + 1}`;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>