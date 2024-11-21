
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once APPROOT . '/views/inc/components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/create_forum.css">
    <title>Create Forum | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container side-panel-open">
        <?php require APPROOT . '/views/inc/components/side_panel_admin.php'; ?>
        <main class="create-forum-dashboard">
            <a href="<?php echo URLROOT; ?>/admin/forums" class="btn-back">Back</a>
            <section class="forum-form">
                <h1>Create New Forum</h1>
                <form action="<?php echo URLROOT; ?>/admin/create_forum" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="forum_title">Forum Title:</label>
                        <input type="text" id="forum_title" name="forum_title" required>
                    </div>

                    <div class="form-group">
                        <label for="created_by">Created By:</label>
                        <input type="text" id="created_by" name="created_by" value="<?php echo $_SESSION['user_name'] ?? ''; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="resources">Resources:</label>
                        <input type="file" id="resources" name="resources" multiple>
                    </div>

                    <button type="submit" class="btn-submit">Create Forum</button>
                </form>
            </section>
        </main>
    </div>
    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
