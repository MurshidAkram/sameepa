<!-- app/views/resident/dashboard.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <title>Resident Dashboard | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_resident.php'; ?>

        <main>
            <h1>Welcome, <?php echo $_SESSION['name'] ?></h1>

            <section class="dashboard-overview">
                <div class="overview-card announcements">
                    <h2>Latest Announcement</h2>
                    <p>Community pool opening on June 1st!</p>
                    <a href="<?php echo URLROOT; ?>/announcements/index" class="btn-view">View All</a>
                </div>
                <div class="overview-card events">
                    <h2>Upcoming Event</h2>
                    <p>Summer BBQ on July 4th</p>
                    <a href="<?php echo URLROOT; ?>/events/index" class="btn-view">View Events</a>
                </div>
                <div class="overview-card maintenance">
                    <h2>Maintenance Request</h2>
                    <p>Last request: Leaky faucet (In Progress)</p>
                    <a href="<?php echo URLROOT; ?>/resident/maintenance" class="btn-view">Submit Request</a>
                </div>
            </section>

            <section class="profile-section">
                <h2>Your Profile</h2>
                <p>Edit your account details below. You can update your information or delete your account.</p>

                <div class="form-container">
                    <div class="form-content">
                        <div class="form-wrapper">
                            <form action="<?php echo URLROOT; ?>/resident/updateProfile" method="POST">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" id="username" name="username" value="JohnDoe" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="john@example.com" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" value="******" required>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" id="phone" name="phone" value="123-456-7890">
                                </div>

                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <textarea id="address" name="address">Apartment 48</textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="form-submit btn-update">Update Profile</button>
                                    <a href="<?php echo URLROOT; ?>/resident/deleteAccount" class="btn-delete">Delete Profile</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>