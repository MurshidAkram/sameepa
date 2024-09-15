<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/request.css">
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/external/u_profile.css"> -->
    <title>Edit Profile | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/components/side_panel_external.php'; ?>

        <main>
            <h1>Edit Profile</h1>
            <section class="profile-form">
                <form action="<?php echo URLROOT; ?>/profile/update" method="post" enctype="multipart/form-data">
                    <h2>Update Your Information</h2>
                    
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="John Doe" required>
                    
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="john.doe@example.com" required>
                    
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm new password" required>
                    
                    <label for="profile-picture">Profile Picture (optional)</label>
                    <input type="file" id="profile-picture" name="profile_picture">
                    
                    <button type="submit">Save Changes</button>
                </form>
            </section>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
