<!-- views/users/profile.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">

    <title><?php echo SITENAME; ?> - Profile</title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/header.php'; ?>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    <div class="dashboard-container">
        <?php
        // Load appropriate side panel based on user role
        switch ($_SESSION['user_role_id']) {
            case 1:
                require APPROOT . '/views/inc/components/side_panel_resident.php';
                break;
            case 2:
                require APPROOT . '/views/inc/components/side_panel_admin.php';
                break;
            case 3:
                require APPROOT . '/views/inc/components/side_panel_superadmin.php';
                break;
            case 4:
                require APPROOT . '/views/inc/components/side_panel_maintenance.php';
                break;
            case 5:
                require APPROOT . '/views/inc/components/side_panel_security.php';
                break;
            case 6:
                require APPROOT . '/views/inc/components/side_panel_external.php';
                break;
        }
        ?>

        <div class="profile-container">
            <div class="profile-content">
                <h1>Profile Management</h1>
                <?php if (!empty($data['message'])): ?>
                    <div class="alert <?php echo $data['message_type']; ?>">
                        <?php echo $data['message']; ?>
                    </div>
                <?php endif; ?>

                <div class="profile-image-section">
                    <?php if (!empty($data['profile_picture'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['profile_picture']); ?>" alt="Profile Picture" class="profile-picture">
                    <?php else: ?>
                        <img src="<?php echo URLROOT; ?>/public/img/default-profile.png" alt="Default Profile Picture" class="profile-picture">
                    <?php endif; ?>

                    <form action="<?php echo URLROOT; ?>/users/updateProfilePicture" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="profile_picture">Update Profile Picture:</label>
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Picture</button>
                    </form>
                </div>

                <form action="<?php echo URLROOT; ?>/users/updateProfile" method="POST" class="profile-form">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo $data['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $data['email']; ?>">
                    </div>

                    <?php if ($data['role_id'] == 1): // Resident specific fields 
                    ?>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" name="address" id="address" value="<?php echo $data['address']; ?> " readonly>
                        </div>
                        <div class="form-group">
                            <label for="phonenumber">Phone Number:</label>
                            <input type="text" name="phonenumber" id="phonenumber" value="<?php echo $data['phonenumber']; ?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="new_password">New Password (leave blank to keep current):</label>
                        <input type="password" name="new_password" id="new_password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <!-- <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Account</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                window.location.href = '<?php echo URLROOT; ?>/users/deleteAccount';
            }
        }
    </script>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>