<!-- views/posts/create.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Create Post | <?php echo SITENAME; ?></title>
</head>

<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>

    <div class="dashboard-container">
        <?php
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
        }
        ?>

        <main class="content">
            <div class="create-post-container">
                <h1>Create New Post</h1>

                <?php if (!empty($data['errors'])): ?>
                    <div class="error-messages">
                        <?php foreach ($data['errors'] as $error): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URLROOT; ?>/posts/create" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="content">What's on your mind?</label>
                        <textarea name="content" id="content" rows="6" required
                            class="form-control"><?php echo $data['content']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Add Image (Optional):</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif"
                            class="form-control">
                        <small class="form-text text-muted">Allowed formats: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Create Post</button>
                        <a href="<?php echo URLROOT; ?>/posts" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>