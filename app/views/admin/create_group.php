
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_group.css">
    <title>Create Group | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main class="create-group-dashboard">
            <a href="<?php echo URLROOT; ?>/admin/groups" class="btn-back">Back</a>
            <section class="group-form">
                <h1>Create New Group</h1>
                <form action="<?php echo URLROOT; ?>/admin/create_group" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="group_name">Group Name:</label>
                        <input type="text" id="group_name" name="group_name" required>
                    </div>

                    <div class="form-group">
                        <label for="member_count">Maximum number of Members:</label>
                        <input type="number" id="member_count" name="member_count" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="created_by">Created By:</label>
                        <input type="text" id="created_by" name="created_by" value="<?php echo $_SESSION['user_name'] ?? ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="description">Group Description:</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="group_photo">Group Photo:</label>
                        <input type="file" id="group_photo" name="group_photo" accept="image/*">
                    </div>

                    <button type="submit" class="btn-submit">Create Group</button>
                </form>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
