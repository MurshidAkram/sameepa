<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/events.css">
    <title>My Events | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
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
                    <a href="<?php echo URLROOT; ?>/events/create" class="btn-created-event">Create Event</a>
                    <a href="<?php echo URLROOT; ?>/events/joined" class="btn-joined-events">Joined Events</a>
                    <a href="<?php echo URLROOT; ?>/events/my_events" class="btn-my-events active">My Events</a>
                </nav>
            </aside>

            <div class="events-content">
                <h1>My Events</h1>
                <p>Manage the events you have created</p>

                <div class="events-grid">
                    <?php foreach($data['events'] as $event): ?>
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
                                </div>
                                <div class="event-actions">
                                    <button onclick="viewParticipants(<?php echo $event->id; ?>)" class="btn-view-participants">
                                        <i class="fas fa-users"></i>
                                        <?php echo $event->participant_count; ?> Participants
                                    </button>
                                    <div class="event-management-buttons">
                                        <a href="<?php echo URLROOT; ?>/events/update/<?php echo $event->id; ?>" 
                                           class="btn-update-event">Update</a>
                                        <button onclick="deleteEvent(<?php echo $event->id; ?>)" 
                                                class="btn-delete-event">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if(empty($data['events'])): ?>
                    <div class="no-events">
                        <p>You haven't created any events yet.</p>
                        <a href="<?php echo URLROOT; ?>/events/create" class="btn-create-event">Create Event</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Participants Modal -->
    <div id="participantsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Event Participants</h2>
            <div id="participantsList"></div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script>
    function viewParticipants(eventId) {
        const modal = document.getElementById('participantsModal');
        const participantsList = document.getElementById('participantsList');
        
        // Fetch participants
        fetch(`<?php echo URLROOT; ?>/events/getParticipants/${eventId}`)
            .then(response => response.json())
            .then(data => {
                participantsList.innerHTML = '';
                if (data.length > 0) {
                    const ul = document.createElement('ul');
                    data.forEach(participant => {
                        const li = document.createElement('li');
                        li.textContent = `${participant.name} (${participant.joined_at})`;
                        ul.appendChild(li);
                    });
                    participantsList.appendChild(ul);
                } else {
                    participantsList.innerHTML = '<p>No participants yet</p>';
                }
                modal.style.display = 'block';
            });
    }

    function deleteEvent(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            fetch(`<?php echo URLROOT; ?>/events/delete/${eventId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to delete event');
                }
            });
        }
    }

    // Modal close functionality
    const modal = document.getElementById('participantsModal');
    const span = document.getElementsByClassName('close')[0];
    
    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>

    <style>
        /* Modal Base Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    overflow: auto;
}

.modal-content {
    position: relative;
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    animation: modalFadeIn 0.3s ease-out;
}

/* Close Button Styles */
.close {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    color: #666;
    cursor: pointer;
    transition: color 0.2s;
}

.close:hover {
    color: #000;
}

/* Participants List Styles */
#participantsList {
    margin-top: 20px;
    max-height: 300px;
    overflow-y: auto;
}

#participantsList ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

#participantsList li {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

#participantsList li:last-child {
    border-bottom: none;
}

/* Modal Animation */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
        </style>
</body>
</html>