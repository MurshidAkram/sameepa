
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/users.css">
    <title>Manage Users | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main>
            <div class="header-container">
                <h1>Manage Users</h1>
                <a href="<?php echo URLROOT; ?>/admin/create_new_user" class="btn-create">Create New User</a>
            </div>
            <div class="user-stats">
                <div class="stat-box">
                    <h3>Total User Accounts</h3>
                    <p>1000</p>
                </div>
                <div class="stat-box">
                    <h3>Live User Accounts</h3>
                    <p>750</p>
                </div>
            </div>
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>john_doe</td>
                        <td>john@example.com</td>
                        <td>Resident</td>
                        <td>Active</td>
                        <td>
                            <a href="#" class="btn btn-view">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                    <tr>
                        <td>jane_smith</td>
                        <td>jane@example.com</td>
                        <td>Admin</td>
                        <td>Active</td>
                        <td>
                            <a href="#" class="btn btn-view">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                    <tr>
                        <td>bob_johnson</td>
                        <td>bob@example.com</td>
                        <td>Security</td>
                        <td>Inactive</td>
                        <td>
                            <a href="#" class="btn btn-view">View</a> |
                            <a href="#" class="btn btn-edit">Edit</a> |
                            <a href="#" class="btn btn-remove">Remove</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
