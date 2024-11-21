<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/events/events.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Create Event | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        // Load appropriate side panel based on user role
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
                <a href="<?php echo URLROOT; ?>/events/index" class="btn-created-event">Events</a>
                    <a href="<?php echo URLROOT; ?>/events/create" class="btn-created-event">Create Event</a>
                    <a href="<?php echo URLROOT; ?>/events/joined" class="btn-joined-events">Joined Events</a>
                    <a href="<?php echo URLROOT; ?>/events/my_events" class="btn-my-events">My Events</a>
                </nav>
            </aside>

        <main class="content">
            <div class="create-event-container">
                <h1>Create New Event</h1>
                
                <?php //flash('event_message'); ?>
                
                <?php if(!empty($data['errors'])): ?>
                    <div class="error-messages">
                        <?php foreach($data['errors'] as $error): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URLROOT; ?>/events/create" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Event Title:</label>
                        <input type="text" name="title" id="title" value="<?php echo $data['title']; ?>" required 
                               maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Event Description:</label>
                        <textarea name="description" id="description" rows="6" required 
                                  class="form-control"><?php echo $data['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="date">Event Date:</label>
                        <input type="date" name="date" id="date" value="<?php echo $data['date']; ?>" 
                               min="<?php echo date('Y-m-d'); ?>" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="time">Event Time:</label>
                        <input type="time" name="time" id="time" value="<?php echo $data['time']; ?>" 
                               required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="location">Event Location:</label>
                        <input type="text" name="location" id="location" value="<?php echo $data['location']; ?>" 
                               required maxlength="255" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">Event Image (Optional):</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" 
                               class="form-control">
                        <small class="form-text text-muted">Allowed formats: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Create Event</button>
                        <a href="<?php echo URLROOT; ?>/events/index" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
     </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>