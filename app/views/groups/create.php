<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/side_panel.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/resident/dashboard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/groups/groups.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/form-styles.css">
    <title>Create Group | <?php echo SITENAME; ?></title>
</head>
<body>
    <?php require APPROOT . '/views/inc/components/navbar.php'; ?>
    
    <div class="dashboard-container">
        <?php 
        switch($_SESSION['user_role_id']) {
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

        <main class="groups-main">
            <?php if ($_SESSION['user_role_id'] == 1): ?>
                <aside class="groups-sidebar">
                    <h2>Group Navigation</h2>
                    <nav class="groups-nav">
                        <a href="<?php echo URLROOT; ?>/groups/index" class="btn-created-group">Groups</a>
                        <a href="<?php echo URLROOT; ?>/groups/create" class="btn-created-group">Create Group</a>
                        <a href="<?php echo URLROOT; ?>/groups/joined" class="btn-joined-groups">Joined Groups</a>
                        <a href="<?php echo URLROOT; ?>/groups/my_groups" class="btn-my-groups">My Groups</a>
                    </nav>
                </aside>
            <?php endif; ?>

            <main class="content">
                <div class="create-group-container">
                    <h1>Create New Group</h1>

                    <?php if (!empty($data['errors'])): ?>
                        <div class="error-messages">
                            <?php foreach ($data['errors'] as $error): ?>
                                <div class="error-message"><?php echo $error; ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo URLROOT; ?>/groups/create" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Group Name:</label>
                            <input type="text" name="title" id="title" value="<?php echo $data['title'] ?? ''; ?>" required maxlength="255" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Group Description:</label>
                            <textarea name="description" id="description" rows="6" required class="form-control"><?php echo $data['description'] ?? ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="category">Group Category:</label>
                            <select name="category" id="category" required class="form-control">
                                <option value="">Select a category</option>
                                <option value="hobbies" <?php echo ($data['category'] ?? '') == 'hobbies' ? 'selected' : ''; ?>>Hobbies</option>
                                <option value="sports" <?php echo ($data['category'] ?? '') == 'sports' ? 'selected' : ''; ?>>Sports</option>
                                <option value="education" <?php echo ($data['category'] ?? '') == 'education' ? 'selected' : ''; ?>>Education</option>
                                <option value="social" <?php echo ($data['category'] ?? '') == 'social' ? 'selected' : ''; ?>>Social</option>
                                <option value="professional" <?php echo ($data['category'] ?? '') == 'professional' ? 'selected' : ''; ?>>Professional</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Group Image:</label>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" class="form-control">
                            <small class="form-text text-muted">Allowed formats: JPG, PNG, GIF</small>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-submit">Create Group</button>
                            <?php if (in_array($_SESSION['user_role_id'], [2, 3])): ?>
                                <a href="<?php echo URLROOT; ?>/groups/admin_dashboard" class="btn-cancel">Cancel</a>
                            <?php else: ?>
                                <a href="<?php echo URLROOT; ?>/groups/index" class="btn-cancel">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </main>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>
</html>
