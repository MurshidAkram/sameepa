<!-- app/views/events/index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/events.css">
    <title>Community Events | <?php echo SITENAME; ?></title>
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

            <div class="events-content">
                <h1>Community Events</h1>
                <p>Discover and join exciting events happening in your community!</p>

                <div class="events-container">
                    <?php
                    // Dummy events data
                    $events = [
                        [
                            'id' => 1,
                            'title' => 'Community BBQ',
                            'date' => '2023-07-15',
                            'time' => '18:00',
                            'location' => 'Central Park',
                            'posted_by' => 'John Doe',
                            'image' => 'bbq.jpg'
                        ],
                        [
                            'id' => 2,
                            'title' => 'Yoga in the Park',
                            'date' => '2023-07-20',
                            'time' => '09:00',
                            'location' => 'Community Garden',
                            'posted_by' => 'Jane Smith',
                            'image' => 'yoga.jpg'
                        ],
                        [
                            'id' => 3,
                            'title' => 'Movie Night',
                            'date' => '2023-07-25',
                            'time' => '20:00',
                            'location' => 'Community Center',
                            'posted_by' => 'Mike Johnson',
                            'image' => 'movie.jpg'
                        ]
                    ];

                    foreach ($events as $event) :
                    ?>
                        <div class="event-card">
                            <img src="<?php echo URLROOT; ?>/img/bbq.jpeg" alt="<?php echo $event['title']; ?>" class="event-image">
                            <h2 class="event-title"><?php echo $event['title']; ?></h2>
                            <div class="event-details">
                                <p>Date: <?php echo $event['date']; ?> at <?php echo $event['time']; ?></p>
                                <p>Location: <?php echo $event['location']; ?></p>
                                <p>Posted by: <?php echo $event['posted_by']; ?></p>
                            </div>
                            <div class="event-actions">
                                <a href="<?php echo URLROOT; ?>/events/index<?php echo $event['id']; ?>" class="btn-view-event">View Event</a>
                                <a href="<?php echo URLROOT; ?>/events/join<?php echo $event['id']; ?>" class="btn-join-event">Join Event</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="calendar-component">
                    <div class="calendar-header">
                        <button id="prev-month">&lt;</button>
                        <h2 id="current-month">July 2023</h2>
                        <button id="next-month">&gt;</button>
                    </div>
                    <div class="calendar-grid" id="calendar-grid">
                        <!-- Calendar days will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <script src="<?php echo URLROOT; ?>/js/events_calendar.js"></script>
</body>

</html>