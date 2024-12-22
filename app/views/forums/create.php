<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/forums.css">
    <title>Create Forum | <?php echo SITENAME; ?></title>
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

        <main>
            <div class="create-announcement-container">
                <div class="page-header">
                    <h1>Create New Forum</h1>
                    <?php if ($_SESSION['user_role_id'] == 2): ?>
                        <a href="<?php echo URLROOT; ?>/forums/admin_dashboard" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URLROOT; ?>/forums" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    <?php endif; ?>
                </div>

                <?php if (!empty($data['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($data['errors'] as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo URLROOT; ?>/forums/create" method="POST" class="announcement-form">
                    <div class="form-group">
                        <label for="title">Forum Title:</label>
                        <input type="text" name="title" id="title"
                            class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>"
                            placeholder="Enter forum title">
                        <span class="invalid-feedback"><?php echo isset($data['title_err']) ? $data['title_err'] : ''; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="description">Forum Description:</label>
                        <textarea name="description" id="description" rows="10"
                            class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"
                            placeholder="Enter forum description"><?php echo isset($data['description']) ? $data['description'] : ''; ?></textarea>
                        <span class="invalid-feedback"><?php echo isset($data['description_err']) ? $data['description_err'] : ''; ?></span>
                    </div>

                    <div class="form-actions">
                        <?php if ($_SESSION['user_role_id'] == 2): ?>
                            <a href="<?php echo URLROOT; ?>/forums/admin_dashboard" class="btn btn-cancel">Cancel</a>
                        <?php else: ?>
                            <a href="<?php echo URLROOT; ?>/forums/index" class="btn btn-cancel">Cancel</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Create Forum</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>