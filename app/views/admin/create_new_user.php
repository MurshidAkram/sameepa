
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_new_user.css">
    <title>Create New User | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main class="create-user-dashboard">
            <a href="<?php echo URLROOT; ?>/admin/users" class="btn-back">Back</a>
            <section class="user-form">
                <h1>Create New User</h1>
                <form action="<?php echo URLROOT; ?>/admin/create_new_user" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="">Select a role</option>
                            <option value="admin">Admin</option>
                            <option value="resident">Resident</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <button type="submit" class="btn-submit">Create User</button>
                </form>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
