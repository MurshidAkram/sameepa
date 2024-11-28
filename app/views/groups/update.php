
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
    <title>Update Group | <?php echo SITENAME; ?></title>
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

        <main class="groups-main">
            <aside class="groups-sidebar">
                <h2>Group Navigation</h2>
                <nav class="groups-nav">
                    <a href="<?php echo URLROOT; ?>/groups/index" class="btn-created-group">Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/create" class="btn-created-group">Create Group</a>
                    <a href="<?php echo URLROOT; ?>/groups/joined" class="btn-joined-groups">Joined Groups</a>
                    <a href="<?php echo URLROOT; ?>/groups/my_groups" class="btn-my-groups">My Groups</a>
                </nav>
            </aside>

            <div class="groups-content">
                <div class="create-group-container">
                    <h1>Update Group</h1>

                    <form action="<?php echo URLROOT; ?>/groups/update/1" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Group Name:</label>
                            <input type="text" name="title" id="title" value="Book Club" required maxlength="255" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Group Description:</label>
                            <textarea name="description" id="description" rows="6" required class="form-control">A community of book lovers who meet regularly to discuss various literary works.</textarea>
                        </div>

                        <div class="form-group">
                            <label for="category">Group Category:</label>
                            <select name="category" id="category" required class="form-control">
                                <option value="literature" selected>Literature</option>
                                <option value="hobbies">Hobbies</option>
                                <option value="sports">Sports</option>
                                <option value="education">Education</option>
                                <option value="social">Social</option>
                                <option value="professional">Professional</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rules">Group Rules:</label>
                            <textarea name="rules" id="rules" rows="4" class="form-control">Be respectful of others' opinions. No spoilers without warnings.</textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Update Group Image (Optional):</label>
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" class="form-control">
                            <small class="form-text text-muted">Allowed formats: JPG, PNG, GIF. Leave empty to keep current image.</small>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="btn-submit">Update Group</button>
                            <a href="<?php echo URLROOT; ?>/groups/viewgroup/1" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php require APPROOT . '/views/inc/components/footer.php'; ?>
</body>

</html>
