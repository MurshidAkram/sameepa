<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/announcement.css"> <!-- Custom CSS for Announcements -->
    <title>Super Admin Announcements | <?php echo SITENAME; ?></title>
</head>

<body>  
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>Announcements</h1>

            <!-- Form for Adding Announcements -->
            <section class="announcement-form">
                <h2>Create New Announcement</h2>
                <form action="<?php echo URLROOT; ?>/superadmin/addAnnouncement" method="POST">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>

                    <label for="body">Announcement:</label>
                    <textarea id="body" name="body" rows="5" required></textarea>

                    <button type="submit" class="btn-primary">Submit</button>
                </form>
            </section>

            <!-- Section to Display Existing Announcements -->
            <section class="announcement-list">
                <h2>Existing Announcements</h2>

                <?php if (!empty($data['announcements'])): ?>
                    <ul>
                        <?php foreach ($data['announcements'] as $announcement): ?>
                            <li class="announcement-item">
                                <h3><?php echo $announcement->title; ?></h3>
                                <p><?php echo $announcement->body; ?></p>
                                <p><small>Posted on: <?php echo $announcement->created_at; ?></small></p>

                                <!-- Edit and Delete Buttons -->
                                <a href="<?php echo URLROOT; ?>/superadmin/editAnnouncement/<?php echo $announcement->id; ?>" class="btn-edit">Edit</a>
                                <a href="<?php echo URLROOT; ?>/superadmin/deleteAnnouncement/<?php echo $announcement->id; ?>" class="btn-delete">Delete</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No announcements available.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
