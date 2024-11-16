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

    <style>
        .form-container {
            display: flex;
            min-height: calc(100vh - 120px);
            font-family: 'Poppins', sans-serif;
        }

        .form-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-wrapper {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 70px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(128, 0, 128, 0.1);
        }

        .form-wrapper h1 {
            color: #800080;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-wrapper p {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
            text-align: center;
        }

        .event-form .form-group {
            margin-bottom: 30px;
        }

        .event-form label {
            display: block;
            margin-bottom: 5px;
            color: #800080;
            font-weight: bold;
            font-size: 16px;
        }

        .event-form input,
        .event-form textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .event-form input:focus,
        .event-form textarea:focus {
            outline: none;
            border-color: #800080;
        }

        .event-form .btn-primary {
            background-color: #800080;
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            width: auto;
        }

        .event-form .btn-primary:hover {
            background-color: #9a009a;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main class="events-main">
            <h1>Create Event</h1>
            <br>
            <div class="form-container">
                <div class="form-content">
                    <div class="form-wrapper">
                        <form action="<?php echo URLROOT; ?>/events/create" method="post" class="event-form" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label for="image">Event Image:</label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>