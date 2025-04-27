<!-- app/views/resident/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/resident/dashboard.css">
    <title>Resident Dashboard | <?php echo SITENAME; ?></title>
    <style>
        /* Additional inline styles to enhance dashboard */
        .dashboard-container {
            background: linear-gradient(to bottom right, #f8f8ff, #f0f0ff);
            min-height: calc(100vh - 60px);
            /* Adjust based on your navbar height */
        }

        main {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        main h1 {
            font-size: 2.2rem;
            margin-bottom: 25px;
            background: linear-gradient(45deg, #800080, #9a009a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
            padding-bottom: 5px;
            border-bottom: 3px solid #800080;
        }

        .overview-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .overview-card {
            flex: 1;
            min-width: 280px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }

        .overview-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .overview-card.announcements::before {
            background-color: #4CAF50;
        }

        .overview-card.events::before {
            background-color: #2196F3;
        }

        .overview-card.maintenance::before {
            background-color: #FFC107;
        }

        .overview-card.polls::before {
            background-color: #df1e1e;
        }

        .overview-card h2 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #4d4d4d;
        }

        .overview-card ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }

        .overview-card li {
            padding: 12px 0;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
        }

        .overview-card li:last-child {
            border-bottom: none;
        }

        .event-title,
        .booking-facility {
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        .event-datetime,
        .booking-date,
        .booking-time {
            font-size: 0.9rem;
            color: #777;
        }

        .btn-view {
            display: inline-block;
            padding: 10px 18px;
            background: linear-gradient(to right, #800080, #9a009a);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .overview-row {
                flex-direction: column;
            }

            main {
                padding: 15px;
            }

            main h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Welcome Back! <?php echo $_SESSION['name'] ?></h1>

            <section class="dashboard-overview">
                <div class="overview-row">
                    <div class="overview-card announcements">
                        <h2>View the Latest Announcements</h2>
                        <ul>
                            <?php if (!empty($data['announcements'])): ?>
                                <?php foreach ($data['announcements'] as $announcement): ?>
                                    <li><?php echo htmlspecialchars($announcement->title); ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No active announcements</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/announcements/index" class="btn-view">View All</a>
                    </div>
                    <div class="overview-card events">
                        <h2>Upcoming Events You have Joined</h2>
                        <ul>
                            <?php if (!empty($data['events'])): ?>
                                <?php foreach ($data['events'] as $event): ?>
                                    <li>
                                        <span class="event-title"><?php echo htmlspecialchars($event->title); ?></span>
                                        <span class="event-datetime">
                                            <?php
                                            $date = date('M d, Y', strtotime($event->date));
                                            $time = date('h:i A', strtotime($event->time));
                                            echo $date . ' at ' . $time;
                                            ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No upcoming events</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/events/index" class="btn-view">View Events</a>
                    </div>
                    <div class="overview-card maintenance">
                        <h2>Maintenance Requests</h2>
                        <ul>
                            <?php if (!empty($data['requests'])): ?>
                                <?php foreach ($data['requests'] as $request): ?>
                                    <li>
                                        <span class="event-title"><?php echo htmlspecialchars($request->description); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No Maintenance Requests</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/resident/maintenance" class="btn-view">Submit Request</a>
                    </div>
                </div>
                <div class="overview-row">
                    <div class="overview-card events">
                        <h2>Polls you havent voted in</h2>
                        <ul>
                            <?php if (!empty($data['unvotedPolls'])): ?>
                                <?php foreach ($data['unvotedPolls'] as $unvotedPolls): ?>
                                    <li>
                                        <span class="event-title"><?php echo htmlspecialchars($unvotedPolls->title); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>YOu have voted in all active Polls</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/polls/index" class="btn-view">Vote in Polls</a>
                    </div>
                    <div class="overview-card announcements">
                        <h2>Your Bookings</h2>
                        <ul>
                            <?php if (!empty($data['mybookings'])): ?>
                                <?php foreach ($data['mybookings'] as $mybookings): ?>
                                    <li>
                                        <span class="booking-facility"><?php echo htmlspecialchars($mybookings->facility_name); ?></span>
                                        <span class="booking-date">
                                            <?php echo date('F j, Y', strtotime($mybookings->booking_date)); ?>
                                        </span>
                                        <span class="booking-time">
                                            <?php
                                            $time = date('h:i A', strtotime($mybookings->booking_time));
                                            echo $time . ' (' . $mybookings->duration . 'hr)';
                                            ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>You have no bookings</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/facilities/allmybookings" class="btn-view">View Bookings</a>
                    </div>
                    <div class="overview-card maintenance">
                        <h2>Active Forums</h2>
                        <ul>
                            <?php if (!empty($data['activeForums'])): ?>
                                <?php foreach ($data['activeForums'] as $activeForums): ?>
                                    <li>
                                        <span class="event-title"><?php echo htmlspecialchars($activeForums->title); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>No active Forums</li>
                            <?php endif; ?>
                        </ul>
                        <a href="<?php echo URLROOT; ?>/forums/index" class="btn-view">Go to Forums</a>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>