<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/events.css">
    <title>Community Events | <?php echo SITENAME; ?></title>
    <!-- <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Headings */
        h1, h2, h3, h4 {
            color: #800080;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 600;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            flex-direction: row;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar */
        .events-sidebar {
            width: 250px;
            top: 0;
            /* position: sticky; */
            background-color: #f8f8f8;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
            overflow-y: auto;
            min-height: 100vh;
            padding: 20px;
        }

        .events-sidebar h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .events-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .events-nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .events-nav a:hover {
            background: #f5f5f5;
            color: #800080;
        }

        .btn-create-event {
            background: #800080;
            color: white !important;
        }

        .btn-create-event:hover {
            background: #9a009a !important;
        }

        /* Main Content */
        .events-main {
            flex-grow: 1;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 100%;
        }

        .events-main h1 {
            font-size: 28px;
            color: #800080;
            margin-bottom: 10px;
        }

        .events-search {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .events-search input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px;
        }

        .events-search button {
            background-color: #800080;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .events-search button:hover {
            background-color: #660066;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .event-card {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .event-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .event-details h3 {
            font-size: 18px;
            color: #800080;
            margin-bottom: 10px;
        }

        .event-info p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        .event-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .no-events {
            text-align: center;
            font-size: 16px;
            color: #555;
            margin-top: 20px;
        }
    </style> -->
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
    <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>
        <!-- Sidebar -->
        <aside class="events-sidebar">
            <h2>Event Navigation</h2>
            <nav class="events-nav">
                <a href="<?php echo URLROOT; ?>/events/index">Events</a>
                <a href="<?php echo URLROOT; ?>/events/create">Create Event</a>
                <a href="<?php echo URLROOT; ?>/events/joined">Joined Events</a>
                <a href="<?php echo URLROOT; ?>/events/my_events">My Events</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="events-main">
            <h1>Community Events</h1>
            <form class="events-search" method="GET" action="<?php echo URLROOT; ?>/events">
                <input type="text" name="search" placeholder="Search events..." 
                    value="<?php echo isset($data['search']) ? htmlspecialchars($data['search']) : ''; ?>">
                <button type="submit">Search</button>
            </form>
            <p>Discover and join exciting events happening in your community!</p>

            <div class="events-grid">
                <?php if (!empty($data['events'])): ?>
                    <?php foreach ($data['events'] as $event): ?>
                        <div class="event-card">
                            <img src="<?php echo URLROOT; ?>/events/image/<?php echo $event->id; ?>" alt="<?php echo $event->title; ?>">
                            <div class="event-details">
                                <h3><?php echo $event->title; ?></h3>
                                <p><i class="fas fa-calendar"></i> <?php echo date('F j, Y', strtotime($event->date)); ?></p>
                                <p><i class="fas fa-user"></i> By <?php echo $event->creator_name; ?></p>
                                <a href="<?php echo URLROOT; ?>/events/viewevent/<?php echo $event->id; ?>" class="btn-create-event">View Event</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-events">
                        <p>No events found. Be the first to create one!</p>
                        <a href="<?php echo URLROOT; ?>/events/create" class="btn-create-event">Create Event</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
