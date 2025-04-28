<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/posts/posts.css">
    <title>Create a post | <?php echo SITENAME; ?></title>
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

        <main class="create-post-main">
            <div class="create-post-container">
                <h1>Create a New Post</h1>

                <?php if (!empty($data['errors'])): ?>
                    <div class="error-container">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p class="error"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URLROOT; ?>/posts/create" method="POST" enctype="multipart/form-data" class="create-post-form">
                    <div class="form-group">
                        <label for="description">Post Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="What would you like to share?"
                            required><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image (Optional)</label>
                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept=".jpg, .jpeg, .png, .gif">
                        <small>Allowed file types: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-actions">
                        <a href="<?php echo URLROOT; ?>/posts" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </div>
                </form>
            </div>
        </main>
    </div>


    <?php require APPROOT . '/views/inc/components/footer.php'; ?>

</body>