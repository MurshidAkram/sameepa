<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css"> -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/superadmin/announcement.css"> <!-- Custom CSS for Announcements -->
    <title>Super Admin Announcements | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_superadmin.php'; ?>

        <main>
            <h1>Announcements</h1>
            <section class="dashboard-overview">

                <!-- Form for Adding Announcements -->
                <section class="announcement-form">
                    <h2>Create New Announcement</h2>
                    <form action="<?php echo URLROOT; ?>/superadmin/addAnnouncement" method="POST">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>

                        <label for="body">Announcement:</label>
                        <textarea id="body" name="body" rows="5" required></textarea>

                        <label for="category">Category:</label>
                        <select id="category" name="category">
                            <option value="general">General</option>
                            <option value="event">Event</option>
                            <option value="emergency">Emergency</option>
                        </select>
                        <label for="target">Target Audience:</label>
                        <select id="target" name="target">
                            <option value="all">All Residents</option>
                            <option value="building_a">Building A</option>
                            <option value="security">Security Personnel</option>
                        </select>

                        <label for="priority">Priority:</label>
                        <select id="priority" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>

                        <button type="submit" class="btn-primary">Submit</button>
                        <button type="submit" class="btn-primary">Update</button>
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
                                    <p><small>Category: <?php echo $announcement->category; ?></small></p>
                                    <p><small>Target Audience: <?php echo $announcement->target; ?></small></p>
                                    <p><small>Posted on: <?php echo $announcement->created_at; ?></small></p>
                                    
                                    <!-- Engagement Tracking (New Feature) -->
                                    <p><small>Views: <?php echo $announcement->views; ?> | Acknowledged: <?php echo $announcement->acknowledged; ?></small></p>

                                    <!-- Pin Announcement -->
                                    <a href="<?php echo URLROOT; ?>/superadmin/pinAnnouncement/<?php echo $announcement->id; ?>" class="btn-pin">Pin</a>

                                    <!-- Edit and Delete Buttons -->
                                    <a href="#update-form" class="btn-edit" onclick="fillUpdateForm('<?php echo $announcement->id; ?>', '<?php echo htmlspecialchars($announcement->title, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($announcement->body, ENT_QUOTES); ?>', '<?php echo $announcement->category; ?>', '<?php echo $announcement->target; ?>', '<?php echo $announcement->priority; ?>')">Edit</a>
                                    <a href="<?php echo URLROOT; ?>/superadmin/deleteAnnouncement/<?php echo $announcement->id; ?>" class="btn-delete">Delete</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No announcements available.</p>
                    <?php endif; ?>
                </section>

                <!-- Update Form Section -->
                <section id="update-form" class="announcement-form" style="display: none;">
                    <h2>Update Announcement</h2>
                    <form action="<?php echo URLROOT; ?>/superadmin/updateAnnouncement" method="POST">
                        <input type="hidden" id="update_id" name="id">
                        
                        <label for="update_title">Title:</label>
                        <input type="text" id="update_title" name="title" required>

                        <label for="update_body">Announcement:</label>
                        <textarea id="update_body" name="body" rows="5" required></textarea>

                        <label for="update_category">Category:</label>
                        <select id="update_category" name="category">
                            <option value="general">General</option>
                            <option value="event">Event</option>
                            <option value="emergency">Emergency</option>
                        </select>

                        <label for="update_target">Target Audience:</label>
                        <select id="update_target" name="target">
                            <option value="all">All Residents</option>
                            <option value="building_a">Building A</option>
                            <option value="security">Security Personnel</option>
                        </select>

                        <label for="update_priority">Priority:</label>
                        <select id="update_priority" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>

                        <button type="submit" class="btn-primary">Update</button>
                    </form>
                </section>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
    
    <script>
        function fillUpdateForm(id, title, body, category, target, priority) {
            document.getElementById('update_id').value = id;
            document.getElementById('update_title').value = title;
            document.getElementById('update_body').value = body;
            document.getElementById('update_category').value = category;
            document.getElementById('update_target').value = target;
            document.getElementById('update_priority').value = priority;
            
            // Show the update form
            document.getElementById('update-form').style.display = 'block';
        }
    </script>
</body>

</html>
